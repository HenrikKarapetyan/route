<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/8  3:54:42.
 *
 */

namespace henrik\route;


/**
 * Class RouteParser
 * @package henrik\route
 */
class RouteParser
{

    /**
     * @var array
     */
    private $data = [];
    /**
     * @var RouteConstraints
     */
    private $constraints = [];

    /**
     * @var
     */
    private $route;
    /**
     * @var
     */
    private $options;

    /**
     * RouteDataGenerator constructor.
     * @param $route
     * @param $options
     * @param null $constraints
     */
    public function __construct($route, $options, $constraints = null)
    {
        $this->route = $route;
        $this->constraints = $constraints;
        $this->options = $options;
    }


    /**
     *
     */
    public function parse()
    {
        if ($this->route !== '/') {
            $route_parts_array = explode('/', ltrim($this->route, '/'));
            $this->data = $this->parser($route_parts_array);
        } else {
            $this->data['/']['options'] = $this->options;
        }
        return $this->data;
    }

    /**
     * @param $route_segments_array
     * @param array $helper
     * @return array
     */
    private function parser($route_segments_array, $helper = [])
    {
        if (!empty($route_segments_array)) {
            $index_data = array_shift($route_segments_array);
            if (preg_match('#{(?<param>[\w]+)}#', $index_data, $matches)) {
                $part = '/' . $this->getConstraints($matches['param']);
            } else {
                $part = '/' . $index_data;
            }
            $helper[$part] = $this->parser($route_segments_array, $helper);
        } else {
            $helper['options'] = $this->options;
        }

        return $helper;
    }

    /**
     * @param $param
     * @return array
     */
    private function getConstraints($param)
    {
        if (!is_null($this->constraints) && isset($this->constraints->getSegments()[$param]))
            return $this->constraints->getSegments()[$param];
        else
            return sprintf(RouteConstraints::segment_pattern, $param, RouteConstraints::any_pattern);
    }

    /**
     * @param array $constraints
     */
    public function setConstraints($constraints = [])
    {
        $this->constraints = $constraints;
    }
}