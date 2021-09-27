<?php

namespace Core\Auth;

use Core\Database\MysqlDatabase;

/**
 * Class Auth managing all actions about authentification
 */
class Auth
{
    /**
     * Database Connection
     *
     * @var MysqlDatabase;
     */
    private $db;

    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
    }

    /**
     * get Id of User connected
     *
     * @return bool
     */
    public function getIdUser()
    {
        if ($this->islogged()) {
            return $_SESSION['userId'];
        }
        return false;
    }

    /**
     * Connect user
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login($username, $password, $table, $className)
    {
        $user = $this->db->prepare("SELECT * FROM $table WHERE username = ?", [$username], $className, true);

        if ($user) {
            if (password_verify($password, $user->password)) {
                $_SESSION['userId'] = $user->id;
                return true;
            }
        }

        return false;
    }

    /**
     * Register User
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function register($firstName, $lastName, $username, $password, $table)
    {
        return $this->db->prepare(
            "INSERT INTO $table (lastname, firstname, username, password) VALUES (:lastname, :firstname, :username, :password)",
            [
                'lastname'  => htmlspecialchars($lastName),
                'firstname' => htmlspecialchars($firstName),
                'username'  => htmlspecialchars($username),
                'password'  => password_hash(htmlspecialchars($password), PASSWORD_BCRYPT)
            ]
        );
    }

    /**
     * Check if user is connected
     *
     * @return bool
     */
    public function islogged()
    {
        return isset($_SESSION['userId']);
    }
}
