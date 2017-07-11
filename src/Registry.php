<?php

namespace App\Packages\Directive;

/**
 * Class Registry
 * @package App\Packages\Directive
 */
class Registry
{
    /**
     * @var array
     */
    protected static $directives = [];

    /**
     * @param $directive
     */
    public static function add($directive)
    {
        static::$directives[$directive::getName()] = $directive;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public static function get(string $name)
    {
        if(isset(static::$directives[$name]) && class_exists(static::$directives[$name])) {
            return static::$directives[$name];
        }

        throw new \Exception('Directive class not found: ' . $name);
    }
}
