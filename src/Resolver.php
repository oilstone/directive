<?php

namespace App\Packages\Directive;

use Illuminate\Support\Str;

/**
 * Class Resolver
 * @package App\Packages\Directive
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
