<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Content;
use App\Models\User;

final class AdminController extends Controller
{
    public function dashboard(): void { $this->requireAuth(true); $this->view('admin/dashboard', ['title' => 'Pilotage | Rachel Naturo', 'conseils' => Content::all('conseil'), 'users' => User::all()]); }
    public function conseils(): void { $this->requireAuth(true); $this->view('admin/conseils', ['title' => 'Contenus | Rachel Naturo', 'contents' => array_merge(Content::all('conseil'), Content::all('live'), Content::all('archive'))]); }
    public function storeConseil(): void { $this->requireAuth(true); Content::create($_POST); $this->redirect('/admin/conseils'); }
    public function users(): void { $this->requireAuth(true); $this->view('admin/users', ['title' => 'Utilisateurs | Rachel Naturo', 'users' => User::all()]); }
    public function storeUser(): void { $this->requireAuth(true); User::create($_POST); $this->redirect('/admin/utilisateurs'); }
    public function updateUser(): void { $this->requireAuth(true); User::updateRole((int) $_POST['id'], $_POST['role'] === 'admin' ? 'admin' : 'user'); $this->redirect('/admin/utilisateurs'); }
    public function deleteUser(): void { $this->requireAuth(true); if ((int) $_POST['id'] !== (int) $_SESSION['user']['id']) User::delete((int) $_POST['id']); $this->redirect('/admin/utilisateurs'); }
}
