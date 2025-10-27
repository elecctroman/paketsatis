<?php

namespace Core;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private $notFoundHandler = null;

    public function add(string $method, string $path, callable $handler, array $options = []): void
    {
        $method = strtoupper($method);
        $compiled = $this->compileRoute($path);
        $this->routes[$method][] = [
            'handler' => $handler,
            'options' => $options,
            'regex' => $compiled['regex'],
            'variables' => $compiled['variables'],
            'middlewares' => array_merge($this->middlewares, $options['middleware'] ?? []),
        ];
    }

    public function group(array $options, callable $callback): void
    {
        $previous = $this->middlewares;
        if (isset($options['middleware'])) {
            $this->middlewares = array_merge($this->middlewares, (array) $options['middleware']);
        }
        $callback($this);
        $this->middlewares = $previous;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getPath();
        $candidateRoutes = $this->routes[$method] ?? [];
        if ($method === 'HEAD') {
            $candidateRoutes = array_merge($candidateRoutes, $this->routes['GET'] ?? []);
        }
        foreach ($candidateRoutes as $route) {
            if (!preg_match($route['regex'], $path, $matches)) {
                continue;
            }
            $params = [];
            foreach ($route['variables'] as $variable) {
                if (isset($matches[$variable])) {
                    $params[$variable] = $matches[$variable];
                }
            }
            $request->setRouteParams($params);
            $handler = $route['handler'];
            $middlewares = $route['middlewares'];
            $runner = array_reduce(
                array_reverse($middlewares),
                function ($next, $middleware) {
                    return function (Request $request) use ($middleware, $next) {
                        return $middleware($request, $next);
                    };
                },
                fn (Request $req) => $handler($req)
            );
            $result = $runner($request);
            return $result instanceof Response ? $result : new Response((string) $result);
        }
        if ($this->notFoundHandler) {
            $result = call_user_func($this->notFoundHandler, $request);
            return $result instanceof Response ? $result : new Response((string) $result, 404);
        }
        return new Response('Not Found', 404);
    }

    public function setNotFoundHandler(callable $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    private function compileRoute(string $path): array
    {
        $path = '/' . ltrim($path, '/');
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }
        $variables = [];
        $pattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)(?::([^}]+))?\}/', function ($matches) use (&$variables) {
            $variables[] = $matches[1];
            $expression = $matches[2] ?? '[^/]+';
            return '(?P<' . $matches[1] . '>' . $expression . ')';
        }, $path);
        if ($pattern === '') {
            $pattern = '/';
        }
        $regex = '#^' . $pattern . '/?$#u';
        return ['regex' => $regex, 'variables' => $variables];
    }
}
