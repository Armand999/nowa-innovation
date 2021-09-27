<?php

namespace App\Controllers\Admin;

use App\Table\Admin\UserTable;
use Core\Auth\Auth;
use Core\Controller\AbstractController;

/**
 * Class User That manages all actions about Users
 */
class UserController extends AbstractController
{
    /**
     * See all users
     *
     * @return Core\Entity\Admin\User
     */
    public function index()
    {
        $users = (new UserTable($this->getDb()))->findAll();

        return $this->renderView('admin.users.index', compact('users'));
    }

    /**
     * Add New User 
     *
     */
    public function add()
    {
        $res = (new UserTable($this->getDb()))->createUser($this->getValidator());

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res) && $res) {
            $this->session->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/utilisateurs');
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        }

        return $this->renderView('admin.users.add', compact('errors'));
    }

    /**
     * Edit A user
     *
     * @param int $id
     */
    public function edit($id)
    {
        $userTable = new UserTable($this->getDb());

        $user = $userTable->findById($id);
        $res = $userTable->updateUser($this->getValidator(), $id);

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        } elseif (is_bool($res) && $res) {
            $this->session->addFlash('success', 'Modification effectuée avec succès.');
            $this->redirectToRoute(PATH_ORIGIN . 'admin/utilisateurs/modifier-un-utilisateur/' . $id . '/true');
        }

        return $this->renderView('admin.users.edit', compact('user', 'errors'));
    }

    /**
     * Edit User Password
     *
     * @param int $id
     */
    public function editPassword($id)
    {
        $userTable = new UserTable($this->getDb());

        $user = $userTable->findById($id);
        $res = $userTable->updatePassword($this->getValidator(), $id);

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        } elseif (is_bool($res) && $res) {
            $this->session->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/utilisateurs');
        }

        return $this->renderView('admin.users.edit_password', compact('user', 'errors'));
    }

    /**
     * Delete A User
     *
     * @param int $id
     */
    public function delete($id)
    {
        $res = (new UserTable($this->getDb()))->deleteById($id);

        if ($res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/utilisateurs');
        }

        $this->session->addFlash('danger', 'La suppression à échouée');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/utilisateurs');
    }
}
