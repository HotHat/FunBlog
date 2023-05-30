<?php declare(strict_types=1);


namespace App\Provider;


use DI\Container;

class ServiceProvider
{
    protected Container $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
        
    }
    
    public function register() {
    
    }
    
}