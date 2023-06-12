<?php declare(strict_types=1);


namespace App\Provider;



use App\Controller\MovieController;
use App\Controller\WelcomeController;

class RouteProvider extends ServiceProvider
{
    public function register()
    {
        $route = $this->container->get('route');

        $route->get('/welcome', [WelcomeController::class, 'welcome']);

        // movie
        $route->get('/movie/index', [MovieController::class, 'index']);
        $route->get('/movie/detail', [MovieController::class, 'detail']);
        $route->get('/movie/nav', [MovieController::class, 'nav']);
    }

}
