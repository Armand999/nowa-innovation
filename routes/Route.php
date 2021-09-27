<?php

namespace Router;

use Core\Database\MysqlDatabase;
use Core\Session\Session;
use Core\Validator\Validator;

class Route
{
    /**
     * Path variable
     *
     * @var string $path
     */
    public $path;

    /**
     * Action controller variable
     *
     * @var string $action
     */
    public $action;

    /**
     * Matches variable
     *
     * @var array $matches
     */
    public $matches;

    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    /**
     * Matches function that checks if one url matched with one route
     *
     * @param string $url
     * @return bool
     */
    public function matches($url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;
            return true;
        }

        return false;
    }

    /**
     * Execute function that executes action about a route controller
     *
     */
    public function execute()
    {
        $params = explode('@', $this->action);
        $controller = new $params[0](MysqlDatabase::dbInstance(), Validator::validatorInstance($_POST), Session::sessionInstance());
        $method = $params[1];

        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    }
}
