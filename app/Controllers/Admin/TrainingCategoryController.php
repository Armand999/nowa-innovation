<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use App\Table\Admin\FormationTable;
use Core\Controller\AbstractController;
use App\Table\Admin\TrainingCategoryTable;

/**
 * Class TrainingCategory That manages all actions about TrainingCategories
 */
class TrainingCategoryController extends AbstractController
{
    /**
     * Function Index that shows all Training Categories
     * 
     * @return Core\Entity\TrainingCategoryEntity
     */
    public function index()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $trainingCategories = (new TrainingCategoryTable($this->getDb()))->findAll();

        return $this->renderView('admin.images.training_categories.index', compact('trainingCategories'));
    }

    /**
     * Function Show to see a Training Categories
     *
     * @param int $id
     * @return Core\Entity\TrainingCategoryEntity
     */
    public function show($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $trainingCategory = (new TrainingCategoryTable($this->getDb()))->findById($id);

        if (empty($trainingCategory)) {
            return $this->renderView('errors.404');
        }

        return $this->renderView('admin.images.training_categories.show', compact('trainingCategory'));
    }

    /**
     * Function Add a Training Category
     *
     */
    public function add()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $res = (new TrainingCategoryTable($this->getDb()))->addTrainingCategory($this->getValidator());

        if (is_bool($res) && $res == true) {
            $this->session->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/categories/formations');
        } elseif (is_array($res)) {
            $errors = $res;
        } elseif (is_string($res)) {
            $this->session->addFlash('danger', $res);
        }

        return $this->renderView('admin.images.training_categories.add', compact('errors'));
    }

    /**
     * Function update Training Category
     *
     */
    public function edit($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $trainingCategoryTable = new TrainingCategoryTable($this->getDb());

        $trainingCategory = $trainingCategoryTable->findById($id);
        $res = $trainingCategoryTable->updateTrainingCategory($this->getValidator(), $id);

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res) && $res === true) {
            $this->session->addFlash('success', 'Modification effectuée avec succès.');
            $this->redirectToRoute(PATH_ORIGIN . 'admin/images/categories/formations/modifier-une-categorie-de-formations/' . $id . '/true');
        }

        return $this->renderView('admin.images.training_categories.edit', compact('trainingCategory', 'errors'));
    }

    /**
     * Function delete a Training Category
     *
     * @param int $id
     */
    public function delete($id)
    {
        $trainingCategoryTable = new TrainingCategoryTable($this->getDb());
        $formationTable = new FormationTable($this->getDb());

        $imageFiles = $formationTable->findFormationsByCategories($id);

        if ($imageFiles && count($imageFiles) > 0) {
            foreach ($imageFiles as $imageFile) {
                if (file_exists($imageFile->path)) {
                    unlink($imageFile->path);
                }
            }
            $res = $trainingCategoryTable->deleteById($id);
        } else {
            $res = $trainingCategoryTable->deleteById($id);
        }

        if ($res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/categories/formations');
        }

        $this->session->addFlash('danger', 'La suppression à échouée');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/categories/formations');
    }
}
