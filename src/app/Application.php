<?php declare(strict_types=1);

namespace App;

use App\Middleware\FooMiddleware;
use App\Provider\ServiceProvider;
use DI\Container;
use DI\ContainerBuilder;
use ErrorException;
use FastRoute\Dispatcher\GroupCountBased;
use App\Provider\AppProvider;
use App\Provider\RouteProvider;
use Laminas\Diactoros\ServerRequestFactory;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Relay\Relay;
use Throwable;

class Application implements ContainerInterface
{
    protected array $middleware = [];
    protected Container $container;
    protected $route;

    protected static $app;

    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(false);

        $this->container = $builder->build();

        $this->init();

        //
        static::$app = $this;
    }

    public static function getInstance() {
        if (!static::$app) {
            static::$app = new static();
        }

        return static::$app;
    }



    protected function init() {
        $this->setBasePath();

        $this->initException();

        $this->initProvider();

        $this->addMiddleware();

        $this->initTemplateEngine();
    }

    protected function setBasePath() {
        $this->container->set('path', __DIR__);
        $this->container->set('path.public', __DIR__ . '/../../public');
        $this->container->set('path.resources', __DIR__ . '/../resources');
        $this->container->set('path.views', __DIR__ . '/../resources/views');
        $this->container->set('path.runtime', __DIR__ . '/../runtime');
    }


    protected function initProvider() {
        $providers = [
            AppProvider::class,
            RouteProvider::class,
            ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $pro = new $provider($this->container);
            $pro->register();
        }
    }

    protected function addMiddleware() {

    }


    protected function initException() {
        register_shutdown_function(function(){
            $error = error_get_last();
            if($error){
                throw new ErrorException($error['message'], -1, $error['type'], $error['file'], $error['line']);
            }
        });

        set_error_handler(
            function($level, $error, $file, $line){
                if(0 === error_reporting()){
                    return false;
                }
                throw new ErrorException($error, -1, $level, $file, $line);
            },
            E_ALL
        );

        set_exception_handler(function (Throwable $exception) {
            echo printf("\nfile: %s \nline: %s \nmessage: %s \n",
                $exception->getFile(),
                $exception->getLine(),
                $exception->getMessage(),
            );
            echo 'trace: ', PHP_EOL;
            foreach ($exception->getTrace() as $it) {
                var_dump($it);
            }
        });
    }

    public function run() {
        $this->middleware[] = new FooMiddleware();

        $route = $this->container->get('route');

        $dispatcher =  new GroupCountBased($route->getData());
        $this->middleware[] = new FastRoute($dispatcher);

        $this->middleware[] = new RequestHandler($this->container);
        $requestHandler = new Relay($this->middleware);
        $response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

        $emitter = new SapiEmitter();

        $emitter->emit($response);
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Entry.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     */
    public function get(string $id) {
        return $this->container->get($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    protected function initTemplateEngine()
    {
        $loader = new \Twig\Loader\FilesystemLoader($this->container->get('path.views'));
        $runtime = $this->container->get('path.runtime');
        $twig = new \Twig\Environment($loader, [
            // 'cache' => $runtime . '/template',
        ]);

        $this->container->set('template_engine', $twig);
    }
}
