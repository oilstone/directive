<?php

namespace Oilstone\Directive;

use Illuminate\Support\Str;

/**
 * Class Resolver
 * @package Oilstone\Directive
 */
class Resolver
{
    /**
     * @param $class
     * @return string
     */
    public static function nameFromMethod($class)
    {
        return Str::snake($class);
    }
}
