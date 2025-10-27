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
        $this->routes[$method][$path] = ['handler' => $handler, 'options' => $options];
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
        $route = $this->routes[$method][$path] ?? null;
        if (!$route) {
            if ($this->notFoundHandler) {
                $result = call_user_func($this->notFoundHandler, $request);
                return $result instanceof Response ? $result : new Response((string) $result, 404);
            }
            return new Response('Not Found', 404);
        }
        $handler = $route['handler'];
        $options = $route['options'];
        $middlewares = array_merge($this->middlewares, $options['middleware'] ?? []);
        $runner = array_reduce(array_reverse($middlewares), function ($next, $middleware) {
            return function (Request $request) use ($middleware, $next) {
                return $middleware($request, $next);
            };
        }, fn (Request $req) => $handler($req));
        $result = $runner($request);
        return $result instanceof Response ? $result : new Response((string) $result);
    }

    public function setNotFoundHandler(callable $handler): void
    {
        $this->notFoundHandler = $handler;
    }
}
