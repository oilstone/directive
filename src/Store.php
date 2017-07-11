<?php

namespace App\Packages\Directive;


use App\Packages\Directive\Contracts\Store as StoreInterface;

/**
 * Class Store
 * @package App\Packages\Directive
 */
class Store implements StoreInterface
{
    /**
     * @var array
     */
    public static $store = [];

    /**
     * @param string $class
     * @param int $id
     * @param string $key
     * @param $data
     * @return mixed|void
     */
    public static function add(string $class, int $id, string $key, $data)
    {
        self::$store[$class][$id][$key] = $data;
    }

    /**
     * @param string $class
     * @param int $id
     * @param string $key
     * @return mixed
     */
    public static function retrieve(string $class, ?int $id = null, ?string $key = null)
    {
        switch(true) {
            case $class && $id && $key:
                return self::$store[$class][$id][$key] ?? null;

            case $class && $id:
                return self::$store[$class][$id] ?? [];

            case $class:
                return self::$store[$class] ?? [];
        }

        return null;
    }
}