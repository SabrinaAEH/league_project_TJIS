<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $section_titles = [
            'teams' => 'La team à la une',
            'players' => 'Les players à la une',
            'matches' => 'Le dernier match'
        ];
        echo $this->twig->render('home.twig', [
            'section_titles' => $section_titles
        ]);
    }
}
