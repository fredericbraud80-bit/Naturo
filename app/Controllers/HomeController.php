<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Content;

final class HomeController extends Controller
{
    public function landing(): void { $this->view('landing', ['title' => 'Rachel Naturo', 'live' => Content::all('live')]); }
}
