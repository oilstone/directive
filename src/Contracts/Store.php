<?php

namespace Oilstone\Directive\Contracts;

/**
 * Interface Store
 * @package Oilstone\Directive\Contracts
 */
interface Store
{
    /**
     * @param string $class
     * @param int $id
     * @param string $key
     * @param $data
     * @return mixed
     */
    public static function add(string $class, int $id, string $key, $data);

    /**
     * @param string $class
     * @param int $id
     * @param string $key
     * @return mixed
     */
    public static function retrieve(string $class, int $id, string $key);
}