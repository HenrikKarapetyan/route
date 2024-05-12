<?php

namespace henrik\route;

use henrik\route\Exceptions\UnknownKeywordException;

interface RouteBuilderInterface
{
    /**
     * @throws UnknownKeywordException
     */
    public function build(): ?string;
}