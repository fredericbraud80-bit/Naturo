<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Content;

final class AppController extends Controller
{
    public function home(): void { $this->requireAuth(); $this->view('app-home', ['title' => 'Mon espace | Rachel Naturo', 'conseils' => Content::all('conseil'), 'live' => Content::all('live')]); }
    public function conseils(): void { $this->requireAuth(); $this->view('conseils', ['title' => 'Conseils | Rachel Naturo', 'conseils' => Content::all('conseil')]); }
    public function archives(): void { $this->requireAuth(); $this->view('archives', ['title' => 'Archives | Rachel Naturo', 'archives' => Content::all('archive')]); }
    public function live(): void { $this->requireAuth(); $this->view('live', ['title' => 'Live | Rachel Naturo', 'live' => Content::all('live')]); }
}
