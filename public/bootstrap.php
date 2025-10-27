<?php
require __DIR__ . '/../core/Autoloader.php';

$autoloader = new \Autoloader();
$autoloader->addNamespace('Core', __DIR__ . '/../core');
$autoloader->addNamespace('App', __DIR__ . '/../app');
$autoloader->register();

use Core\Config;
use Core\DB;
use Core\Session;
use Core\View;
use Core\Rbac;

Config::load(__DIR__ . '/../config/env.php');
DB::init(Config::get('database'));
Session::start();

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
Rbac::load($permissions, $routePermissions);

$view = new View(__DIR__ . '/../app/Views');
$view->share('appVersion', Config::get('app.version'));

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $version = Config::get('app.version', '1.0.0');
        return '/' . ltrim($path, '/') . '?v=' . urlencode($version);
    }
}
