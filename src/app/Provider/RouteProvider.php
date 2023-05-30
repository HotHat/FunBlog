<?php declare(strict_types=1);


namespace App\Provider;



use App\Controller\WelcomeController;

class RouteProvider extends ServiceProvider
{
    public function register()
    {
        $route = $this->container->get('route');
        
        $route->get('/welcome', [WelcomeController::class, 'welcome']);
    }
    
}