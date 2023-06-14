<?php

namespace Wasinpwg\OpenlaravelTestGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wasinpwg\OpenlaravelTestGenerator\OpenlaravelTestGenerator
 */
class OpenlaravelTestGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wasinpwg\OpenlaravelTestGenerator\OpenlaravelTestGenerator::class;
    }
}
