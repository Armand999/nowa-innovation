<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use App\Table\ContactTable;
use Core\Controller\AbstractController;

/**
 * Class Contact That manages all actions about contacts
 */
class ContactController extends AbstractController
{

    /**
     * Function Index that shows all contacts
     *
     * @return Core\Entity\ContactEntity
     */
    public function index()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $contacts = (new ContactTable($this->getDb()))->getLastContacts();

        return $this->renderView('admin.contacts.index', compact('contacts'));
    }

    /**
     * Function Show that show a Contact
     *
     * @param int $id
     * @return Core\Entity\ContactEntity
     */
    public function show($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $contact =  (new ContactTable($this->getDb()))->findById($id);

        if (empty($contact)) {
            return $this->renderView('errors.404');
        }

        return $this->renderView('admin.contacts.show', compact('contact'));
    }

    /**
     * Function delete a contact
     *
     * @param int $id
     * @return Core\Entity\ContactEntity
     */
    public function delete($id)
    {
        $res = (new ContactTable($this->getDb()))->deleteById($id);
        if ($res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/contacts');
        }
        $this->session->addFlash('danger', 'La suppression à échouée.');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/contacts');
    }
}
