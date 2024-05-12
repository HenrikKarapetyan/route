<?php

namespace henrik\route\RouteConstraints;

use henrik\route\Exceptions\UnsatisfiedParameterTypeException;

class FloatValueTypeConstraint extends RouteConstraint
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