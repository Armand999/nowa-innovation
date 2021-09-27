<?php

namespace Router;

use Core\Exception\NotFoundException;
use Router\Route;

/**
 * Class Router that manages all actions about routes  
 */
class Router
{
    /**
     * Url variable
     *
     * @var string $url
     */
    public $url;

    /**
     * Routes variable
     *
     * @var array $routes
     */
    public $routes = [];

    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    /**
     * Get Function that saves all routes in get variable
     *
     * @param string $path
     * @param string $action
     */
    public function get($path, $action)
    {
        
        $this->routes['GET'][] = new Route((string)$path, (string)$action);
       
    }

    /**
     * POST Function that saves all routes in post variable
     *
     * @param string $path
     * @param string $action
     */
    public function post($path, $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }

    /**
     * Run function that runs all routes
     *
     */
    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches((string)$this->url)) {
                return $route->execute();
            }
        }

        throw new NotFoundException('La page demandée est introuvable');
    }
}
