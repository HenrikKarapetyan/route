<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:40 AM.
 */
declare(strict_types=1);

namespace henrik\route;

use henrik\route\Exceptions\InvalidRangeException;

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
     * @param int $from
     * @param int $to
     *
     * @throws InvalidRangeException
     */
    public function asInteger(int $from = 0, int $to = 0): void
    {
        $pattern = self::INTEGER_PATTERN_BY_RANGE;

        $this->isValidParams($from, $to);

        if ($from === 0 && $to == 0) {
            $pattern = self::INTEGER_PATTERN;
        }

        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @throws InvalidRangeException
     */
    public function any(int $from = 0, int $to = 255): void
    {
        $pattern = self::ANY_PATTERN_BY_RANGE;

        $this->isValidParams($from, $to);

        if ($from === 0 && $to == 0) {
            $pattern = self::ANY_PATTERN;
        }
        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @throws InvalidRangeException
     */
    public function asString(int $from = 0, int $to = 255): void
    {
        $pattern = self::STRING_PATTERN_BY_RANGE;

        $this->isValidParams($from, $to);

        if ($from === 0 && $to == 0) {
            $pattern = self::STRING_PATTERN;
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
     * @param int $from
     * @param int $to
     */
    private function isValidParams(int $from, int $to): void
    {
        if ($to < $from || $to < 0 || $from < 0) {
            throw new InvalidRangeException(sprintf('"%s" and "%s" should been integer instanced and unsigned', $from, $to));
        }
    }
}