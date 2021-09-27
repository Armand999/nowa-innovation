<?php

namespace App\Controllers\Admin;

use Core\Auth\Auth;
use App\Table\Admin\ImageTable;
use App\Table\Admin\FormationTable;
use Core\Controller\AbstractController;
use App\Table\Admin\TrainingCategoryTable;

/**
 * Class Image That manages all actions about images
 */
class ImageController extends AbstractController
{
    /**
     * Function IndexSliders that shows all images sliders
     *
     * @return array
     */
    public function indexSliders()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $sliders = (new ImageTable($this->getDb()))->findAll();

        return $this->renderView('admin.images.sliders.index', compact('sliders'));
    }

    /**
     * Function ShowSliders that show a image sliders
     *
     * @param int $id
     * @return array
     */
    public function showSliders($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $slider = (new ImageTable($this->getDb()))->findById($id);

        return $this->renderView('admin.images.sliders.show', compact('slider'));
    }

    /**
     * Function AddSliders that add new image slider
     *
     * @return array
     */
    public function addSliders()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $imageTable = new ImageTable($this->getDb());

        if ($imageTable->checkSlidersLimit()) {
            $this->session->addFlash('warning', 'Le nombres d\'images du carousel de la page d\'accueil est atteint. Veuillez remplacer celles déjà présentes.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/carousel');
        }

        $res = $imageTable->addImage($this->getValidator());

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res) && $res === true) {
            $this->session->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/carousel');
        }

        return $this->renderView('admin.images.sliders.add', compact('errors'));
    }

    /**
     * Function Delete that erase a Image
     *
     * @param int $id
     */
    public function deleteSliders($id)
    {
        $imageTable = new ImageTable($this->getDb());
        $imageFile = $imageTable->findById($id);

        if ($imageFile) {
            if (file_exists($imageFile->path)) {
                if (unlink($imageFile->path)) {
                    $res = $imageTable->deleteById($id);
                    if ($res) {
                        $this->session->addFlash('success', 'Suppression effectuée avec succès.');
                        return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/carousel');
                    }
                }
            }
        }

        $this->session->addFlash('danger', 'La suppression à échouée.');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/carousel');
    }

    /**
     * Function IndexFormations that shows all images Formations
     *
     * @return array
     */
    public function indexFormations()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $formations = (new FormationTable($this->getDb()))->getFormationsWithCategories();

        return $this->renderView('admin.images.training.index', compact('formations'));
    }

    /**
     * Function ShowFormation that show a image Formation
     *
     * @param int $id
     * @return array
     */
    public function showFormation($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $formation = (new FormationTable($this->getDb()))->getFormationWithCategory($id);

        return $this->renderView('admin.images.training.show', compact('formation'));
    }

    /**
     * Function addFormation that add a Formation images
     *
     * @return array
     */
    public function addFormation()
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $trainingCategories = (new TrainingCategoryTable($this->getDb()))->findAll();

        $res = (new FormationTable($this->getDb()))->addFormation($this->getValidator());

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res) && $res === true) {
            $this->session->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/formations');
        }

        return $this->renderView('admin.images.training.add', compact('trainingCategories', 'errors'));
    }

    /**
     * Function editFormation that edit a Formation
     *
     * @return array
     */
    public function editFormation($id)
    {
        $auth = new Auth($this->getDb());

        if (!$auth->islogged()) {
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/se-connecter');
        }

        $trainingCategories = (new TrainingCategoryTable($this->getDb()))->findAll();

        $formationTable = new FormationTable($this->getDb());

        $formation = $formationTable->getFormationWithCategory($id);
        $res = $formationTable->updateFormation($this->getValidator(), $id);

        if (is_array($res)) {
            $errors = $res;
        } elseif (is_bool($res) && $res === true) {
            $this->session->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/formations/modifier-une-image/' . $formation->id . '/true');
        }

        return $this->renderView('admin.images.training.edit', compact('trainingCategories', 'formation', 'errors'));
    }

    /**
     * Function Delete that erase a Formation Image
     *
     * @param int $id
     */
    public function deleteFormation($id)
    {
        $formationTable = new FormationTable($this->getDb());
        $imageFile = $formationTable->findById($id);

        if ($imageFile) {
            if (file_exists($imageFile->path)) {
                if (unlink($imageFile->path)) {
                    $res = $formationTable->deleteById($id);
                }
            } else {
                $res = $formationTable->deleteById($id);
            }
        }

        if ($imageFile && $res) {
            $this->session->addFlash('success', 'Suppression effectuée avec succès.');
            return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/formations');
        }

        $this->session->addFlash('danger', 'La suppression à échouée.');
        return $this->redirectToRoute(PATH_ORIGIN . 'admin/images/formations');
    }
}
