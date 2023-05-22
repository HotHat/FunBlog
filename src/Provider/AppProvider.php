<?php declare(strict_types=1);


namespace FunBlog\Provider;


use FunBlog\Controller\WelcomeController;
use function DI\create;

class AppProvider extends ServiceProvider
{
    protected array $controllers = [
        WelcomeController::class
    ];
    
    public function register()
    {
        $options = [
            'routeParser' => 'FastRoute\\RouteParser\\Std',
            'dataGenerator' => 'FastRoute\\DataGenerator\\GroupCountBased',
            'dispatcher' => 'FastRoute\\Dispatcher\\GroupCountBased',
            'routeCollector' => 'FastRoute\\RouteCollector',
        ];
    
        /** @var RouteCollector $routeCollector */
        $routeCollector = new $options['routeCollector'](
            new $options['routeParser'], new $options['dataGenerator']
        );
        
        $this->container->set('route', $routeCollector);
    
        
        //
        foreach ($this->controllers as $controller) {
    
            $this->container->set($controller, create($controller));
        }
    }
    
    
}