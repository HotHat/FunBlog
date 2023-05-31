<?php declare(strict_types=1);


namespace App\Provider;


use App\Controller\WelcomeController;
use App\Facades\Facade;
use QueryBuilder\Builder;
use QueryBuilder\MysqlConnection;
use function App\Utils\app;
use function App\Utils\glob_recur;
use function DI\create;

class AppProvider extends ServiceProvider
{
    protected array $controllers = [
        WelcomeController::class
    ];

    private function initController() {
        $base = $this->container->get('path');
        $s = glob_recur($base . '/Controller', '/.*\\.php$/');

        $controllers = [];
        foreach ($s as $it) {
            $c = str_replace($base, 'App', $it);
            $c = str_replace('/', '\\', $c);
            $c = str_replace('.php', '', $c);

            $controllers[] = $c;
        }

        // var_dump($controllers);
        // var_dump($this->controllers);
        //
        foreach ($controllers as $controller) {
            $this->container->set($controller, create($controller));
        }
    }

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

        $this->initController();


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
        $this->container->set('db', $builder);


        // facades
        Facade::setFacadeApplication($this->container);

    }


}
