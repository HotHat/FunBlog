<?php declare(strict_types=1);

namespace App;

use App\Middleware\FooMiddleware;
use DI\Container;
use DI\ContainerBuilder;
use FastRoute\Dispatcher\GroupCountBased;
use App\Provider\AppProvider;
use App\Provider\RouteProvider;
use Laminas\Diactoros\ServerRequestFactory;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;

class Application
{
    protected array $middleware = [];
    protected Container $container;
    protected $route;
    
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(false);
        
        $this->container = $builder->build();
        
        $this->init();
    }
    
    protected function init() {
        $this->setBasePath();
        
        $this->initException();
        
        $this->initProvider();
        
        $this->addMiddleware();
        
    }
    
    protected function setBasePath() {
        $this->container->set('path', __DIR__);
        $this->container->set('path.public', __DIR__ . DIRECTORY_SEPARATOR);
        $this->container->set('path.resources', __DIR__ . DIRECTORY_SEPARATOR);
        $this->container->set('path.views', __DIR__ . DIRECTORY_SEPARATOR);
    }
    
    
    protected function initProvider() {
        $providers = [
            AppProvider::class,
            RouteProvider::class,
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
}