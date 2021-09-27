<?php

namespace App\Table\Admin;

use Core\Table\AbstractTable;
use Core\Validator\Validator;

/**
 * Class ImageTable that manages all queries about Image Table
 */
class ImageTable extends AbstractTable
{
    const SLIDER_LIMIT = 5;

    /**
     * Add a Image
     *
     * @param Validator $validator
     * @return bool|array
     */
    public function addImage(Validator $validator)
    {
        if (!empty($_POST) && !empty($_FILES)) {
            $errors = $validator->isValid([
                'entitled'    => ['notBlank'],
                'description' => ['notBlank'],
                'path'        => ['notGoodImage']
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
                return $this->db->prepare("INSERT INTO $this->table (entitled, description, path) VALUES (?, ?, ?)", [
                    htmlspecialchars($_POST['entitled']),
                    htmlspecialchars($_POST['description']),
                    $cryptedFileName
                ]);
            }
        }
    }

    /**
     * Check if the number of sliders in database is not over the limit
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
