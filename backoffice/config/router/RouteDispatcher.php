<?php
namespace Config;

use AltoRouter;
class RouteDispatcher
{
    protected $match;
    protected $controller;
    protected $method;
    
    public function __construct(AltoRouter $router)
    {

    }
}