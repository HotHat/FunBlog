<?php declare(strict_types=1);


namespace App\Facades;


use DI\Container;

abstract class Facade
{
    protected static Container $container;
    
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static array $resolvedInstance;
    
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
    
        if (! $instance) {
            throw new \RuntimeException('A facade root has not been set.');
        }
    
        return $instance->$method(...$args);
    }
    
    abstract static function getFacadeAccessor(): string;
    
    
    public static function setFacadeApplication($app)
    {
        static::$container = $app;
    }
    
    
    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function getFacadeRoot()
    {
        $name = static::getFacadeAccessor();
        
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
    
        static::$resolvedInstance[$name] = static::$container->get($name);
        
        return static::$resolvedInstance[$name];
    }
}