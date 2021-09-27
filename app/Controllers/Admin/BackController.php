<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use Core\Controller\AbstractController;

/**
 * Class BackController that manages all actions in the backend of website
 */
class BackController extends AbstractController
{
    /**
     * logout Action
     *
     */
    public function logout()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        unset($_SESSION['userId']);
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
    }
}
