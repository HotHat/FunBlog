<?php declare(strict_types=1);


namespace App\Provider;


use App\Utils\HyperDown;
use DI\Container;
use function DI\create;

class ServiceProvider
{
    protected Container $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
        
    }
    
    public function register() {
        // Markdown parser
        $this->container->set('markdown', create(HyperDown::class));
    }
    
}