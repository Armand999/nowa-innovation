<?php

namespace App\Table\Admin;

use Core\Table\AbstractTable;
use Core\Validator\Validator;

/**
 * Class TrainingCategoryTable that manages all queries about Training Category Table
 */
class TrainingCategoryTable extends AbstractTable
{
    /**
     * Database Table Name
     *
     * @var string
     */
    protected $table = 'training_categories';

    /**
     * Function to add entry training category in database
     *
     * @param Validatot $validator
     * @return bool
     */
    public function addTrainingCategory(Validator $validator)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'entitled'  => ['notBlank']
            ]);

            if ($errors) return $errors;

            $query = $this->db->prepare("SELECT * FROM $this->table WHERE entitled = ?", [htmlspecialchars($_POST['entitled'])], str_replace('Table', 'Entity', get_class($this)), true);

            if ($query) {
                return 'la catégorie de formations "' . htmlentities($_POST['entitled']) . '" existe déjà';
            }

            return $this->db->prepare("INSERT INTO $this->table (entitled) VALUES (?)", [htmlspecialchars($_POST['entitled'])]);
        }
    }

    /**
     * Update a entry training category in database
     *
     * @param Validator $validator
     * @param int $id
     * @return bool
     */
    public function updateTrainingCategory(Validator $validator, $id)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'entitled'  => ['notBlank']
            ]);

            if ($errors) return $errors;

            return $this->db->prepare("UPDATE $this->table SET entitled = ? WHERE id = ?", [
                htmlspecialchars($_POST['entitled']),
                $id
            ]);
        }
    }
}
