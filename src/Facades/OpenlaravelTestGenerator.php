<?php

namespace Wasinpwg\OpenAITestGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wasinpwg\OpenAITestGenerator\OpenAITestGenerator
 */
class OpenAITestGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wasinpwg\OpenAITestGenerator\OpenAITestGenerator::class;
    }
}
