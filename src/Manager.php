<?php

namespace Oilstone\Directive;

use Oilstone\Directive\Contracts\Directivable;

/**
 * Class Manager
 * @package Oilstone\Directive
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
    public static function resolve(Directivable $directiveable)
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
