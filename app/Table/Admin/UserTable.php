<?php

namespace App\Table\Admin;

use Core\Auth\Auth;
use Core\Database\MysqlDatabase;
use Core\Table\AbstractTable;
use Core\Validator\Validator;

/**
 * Class UserTable that manages all queries about User Table
 */
class UserTable extends AbstractTable
{
    /**
     * Database Table
     *
     * @var string $table
     */
    protected $table = 'users';

    /**
     * Auth Variable
     *
     * @var Auth $auth
     */
    protected $auth;

    protected $db;

    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
        $this->auth = new Auth(MysqlDatabase::$dbInstance);
    }

    /**
     * Check if user exists in User Table
     *
     * @return boolean
     */
    private function isUserExists()
    {
        return $this->auth->login(
            htmlspecialchars($_POST['username']),
            htmlspecialchars($_POST['password']),
            $this->table,
            str_replace('Table', 'Entity', get_class($this))
        );
    }

    /**
     * Check if credentials of user is right
     *
     * @param Validator $validator
     * @return boolean
     */
    public function isCredentialsUserTrue(Validator $validator)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'username' => ['notBlank', 'notMail'],
                'password' => ['notBlank']
            ]);

            if ($errors) return $errors;

            return (!$this->isUserExists()) ? false : true;
        }
    }

    /**
     * Create new user entry
     *
     * @param Validator $validator
     */
    public function createUser(Validator $validator)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'lastname'         => ['notBlank'],
                'firstname'        => ['notBlank'],
                'username'         => ['notBlank', 'notMail'],
                'password'         => ['notBlank', 'isLength'],
                'confirm_password' => ['notBlank', 'equalTo']
            ]);

            if ($errors) return $errors;

            $query = $this->db->prepare(
                "SELECT * FROM $this->table WHERE username = ?",
                [htmlspecialchars($_POST['username'])],
                str_replace('Table', 'Entity', get_class($this)),
                true
            );

            if ($query) return 'Cet Identifiant existe déjà, veuillez réessayer svp !';

            return $this->auth->register($_POST['lastname'], $_POST['firstname'], $_POST['username'], $_POST['password'], $this->table);
        }
    }

    /**
     * Update Entry User
     *
     * @param Validator $validator
     * @param int $id
     */
    public function updateUser(Validator $validator, $id)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'lastname'         => ['notBlank'],
                'firstname'        => ['notBlank'],
                'username'         => ['notBlank', 'notMail'],
                'password'         => ['notBlank', 'isLength']
            ]);

            if ($errors) return $errors;

            $query = $this->db->prepare(
                "SELECT * FROM $this->table WHERE id = ?",
                [$id],
                str_replace('Table', 'Entity', get_class($this)),
                true
            );

            if (!password_verify(htmlspecialchars($_POST['password']), $query->password)) {
                return 'Le mot de passe saisi ne correspond pas à celui de cet utilisateur.';
            }

            return $this->db->prepare(
                "UPDATE $this->table SET lastname = :lastname, firstname = :firstname, username = :username WHERE id = :id",
                [
                    'lastname'   => htmlspecialchars($_POST['lastname']),
                    'firstname'  => htmlspecialchars($_POST['firstname']),
                    'username'   => htmlspecialchars($_POST['username']),
                    'id'         => $id
                ]
            );
        }
    }

    /**
     * Update User Password
     *
     * @param Validator $validator
     * @param int $id
     */
    public function updatePassword(Validator $validator, $id)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'last_password'    => ['notBlank', 'isLength'],
                'new_password'     => ['notBlank', 'isLength'],
                'confirm_password' => ['notBlank', 'equalTo']
            ]);

            if ($errors) return $errors;

            $query = $this->db->prepare(
                "SELECT * FROM $this->table WHERE id = ?",
                [$id],
                str_replace('Table', 'Entity', get_class($this)),
                true
            );

            if (!password_verify(htmlspecialchars($_POST['last_password']), $query->password)) {
                return 'L\'ancien mot de passe saisi est incorrect.';
            }

            return $this->db->prepare(
                "UPDATE $this->table SET password = :password WHERE id = :id",
                [
                    'password' => password_hash(htmlspecialchars($_POST['new_password']), PASSWORD_BCRYPT),
                    'id' => $id
                ]
            );
        }
    }
}
