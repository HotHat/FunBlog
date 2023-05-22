<?php declare(strict_types=1);


namespace FunBlog\Provider;



use FunBlog\Controller\WelcomeController;

class RouteProvider extends ServiceProvider
{
    public function register()
    {
        $route = $this->container->get('route');
        
        $route->get('/welcome', [WelcomeController::class, 'welcome']);
    }
    
}