<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

final class AuthController extends Controller
{
    public function login(): void { $this->view('login', ['title' => 'Connexion | Rachel Naturo']); }
    public function authenticate(): void
    {
        $user = User::findByEmail(trim($_POST['email'] ?? ''));
        if (!$user || !password_verify($_POST['password'] ?? '', $user['password'])) { $this->view('login', ['title' => 'Connexion | Rachel Naturo', 'error' => 'Email ou mot de passe incorrect.']); return; }
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']];
        $this->redirect($user['role'] === 'admin' ? '/admin' : '/app');
    }
    public function logout(): void { session_destroy(); $this->redirect('/'); }
}
