<?php declare(strict_types=1);


namespace App\Facades;


use App\Facades\Facade;

class Markdown extends Facade
{

    static function getFacadeAccessor(): string
    {
        return 'markdown';
    }
}
