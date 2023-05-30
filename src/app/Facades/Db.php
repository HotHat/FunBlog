<?php declare(strict_types=1);


namespace App\Facades;


class Db extends Facade
{
    
    static function getFacadeAccessor(): string
    {
        return 'query-builder';
    }
}