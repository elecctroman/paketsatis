<?php

namespace Core;

class View
{
    private string $basePath;
    private array $shared = [];
    private ?string $layout = null;
    private array $sections = [];
    private array $sectionStack = [];

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function share(string $key, $value): void
    {
        $this->shared[$key] = $value;
    }

    public function render(string $view, array $data = []): string
    {
        $path = $this->basePath . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
        if (!is_file($path)) {
            throw new \RuntimeException("View {$view} not found");
        }
        $this->sections = [];
        $this->layout = null;
        $this->sectionStack = [];
        $vars = array_merge($this->shared, $data);
        extract($vars, EXTR_OVERWRITE);
        ob_start();
        include $path;
        $content = ob_get_clean();
        if ($this->layout) {
            $layoutPath = $this->basePath . str_replace('.', DIRECTORY_SEPARATOR, $this->layout) . '.php';
            if (!is_file($layoutPath)) {
                throw new \RuntimeException("Layout {$this->layout} not found");
            }
            $content_for_layout = $content;
            extract($vars, EXTR_SKIP);
            ob_start();
            include $layoutPath;
            return ob_get_clean();
        }
        return $content;
    }

    public function extend(string $layout): void
    {
        $this->layout = $layout;
    }

    public function start(string $section): void
    {
        $this->sectionStack[] = $section;
        ob_start();
    }

    public function stop(): void
    {
        $section = array_pop($this->sectionStack);
        $this->sections[$section] = ob_get_clean();
    }

    public function section(string $section, string $default = ''): string
    {
        return $this->sections[$section] ?? $default;
    }
}
