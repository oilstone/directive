<?php

namespace App\Packages\Directive\Contracts;

use App\Packages\Directive\Collection;

/**
 * Interface Directiveable
 * @package App\Packages\Directive\Contracts
 */
interface Directiveable
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