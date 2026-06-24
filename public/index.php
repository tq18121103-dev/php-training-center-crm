<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PaymentController;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\HealthController;
use App\Controllers\StudentController;

session_start();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);

$router->get('/students', [StudentController::class, 'index']);
$router->get('/students/create', [StudentController::class, 'create']);
$router->post('/students', [StudentController::class, 'store']);

$router->get('/students/edit', [StudentController::class, 'edit']);
$router->post('/students/update', [StudentController::class, 'update']);
$router->post('/students/delete', [StudentController::class, 'delete']);

$router->get('/payments', [PaymentController::class, 'index']);
$router->get('/payments/create', [PaymentController::class, 'create']);
$router->post('/payments', [PaymentController::class, 'store']);
$router->get('/payments/edit', [PaymentController::class, 'edit']);
$router->post('/payments/update', [PaymentController::class, 'update']);
$router->post('/payments/delete', [PaymentController::class, 'delete']);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);