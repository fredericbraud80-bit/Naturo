<?php
namespace App\Core;

abstract class Controller
{
    protected function view(string $template, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../Views/layout.php';
    }
    protected function redirect(string $path): never { header('Location: ' . app_url($path)); exit; }
    protected function requireAuth(bool $admin = false): void
    {
        if (empty($_SESSION['user'])) $this->redirect('/connexion');
        if ($admin && ($_SESSION['user']['role'] ?? '') !== 'admin') $this->redirect('/app');
    }
}
