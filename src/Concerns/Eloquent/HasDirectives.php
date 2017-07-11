<?php

namespace App\Packages\Directive\Concerns\Eloquent;

use App\Packages\Directive\Collection;
use App\Packages\Directive\Contracts\Directivable;
use App\Packages\Directive\Factory;
use App\Packages\Directive\Manager;
use App\Packages\Directive\Registry;
use App\Packages\Directive\Resolver;
use Illuminate\Support\Collection as BaseCollection;

/**
 * Trait HasDirectives
 * @package App\Packages\Directive\Concerns\Eloquent
 */
trait HasDirectives
{
    /**
     * @return Collection
     */
    public function getDirectives(): Collection
    {
        $directives = $this->directives()->get();

        $collection = new Collection();

        foreach ($directives as $directive) {
            $collection->add(Factory::make(Registry::get($directive->name), $this, $directive->data));
        }

        foreach ($this->getRelations() as $relation_key => $relation) {
            $relation_directives = [];

            if ($relation instanceof BaseCollection) {
                foreach ($relation as $directiveable) {
                    if ($directiveable instanceof Directivable) {
                        $directives = $directiveable->getDirectives();

                        if (count($directives)) {
                            $relation_directives[] = $directives;
                        }
                    }
                }
            }

            if ($relation_directives) {
                $collection->add($relation_directives, $relation_key);
            }
        }

        return $collection;
    }

    /**
     * Dynamically retrieve attributes or directive data on the class.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (method_exists($this, 'getAttribute') && ($value = $this->getAttribute($key)) !== null) {
            return $value;
        }

        if (method_exists($this, 'getRelationValue') && ($value = $this->getRelationValue($key)) !== null) {
            return $value;
        }

        return $this->getDirectiveStoreData($key);
    }

    /**
     * @param $key
     * @return null
     */
    public function getDirectiveStoreData($key)
    {
        if (!$key) {
            return null;
        }

        return Manager::store()::retrieve(Resolver::nameFromMethod(class_basename($this)), $this->id, $key);
    }

    /**
     * @param $directive
     * @return array|null
     */
    public function getDirectiveData($directive): ?array
    {
        return $this->directives()->where('name', 'like', Resolver::nameFromMethod($directive))->value('data');
    }

    /**
     * Convert the directiveable instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_merge($this->attributesToArray(), $this->relationsToArray(), $this->directiveDataToArray());
    }

    /**
     * @return array
     */
    public function directiveDataToArray(): array
    {
        return Manager::store()::retrieve(Resolver::nameFromMethod(class_basename($this)), $this->id);
    }

    /**
     * @return mixed
     */
    abstract public function directives();
}