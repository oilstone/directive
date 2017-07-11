<?php

namespace Oilstone\Directive\Contracts;

use Oilstone\Directive\Collection;

/**
 * Interface Directivable
 * @package Oilstone\Directive\Contracts
 */
interface Directivable
{
    /**
     * @return Collection
     */
    public function getDirectives(): Collection;

    /**
     * @param $directive
     * @return array|null
     */
    public function getDirectiveData($directive): ?array;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function directiveDataToArray(): array;
}