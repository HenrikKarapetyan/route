<?php

namespace henrik\route;

use henrik\route\Exceptions\UnknownKeywordException;
use henrik\route\RouteConstraints\AnyValueTypeConstraint;
use henrik\route\RouteConstraints\FloatValueTypeConstraint;
use henrik\route\RouteConstraints\IntegerValueTypeConstraint;
use henrik\route\RouteConstraints\RouteConstraintInterface;
use henrik\route\RouteConstraints\StringValueTypeConstraint;

class RouteBuilder implements RouteBuilderInterface
{
    public const REGEXP_LINE = '/(\?[,\S-]?)/';

    /**
     * @param array<string, string|int|float> $queryParams
     * @param string                          $baseUri
     * @param array<int|string|float>         $args
     * @param string                          $pattern
     */
    public function __construct(
        private string $pattern,
        private array $args = [],
        private array $queryParams = [],
        private string $baseUri = ''
    ) {}

    /**
     * {@inheritdoc}
     *
     * @throws UnknownKeywordException
     */
    public function build(): ?string
    {
        $uriLine = (string) preg_replace_callback(
            self::REGEXP_LINE,
            function ($key) {
                $value = array_shift($this->args);

                return $this->getNormalizedValue($key[0], $value)->execute();
            },
            $this->pattern
        );

        if (count($this->getQueryParams()) > 0) {
            $queryParamsLine = http_build_query($this->queryParams);
            $uriLine         = sprintf('%s?%s', $uriLine, $queryParamsLine);
        }

        return sprintf('%s%s', $this->baseUri, $uriLine);
    }

    /**
     * @return array<string, string|int|float>
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @param array<string, string|int|float> $queryParams
     *
     * @return void
     */
    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return array<int|float|string>
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array<int|float|string> $args
     *
     * @return RouteBuilder
     */
    public function setArgs(array $args): self
    {
        $this->args = $args;

        return $this;
    }

    /**
     * @param string                     $key
     * @param bool|float|int|string|null $value
     *
     * @throws UnknownKeywordException
     *
     * @return RouteConstraintInterface
     */
    private function getNormalizedValue(string $key, null|bool|float|int|string $value): RouteConstraintInterface
    {
        return match ($key) {
            '?'     => new AnyValueTypeConstraint($value),
            '?d'    => new IntegerValueTypeConstraint($value),
            '?s'    => new StringValueTypeConstraint($value),
            '?f'    => new FloatValueTypeConstraint($value),
            default => throw new UnknownKeywordException($key)
        };
    }
}