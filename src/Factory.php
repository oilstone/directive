<?php

namespace App\Packages\Directive;

/**
 * Class Factory
 * @package App\Packages\Directive
 */
class Factory
{
    /**
     * @param $class
     * @param null $context
     * @param array|null $data
     * @return mixed
     */
    public static function make($class, $context = null, ?array $data = [])
    {
        return app()->make($class)->setContext($context)->setData($data ?? []);
    }
}