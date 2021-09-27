<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use App\Table\ComplaintTable;
use Core\Controller\AbstractController;

/**
 * Class Complaint That manages all actions about customers complaints
 */
class ComplaintController extends AbstractController
{

    /**
     * Function Index that shows all customers complaints
     *
     * @return Core\Entity\ComplaintEntity
     */
    public function index()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $complaints = (new ComplaintTable($this->getDb()))->getLastComplaints();

        return $this->renderView('admin.complaints.index', compact('complaints'));
    }

    /**
     * Function Show that show a Customer Complaint
     *
     * @param int $id
     * @return Core\Entity\ComplaintEntity
     */
    public function show($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $complaint =  (new ComplaintTable($this->getDb()))->findById($id);

        if (empty($complaint)) {
            return $this->renderView('errors.404');
        }

        return $this->renderView('admin.complaints.show', compact('complaint'));
    }

    /**
     * Function delete a complaint
     *
     * @param int $id
     */
    public function delete($id)
    {
        $res = (new ComplaintTable($this->getDb()))->deleteById($id);

        if ($res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/reclamations');
        }

        $this->session->addFlash('danger', 'La suppression à échouée.');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/reclamations');
    }
}
