<?php

namespace Core\Controller;

use Core\Database\MysqlDatabase;
use Core\Session\Session;
use Core\Validator\Validator;

/**
 * Generic Class Controller
 */
abstract class AbstractController
{
    /**
     * Connection Database Variable
     *
     * @var MysqlDatabase $db
     */
    protected $db;

    /**
     * Validator Fields Variable
     *
     * @var Validator $validator
     */
    protected $validator;

    /**
     * Session Variable
     *
     * @var Session $session
     */
    public $session;

    /**
     * Constructor
     *
     * @param MysqlDatabase $db
     * @param Validator $validator
     * @param Session $session
     */
    public function __construct(MysqlDatabase $db, Validator $validator, Session $session)
    {
        $this->db = $db;
        $this->validator = $validator;
        $this->session = $session;
    }

    /**
     * Getter Connection Database
     *
     * @return MysqlDatabase
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Getter Validator Fields
     *
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Function who gives the view
     *
     * @param string $path
     * @param array $params
     * @return void
     */
    protected function renderView($path, array $params = null)
    {
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS . $path . '.php';

        if ($params) $params = extract($params);

        $content = ob_get_clean();

        if (strpos($path, 'admin') === 0) {
            require VIEWS . 'admin/layout.php';
        } else {
            require VIEWS . 'layout.php';
        }
    }

    /**
     * Redirect To A specify Route
     *
     * @param string $routePath
     * @return void
     */
    protected function redirectToRoute($routePath)
    {
        header('Location: ' . $routePath);
        exit();
    }
}
