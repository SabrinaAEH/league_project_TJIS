<?php

namespace App\Routes;

use App\Controllers\HomeController;

class Router
{
    public function handleRequest()
    {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
            default:
                $controller = new HomeController();
                $controller->index();
                break;
        }
    }
}
