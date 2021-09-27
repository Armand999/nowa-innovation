<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use App\Table\EventTable;
use Core\Controller\AbstractController;

/**
 * Class Event That manages all actions about events
 */
class EventController extends AbstractController
{

    /**
     * Function Index that shows all events
     *
     * @return Core\Entity\EventEntity
     */
    public function index()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $events = (new EventTable($this->getDb()))->getLastEvents();

        return $this->renderView('admin.events.index', compact('events'));
    }

    /**
     * Function Show to see a event
     *
     * @param string $slug
     * @return Core\Entity\EventEntity
     */
    public function show($slug)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $event =  (new EventTable($this->getDb()))->findBySlug($slug);

        if (empty($event)) {
            return $this->renderView('errors.404');
        }

        return $this->renderView('admin.events.show', compact('event'));
    }

    /**
     * Function Add a event
     *
     */
    public function add()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $res = (new EventTable($this->getDb()))->addEvent($this->getValidator());

        if (is_bool($res)) {
            $this->session->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/evenements');
        } elseif (is_array($res)) {
            $errors = $res;
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        }

        return $this->renderView('admin.events.add', compact('errors'));
    }

    /**
     * Function update event
     *
     * @param int $id
     */
    public function edit($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $eventTable = new EventTable($this->getDb());

        $event = $eventTable->findById($id);
        $res = $eventTable->updateEvent($this->getValidator(), $id);

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res)) {
            $this->session->addFlash('success', 'Modification effectuée avec succès');
            $this->redirectToRoute(PATH_ORIGIN . 'admin/evenements/modifier-un-evenement/' . $id . '/true');
        }

        return $this->renderView('admin.events.edit', compact('event', 'errors'));
    }

    /**
     * Function delete a event entry
     *
     * @param int $id
     */
    public function delete($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $res = (new EventTable($this->getDb()))->deleteById($id);

        if ($res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/evenements');
        }

        $this->session->addFlash('danger', 'La suppression à échouée.');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/evenements');
    }
}
