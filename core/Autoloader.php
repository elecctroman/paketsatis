<?php
/**
 * Simple PSR-4 compliant autoloader.
 */
class Autoloader
{
    private array $prefixes = [];

    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function addNamespace(string $prefix, string $baseDir): void
    {
        $prefix = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->prefixes[$prefix][] = $baseDir;
    }

    public function loadClass(string $class): void
    {
        foreach ($this->prefixes as $prefix => $baseDirs) {
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                continue;
            }
            $relativeClass = substr($class, $len);
            $relativeClass = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass);
            foreach ($baseDirs as $baseDir) {
                $file = $baseDir . $relativeClass . '.php';
                if (is_file($file)) {
                    require $file;
                    return;
                }
            }
        }
    }
}
