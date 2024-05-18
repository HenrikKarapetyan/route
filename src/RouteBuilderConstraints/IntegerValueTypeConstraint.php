<?php

namespace Henrik\Route\RouteBuilderConstraints;

use Henrik\Route\Exceptions\UnsatisfiedParameterTypeException;

class IntegerValueTypeConstraint extends RouteBuilderConstraint
{
    /**
     * @throws UnsatisfiedParameterTypeException
     */
    public function execute(): string
    {
        if (is_numeric($this->value)) {
            return (string) $this->value;
        }

        throw new UnsatisfiedParameterTypeException(
            message: sprintf(
                'This argument must be `integer` value but `%s` given!',
                gettype($this->value)
            )
        );
    }
}