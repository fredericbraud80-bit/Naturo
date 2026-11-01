<?php
declare(strict_types=1);

session_start();
date_default_timezone_set('Europe/Paris');

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$scriptBasename = basename($scriptName);
$appBasePath = in_array($scriptBasename, ['index.php', 'server.php'], true) ? dirname($scriptName) : '';
$appBasePath = str_replace('\\', '/', $appBasePath);
define('APP_BASE_PATH', rtrim($appBasePath === '.' ? '' : $appBasePath, '/'));

function app_url(string $path = '/'): string
{
    return APP_BASE_PATH . '/' . ltrim($path, '/');
}

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    $file = __DIR__ . '/../' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) require_once $file;
});

$databasePath = __DIR__ . '/../../storage/database.sqlite';
if (!is_dir(dirname($databasePath))) mkdir(dirname($databasePath), 0775, true);
$db = new PDO('sqlite:' . $databasePath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
App\Core\Database::set($db);
App\Core\Database::migrate();
