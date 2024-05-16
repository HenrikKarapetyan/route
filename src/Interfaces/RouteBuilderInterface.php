<?php

namespace henrik\route\Interfaces;

use henrik\route\Exceptions\UnknownKeywordException;

interface RouteBuilderInterface
{
    /**
     * @throws UnknownKeywordException
     */
    public function build(): ?string;
}