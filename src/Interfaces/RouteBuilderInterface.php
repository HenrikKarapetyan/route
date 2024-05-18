<?php

namespace Henrik\Route\Interfaces;

use Henrik\Route\Exceptions\UnknownKeywordException;

interface RouteBuilderInterface
{
    /**
     * @throws UnknownKeywordException
     */
    public function build(): ?string;
}