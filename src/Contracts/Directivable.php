<?php

namespace App\Packages\Directive\Contracts;

use App\Packages\Directive\Collection;

/**
 * Interface Directivable
 * @package App\Packages\Directive\Contracts
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