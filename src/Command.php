<?php

namespace App\Packages\Directive;

use App\Packages\Directive\Contracts\Directiveable;
use App\Packages\Directive\Contracts\Store;
use App\Packages\Directive\Store as DefaultStore;
use Exception;
use Illuminate\Support\Str;

/**
 * Class Directive
 * @package App\Packages\Directive
 */
abstract class Directive
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Directiveable
     */
    protected $context;

    /**
     * The key used to identify data returned on execute
     *
     * @var string
     */
    protected $directive_key;

    /**
     * The directive data storage class name
     *
     * @var string
     */
    protected $store = DefaultStore::class;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->directive_key ?? substr(static::getName(), strpos(static::getName(), '_') + 1);
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return Str::snake(class_basename(static::class));
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(?array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $store
     * @return $this
     * @throws Exception
     */
    public function setStore(string $store)
    {
        if (!is_subclass_of($store, Store::class)) {
            throw new Exception('Invalid directive storage');
        }

        $this->store = $store;

        return $this;
    }

    /**
     * @param Directiveable|null $context
     * @return $this
     */
    public function setContext(?Directiveable $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $result = $this->execute();

        if($this->context) {
            $this->store::add(Resolver::nameFromMethod(class_basename($this->context)), $this->context->id, $this->getKey(), $result);
        }

        return $result;
    }

    /**
     * @return mixed
     */
    abstract public function execute();
}