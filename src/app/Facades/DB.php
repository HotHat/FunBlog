<?php declare(strict_types=1);


namespace App\Facades;


class DB extends Facade
{

    static function getFacadeAccessor(): string
    {
        return 'db';
    }
}
