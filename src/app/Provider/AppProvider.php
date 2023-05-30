<?php declare(strict_types=1);


namespace App\Provider;


use App\Controller\WelcomeController;
use App\Facades\Facade;
use QueryBuilder\Builder;
use QueryBuilder\MysqlConnection;
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
        
        // database
        $connection = new MysqlConnection(
            'mysql',
            3306,
            'xapp',
            'root',
            '123456'
        );
    
        $this->container->set('connection', $connection);
        
        $builder = new Builder($connection);
        $this->container->set('query-builder', $builder);
        
        
        // facades
        Facade::setFacadeApplication($this->container);
    
    }
    
    
}