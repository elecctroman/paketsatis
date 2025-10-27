<?php
ob_start();
require __DIR__ . '/bootstrap.php';

use Core\Request;
use Core\Response;
use Core\Router;
use Core\Auth;
use Core\Rbac;
use Core\Logger;
use App\Controllers\Frontend\HomeController;
use App\Controllers\Frontend\CheckoutController;
use App\Controllers\Frontend\ServiceController as FrontServiceController;
use App\Controllers\Frontend\ContentController;
use App\Controllers\Frontend\OrderTrackingController;
use App\Controllers\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ServiceController;

$request = new Request();
$response = new Response();
$router = new Router();
$router->setNotFoundHandler(function () use ($view) {
    return new Response($view->render('errors.404'), 404);
});

$router->add('GET', '/', function (Request $req) use ($response, $view) {
    $controller = new HomeController($req, $response, $view);
    return $controller->index();
});

$router->add('GET', '/categories/{slug}', function (Request $req) use ($response, $view) {
    return (new FrontServiceController($req, $response, $view))->category($req);
});

$router->add('GET', '/services/{slug}', function (Request $req) use ($response, $view) {
    return (new FrontServiceController($req, $response, $view))->show($req);
});

$router->add('GET', '/blog', function (Request $req) use ($response, $view) {
    return (new ContentController($req, $response, $view))->blogIndex();
});

$router->add('GET', '/blog/{slug}', function (Request $req) use ($response, $view) {
    return (new ContentController($req, $response, $view))->blogShow($req);
});

$router->add('GET', '/pages/{slug}', function (Request $req) use ($response, $view) {
    return (new ContentController($req, $response, $view))->page($req);
});

$router->add('GET', '/order-track', function (Request $req) use ($response, $view) {
    return (new OrderTrackingController($req, $response, $view))->show();
});

$router->add('POST', '/order-track', function (Request $req) use ($response, $view) {
    return (new OrderTrackingController($req, $response, $view))->search($req);
});

$router->add('GET', '/checkout', function (Request $req) use ($response, $view) {
    return (new CheckoutController($req, $response, $view))->show();
});

$router->add('POST', '/checkout/process', function (Request $req) use ($response, $view) {
    return (new CheckoutController($req, $response, $view))->process($req);
});

$router->add('GET', '/login', function (Request $req) use ($response, $view) {
    return (new AuthController($req, $response, $view))->showLogin();
});

$router->add('POST', '/login', function (Request $req) use ($response, $view) {
    return (new AuthController($req, $response, $view))->login($req);
});

$router->add('GET', '/logout', function (Request $req) use ($response, $view) {
    return (new AuthController($req, $response, $view))->logout();
});

$router->add('GET', '/admin', function (Request $req) use ($response, $view) {
    if (!Auth::check() || !Rbac::authorize('/admin', Auth::user())) {
        return new Response('Unauthorized', 403);
    }
    return (new DashboardController($req, $response, $view))->index();
});

$router->add('GET', '/admin/services', function (Request $req) use ($response, $view) {
    if (!Auth::check() || !Rbac::authorize('/admin/services', Auth::user())) {
        return new Response('Unauthorized', 403);
    }
    return (new ServiceController($req, $response, $view))->index();
});

$router->add('POST', '/admin/services', function (Request $req) use ($response, $view) {
    if (!Auth::check() || !Rbac::authorize('/admin/services', Auth::user())) {
        return new Response('Unauthorized', 403);
    }
    return (new ServiceController($req, $response, $view))->store($req);
});

try {
    $result = $router->dispatch($request);
    $result->send();
} catch (Throwable $e) {
    Logger::error('Unhandled exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    http_response_code(500);
    echo $view->render('errors.500');
}
