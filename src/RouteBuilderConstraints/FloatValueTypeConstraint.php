<?php

namespace Henrik\Route\RouteBuilderConstraints;

use Henrik\Route\Exceptions\UnsatisfiedParameterTypeException;

class FloatValueTypeConstraint extends RouteBuilderConstraint
{
    /**
     * @throws UnsatisfiedParameterTypeException
     */
    public function execute(): string
    {
        if (is_float($this->value)) {
            return (string) $this->value;
        }

        throw new UnsatisfiedParameterTypeException(
            message: sprintf(
                'This argument must be `float` value but `%s` given!',
                gettype($this->value)
            )
        );
    }
}