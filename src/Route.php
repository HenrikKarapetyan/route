<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 1/25/2018
 * Time: 10:47 AM
 */

namespace henrik\route;


/**
 * Class Route
 * @package henrik\route
 */
class Route
{
    /** @var string|array */
    private $httpMethod;

    /** @var array */
    private $params = [];

    /** @var mixed */
    private $handler;

    /**
     * @var array
     */
    private $middlewars = [];

    /**
     * @return array
     */
    public function getMiddlewars()
    {
        return $this->middlewars;
    }

    /**
     * @param array $middlewars
     */
    public function setMiddlewars($middlewars)
    {
        $this->middlewars = $middlewars;
    }

    /**
     * @return string|array
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @param $httpMethod string|array
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param mixed $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }


    /**
     * @param string $url_regexp
     */
    public function setUrlRegexp($url_regexp)
    {
        $this->url_regexp = $url_regexp;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param  $param string
     */
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
    }

}