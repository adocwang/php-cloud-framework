<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 14:10
 */

namespace PhpCloud\Framework\Provider\Router;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std as RouteParser;
use FastRoute\DataGenerator\GroupCountBased;

class ProviderRouter
{
    /**
     * @var $dispatcher ProviderDispatcher
     */
    private $dispatcher;
    /**
     * @var $routeCollector RouteCollector
     */
    private $routeCollector;

    public function __construct()
    {
        $this->routeCollector = new RouteCollector(
            new RouteParser(), new GroupCountBased()
        );
        $this->dispatcher = new ProviderDispatcher($this->routeCollector->getData());
    }

    public function getController()
    {
        return $this->routeCollector;
    }

    public function addRoute($method, $route, $handler)
    {
        $this->routeCollector->addRoute($method, $route, $handler);
        $this->dispatcher->updateRouteMap($this->routeCollector->getData());
    }

    public function dispatch($method, $uri)
    {
        return $this->dispatcher->dispatch($method, $uri);
    }
}