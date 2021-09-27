<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use App\Table\JobTable;
use Core\Controller\AbstractController;

/**
 * Class Job That manages all actions about Jobs
 */
class JobController extends AbstractController
{

    /**
     * Function Index shows all jobs
     *
     * @return Core\Entity\JobEntity
     */
    public function index()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $jobs = (new JobTable($this->getDb()))->getLastJobs();

        return $this->renderView('admin.jobs.index', compact('jobs'));
    }

    /**
     * Function Show Job entry
     *
     * @param string $slug
     * @return Core\Entity\JobEntity
     */
    public function show($slug)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $job =  (new JobTable($this->getDb()))->findBySlug($slug);

        if (empty($job)) {
            return $this->renderView('errors.404');
        }

        return $this->renderView('admin.jobs.show', compact('job'));
    }

    /**
     * Function Add a Job entry
     *
     */
    public function add()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $res = (new JobTable($this->getDb()))->addJob($this->getValidator());

        if (is_bool($res)) {
            $this->session->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/offres-d-emploi');
        } elseif (is_array($res)) {
            $errors = $res;
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        }

        return $this->renderView('admin.jobs.add', compact('errors'));
    }

    /**
     * Function edit Job entry
     *
     */
    public function edit($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $jobTable = new JobTable($this->getDb());

        $job = $jobTable->findById($id);
        $res = $jobTable->updateJob($this->getValidator(), $id);

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res)) {
            $this->session->addFlash('success', 'Modification effectuée avec succès.');
            $this->redirectToRoute(PATH_ORIGIN . 'admin/offres-d-emploi/modifier-une-offre/' . $id . '/true');
        }

        return $this->renderView('admin.jobs.edit', compact('job', 'errors'));
    }

    /**
     * Function delete a Job entry
     *
     * @param int $id
     */
    public function delete($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $res = (new JobTable($this->getDb()))->deleteById($id);

        if ($res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/offres-d-emploi');
        }

        $this->session->addFlash('danger', 'La suppression à échouée.');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/offres-d-emploi');
    }
}
