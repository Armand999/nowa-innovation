<?php

namespace App\Controllers;

use App\Table\ContactTable;
use App\Table\Admin\UserTable;
use App\Table\Admin\ImageTable;
use App\Table\Admin\FormationTable;
use Core\Controller\AbstractController;
use App\Table\Admin\TrainingCategoryTable;

/**
 * Class FrontController that manages all actions in the frontend of website
 */
class FrontController extends AbstractController
{
    /**
     * Homepage action
     *
     */
    public function home()
    {
        return $this->renderView('homepage');
    }

  
    /**
     * faq
     *
     */
    public function faq()
    {
        return $this->renderView('faq');
    }
	
    public function CTA()
    {
        return $this->renderView('CTA');
    }
	
    public function CTA2()
    {
        return $this->renderView('CTA2');
    }
    /**
     * faq
     *
     */
    public function tarifs()
    {
        return $this->renderView('tarifs');
    }

    /**
     * Images 
     *
     * @param int $id
     */
    public function imagesTrainingUFS($id)
    {

        $trainingCategory = (new TrainingCategoryTable($this->getDb()))->findById($id);

        $imagesTrainingByCategory = (new FormationTable($this->getDb()))->findFormationsByCategories($id);

        if (empty($imagesTrainingByCategory)) return $this->renderView('errors.404');

        return $this->renderView('business_unit.gallery_images', compact('trainingCategory', 'imagesTrainingByCategory'));
    }


    /**
     * Searching Innovations & Strategy action
     *
     */
    public function searchingIS()
    {
        return $this->renderView('');
    }

    /**
     *
     */
    /**
     * Contact Action
     *
     */
    public function contact()
    {
        $contactTable = new ContactTable($this->getDb());
        $res = $contactTable->addContact($this->getValidator());

        if (is_bool($res) && $res) {
            $contactTable->sendContactByEmail();
            $this->session->addFlash('success', 'Votre demande de conctact à été soumise avec succès.');
        } elseif (is_array($res)) {
            $errors = $res;
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        }

        return $this->renderView('contact', compact('errors'));
    }

    /**
     * Login Action
     *
     */
	 
    public function login()
    {
        $res = (new UserTable($this->getDb()))->isCredentialsUserTrue($this->getValidator());

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res) && !$res) {
            $this->session->addFlash('danger', 'Les identifiants que vous avez saisi sont incorrects.');
        } elseif (is_bool($res) && $res) {
            $this->session->addFlash('success', 'Bienvenue sur l\'espace dédié à l\'administration');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/evenements');
        }

        return $this->renderView('login', compact('errors'));
    }
}
