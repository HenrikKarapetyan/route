<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:40 AM.
 */
declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Route\Exceptions\InvalidRangeException;
use Henrik\Route\Utils\RouteParamType;

/**
 * Class RouteConstraints.
 */
class RouteConstraints
{
    public const STRING_PATTERN          = '[a-zA-Z0-9]+';
    public const STRING_PATTERN_BY_RANGE = '([a-zA-Z0-9]{%d,%d})';

    public const INTEGER_PATTERN          = '[0-9]+';
    public const INTEGER_PATTERN_BY_RANGE = '([0-9]{%d,%d})';

    public const ANY_PATTERN          = '[^/]+';
    public const ANY_PATTERN_BY_RANGE = '[^/]{%d,%d}';

    public const SEGMENT_PATTERN = '(?<%s>%s)';
    /**
     * @var array<string>|string $routeParts
     */
    private array|string $routeParts = [];
    /**
     * @var array<string> $regularizedSegments
     */
    private array $regularizedSegments = [];

    /**
     * @param array<string>|string $parts
     *
     * @return $this
     */
    public function set(array|string $parts): self
    {
        $this->routeParts = $parts;

        return $this;
    }

    /**
     * @param int|null $from
     * @param int|null $to
     */
    public function asInteger(?int $from = null, ?int $to = null): void
    {
        $pattern = self::INTEGER_PATTERN;

        $this->isValidParams($from, $to);

        if ($from && $to) {
            $pattern = self::INTEGER_PATTERN_BY_RANGE;
        }

        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @param int|null $from
     * @param int|null $to
     */
    public function any(?int $from = null, ?int $to = null): void
    {
        $pattern = self::ANY_PATTERN;

        $this->isValidParams($from, $to);

        if ($from && $to) {
            $pattern = self::ANY_PATTERN_BY_RANGE;
        }
        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @param int|null $from
     * @param int|null $to
     */
    public function asString(?int $from = null, ?int $to = null): void
    {
        $pattern = self::STRING_PATTERN;

        $this->isValidParams($from, $to);

        if ($from && $to) {
            $pattern = self::STRING_PATTERN_BY_RANGE;
        }

        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @return array<string>
     */
    public function getSegments(): array
    {
        return $this->regularizedSegments;
    }

    /**
     * @param array<string, array<string, string|int|RouteParamType|null>> $constraints
     *
     * @return $this
     */
    public function buildFromArray(array $constraints): self
    {
        foreach ($constraints as $routeParam => $options) {

            if (is_array($options)) {

                if (isset($options['type'])) {
                    /**
                     * @var RouteParamType $type
                     */
                    $type = $options['type'];

                    /**
                     * @var ?int $from
                     */
                    $from = $options['from'] ?? null;
                    /**
                     * @var ?int $to
                     */
                    $to = $options['to'] ?? null;

                    $this->detectAndSetOptions(routeParam: $routeParam, type: $type, from: $from, to: $to);
                }

            }

        }

        return $this;
    }

    /**
     * @param string $pattern
     */
    private function regularizeSegments(string $pattern): void
    {
        if (is_array($this->routeParts)) {
            foreach ($this->routeParts as $part) {
                $this->regularizedSegments[$part] = sprintf(self::SEGMENT_PATTERN, $part, $pattern);
            }

            return;
        }
        $this->regularizedSegments[$this->routeParts] = sprintf(self::SEGMENT_PATTERN, $this->routeParts, $pattern);
    }

    /**
     * @param int|null $from
     * @param int|null $to
     */
    private function isValidParams(?int $from, ?int $to): void
    {
        if ($from && $to) {
            if ($to < $from || $to < 0 || $from < 0) {
                throw new InvalidRangeException(sprintf('"%s" and "%s" should been integer instanced and unsigned', $from, $to));
            }
        }
    }

    /**
     * @param string         $routeParam
     * @param RouteParamType $type
     * @param int|null       $from
     * @param int|null       $to
     *
     * @return void
     */
    private function detectAndSetOptions(string $routeParam, RouteParamType $type, ?int $from = null, ?int $to = null): void
    {
        switch ($type) {
            case RouteParamType::TYPE_STRING:
                $this->set([$routeParam])->asString($from, $to);

                break;

            case RouteParamType::TYPE_INTEGER:
                $this->set([$routeParam])->asInteger($from, $to);

                break;
            case RouteParamType::TYPE_ANY:
                $this->set([$routeParam])->any($from, $to);
                break;
        }
    }
}