<?php
require_once __DIR__ . '/app/Core/bootstrap.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AppController;
use App\Controllers\AdminController;

$router = new Router();
$router->get('/', [HomeController::class, 'landing']);
$router->get('/connexion', [AuthController::class, 'login']);
$router->post('/connexion', [AuthController::class, 'authenticate']);
$router->post('/deconnexion', [AuthController::class, 'logout']);
$router->get('/app', [AppController::class, 'home']);
$router->get('/app/conseils', [AppController::class, 'conseils']);
$router->get('/app/archives', [AppController::class, 'archives']);
$router->get('/app/live', [AppController::class, 'live']);
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/conseils', [AdminController::class, 'conseils']);
$router->post('/admin/conseils', [AdminController::class, 'storeConseil']);
$router->get('/admin/utilisateurs', [AdminController::class, 'users']);
$router->post('/admin/utilisateurs', [AdminController::class, 'storeUser']);
$router->post('/admin/utilisateurs/modifier', [AdminController::class, 'updateUser']);
$router->post('/admin/utilisateurs/supprimer', [AdminController::class, 'deleteUser']);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
if (APP_BASE_PATH !== '' && str_starts_with($path, APP_BASE_PATH)) {
	$path = substr($path, strlen(APP_BASE_PATH)) ?: '/';
}
$router->dispatch($_SERVER['REQUEST_METHOD'], '/' . trim($path, '/'));
