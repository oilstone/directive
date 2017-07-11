<?php

namespace App\Packages\Directive;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Class Collection
 * @package App\Packages\Directive
 */
class Collection implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    protected $directives = [];

    /**
     * Collection constructor.
     *
     * @param array $directives
     */
    public function __construct($directives = [])
    {
        $this->directives = $directives;
    }

    /**
     * @param $directive
     * @param string|null $key
     */
    public function add($directive, string $key = null)
    {
        $this->directives[$key ?? $directive::getName()] = $directive;
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->directives);
    }

    /**
     * Run all directives in collection and save to directive data storage
     */
    public function run()
    {
        foreach ($this->directives as $index => $directive) {
            if (method_exists($directive, "run")) {
                $directive->run();
            } else if (is_array($directive) || $directive instanceof Traversable) {
                foreach ($directive as $subIndex => $subDirective) {
                    if (method_exists($subDirective, "run")) {
                        $subDirective->run();
                    }
                }
            }
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->directives);
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        $directive = Resolver::nameFromMethod($method);

        return $this->get($directive)->run();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->directives[$name];
    }
}
