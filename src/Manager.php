<?php

namespace App\Packages\Directive;

use App\Packages\Directive\Contracts\Directiveable;

/**
 * Class Manager
 * @package App\Packages\Directive
 */
class Manager
{
    /**
     * @param $directive
     */
    public static function register($directive)
    {
        Registry::add($directive);
    }

    /**
     * @param $directiveable
     * @return Collection
     */
    public static function resolve(Directiveable $directiveable)
    {
        return $directiveable->getDirectives();
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {
        $class = Registry::get(Resolver::nameFromMethod($method));
        $context = $params[0];
        $data = $context->getDirectiveData($method);

        return Factory::make($class, $context, $data)->run();
    }

    public static function store()
    {
        return Store::class;
    }
}
