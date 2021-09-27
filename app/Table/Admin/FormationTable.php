<?php

namespace App\Table\Admin;

use Core\Table\AbstractTable;
use Core\Validator\Validator;

/**
 * Class FormationTable that manages all queries about Formation Table
 */
class FormationTable extends AbstractTable
{
    const SLIDER_LIMIT = 5;

    /**
     * Database Table Name
     *
     * @var string
     */
    protected $table = 'training_img';

    /**
     * Get All Formations with their Category
     *
     */
    public function getFormationsWithCategories()
    {
        return $this->db->query(
            "SELECT t.id, t.path, tc.entitled FROM $this->table as t
            INNER JOIN training_categories as tc 
            WHERE t.categorie_id = tc.id
            ORDER BY t.id DESC",
            str_replace('Table', 'Entity', get_class($this))
        );
    }

    /**
     * Get a Formation with his Category
     *
     */
    public function getFormationWithCategory($training_categorie_id)
    {
        return $this->db->prepare(
            "SELECT t.id, t.path, t.categorie_id, tc.entitled FROM $this->table as t
            INNER JOIN training_categories as tc 
            WHERE t.categorie_id = tc.id
            AND t.id = ?",
            [$training_categorie_id],
            str_replace('Table', 'Entity', get_class($this)),
            true
        );
    }

    /**
     * Find All Formations By category
     *
     * @param int $id
     */
    public function findFormationsByCategories($categorie_id)
    {
        return $this->db->prepare(
            "SELECT t.id, t.path, t.categorie_id FROM $this->table as t
            INNER JOIN training_categories as tc 
            WHERE t.categorie_id = tc.id
            AND t.categorie_id = ?",
            [$categorie_id],
            str_replace('Table', 'Entity', get_class($this))
        );
    }

    /**
     * Add a Formation
     *
     * @param Validator $validator
     * @return bool|array
     */
    public function addFormation(Validator $validator)
    {
        if (!empty($_POST) && !empty($_FILES)) {
            $errors = $validator->isValid([
                'path'         => ['notGoodImage'],
                'category' => ['notBlank']
            ]);

            if ($errors) return $errors;

            $directoryFile = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'public/assets/uploads';

            if (!is_dir($directoryFile)) {
                mkdir($directoryFile, 0777, true);
            }

            $fileName = $_FILES['path']['tmp_name'];
            $fileExtension = '.' . strtolower(substr(strrchr($_FILES['path']['name'], '.'), 1));
            $uniqueName = md5(uniqid(rand(), true));

            $cryptedFileName = $directoryFile . '/' . $uniqueName . $fileExtension;

            if (move_uploaded_file($fileName, $cryptedFileName)) {
                return $this->db->prepare("INSERT INTO $this->table (path, categorie_id) VALUES (?, ?)", [
                    $cryptedFileName,
                    htmlspecialchars($_POST['category'])
                ]);
            }
        }
    }

    /**
     * Update a Formation
     * 
     * @param Validator $validator
     * @param int $id
     * @return bool|array
     */
    public function updateFormation(Validator $validator, $id)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'category' => ['notBlank']
            ]);

            if ($errors) return $errors;

            return $this->db->prepare(
                "UPDATE $this->table SET categorie_id = ? WHERE id = ?",
                [
                    htmlspecialchars($_POST['category']),
                    $id
                ]
            );
        }
    }

    /**
     * Check if the number of sliders in database isn't over the limit
     * 
     * @return true
     */
    public function checkSlidersLimit()
    {
        $count = 0;
        foreach ($this->findAll() as $value) {
            $count++;
        }

        return $count >= self::SLIDER_LIMIT;
    }
}
