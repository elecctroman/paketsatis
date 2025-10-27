<?php
require __DIR__ . '/../core/Autoloader.php';

$autoloader = new \Autoloader();
$autoloader->addNamespace('Core', __DIR__ . '/../core');
$autoloader->addNamespace('App', __DIR__ . '/../app');
$autoloader->register();

\Core\Config::load(__DIR__ . '/../config/env.php');
\Core\DB::init(\Core\Config::get('database'));
\Core\Session::start();

$permissions = [
    'owner' => ['manage_services','view_orders','manage_orders','manage_content','manage_settings'],
    'admin' => ['manage_services','view_orders','manage_orders','manage_content'],
    'editor' => ['manage_content'],
    'support' => ['view_orders'],
    'member' => []
];
$routePermissions = [
    '/admin' => 'view_orders',
    '/admin/services' => 'manage_services'
];
\Core\Rbac::load($permissions, $routePermissions);

if (!class_exists('Core\\View', false)) {
    $viewClassPath = realpath(__DIR__ . '/../core/View.php');
    if ($viewClassPath !== false) {
        require_once $viewClassPath;
    }
}

$view = new \Core\View(__DIR__ . '/../app/Views');
$view->share('appVersion', \Core\Config::get('app.version'));

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $version = \Core\Config::get('app.version', '1.0.0');
        return '/' . ltrim($path, '/') . '?v=' . urlencode($version);
    }
}
