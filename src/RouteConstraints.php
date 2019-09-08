<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:40 AM
 */

namespace henrik\route;

use henrik\route\exceptions\InvalidRangeException;


/**
 * Class RouteConstraints
 * @package henrik\route
 */
class RouteConstraints
{
    /**
     *
     */
    const string_pattern = '[a-zA-Z0-9]+';
    /**
     *
     */
    const string_pattern_by_range = '([a-zA-Z0-9]{%d,%d})';

    /**
     *
     */
    const integer_pattern = '[0-9]+';
    /**
     *
     */
    const integer_pattern_by_range = '([0-9]{%d,%d})';

    /**
     *
     */
    const any_pattern = '[^/]+';
    /**
     *
     */
    const any_pattern_by_range = '[^/]{%d,%d}';

    /**
     *
     */
    const segment_pattern = "(?<%s>%s)";
    /**
     * @temporal
     * @var
     */
    private $route_parts;
    /**
     * @var array
     */
    private $regularized_segemnts = [];

    /**
     * @param $parts array|string
     * @return $this
     */
    public function set($parts)
    {
        $this->route_parts = $parts;
        return $this;
    }

    /**
     * @param int $from
     * @param int $to
     * @throws InvalidRangeException
     */
    public function asInteger($from = 0, $to = 0)
    {
        $this->isValidParams($from, $to);
        if ($from === 0 && $to == 0)
            $pattern = self::integer_pattern;
        else $pattern = self::integer_pattern_by_range;
        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @param int $from
     * @param int $to
     * @throws InvalidRangeException
     */
    public function any($from = 0, $to = 255)
    {
        $this->isValidParams($from, $to);
        if ($from === 0 && $to == 0)
            $pattern = self::any_pattern;
        else $pattern = self::any_pattern_by_range;
        $this->regularizeSegments(sprintf($pattern, $from, $to));
    }

    /**
     * @param int $from
     * @param int $to
     * @throws InvalidRangeException
     */
    public function asString($from = 0, $to = 255)
    {
        $this->isValidParams($from, $to);
        if ($from === 0 && $to == 0)
            $pattern = self::string_pattern;
        else $pattern = self::string_pattern_by_range;
        $this->regularizeSegments(sprintf($pattern, $from, $to));

    }

    /**
     * @param $pattern string
     */
    private function regularizeSegments($pattern)
    {
        if (is_array($this->route_parts)) {
            foreach ($this->route_parts as $part) {
                $this->regularized_segemnts[$part] = sprintf(self::segment_pattern, $part, $pattern);
            }
        } else {
            $this->regularized_segemnts[$this->route_parts] = sprintf(self::segment_pattern, $this->route_parts, $pattern);
        }
    }

    /**
     * @param $from
     * @param $to
     * @throws InvalidRangeException
     */
    private function isValidParams($from, $to)
    {
        if ($to < $from || $to < 0 || $from < 0) {
            throw new InvalidRangeException(sprintf('"%s" and "%s" should been integer instanced and unsigned', $from, $to));
        }
    }

    /**
     * @return array
     */
    public function getSegments()
    {
        return $this->regularized_segemnts;
    }
}