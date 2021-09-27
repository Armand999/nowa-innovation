<?php

namespace Core\Validator;

/**
 * Managing Forms validation
 */
class Validator
{
    private $datas;
    private $errors = [];
    private static $validatorInstance;

    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public static function validatorInstance($datas)
    {
        if (empty(self::$validatorInstance)) {
            self::$validatorInstance = new Validator($datas);
        }
        return self::$validatorInstance;
    }

    public function isValid(array $rules)
    {
        foreach ($rules as $key => $ruleArray) {
            if (array_key_exists($key, $this->datas) || array_key_exists($key, $_FILES)) {
                foreach ($ruleArray as $value) {
                    switch ($value) {
                        case 'notBlank':
                            $this->notBlank($key, $this->datas[$key]);
                            break;
                        case 'notNull':
                            $this->notNull($key, $this->datas[$key]);
                            break;
                        case 'notMail':
                            $this->notMail($key, $this->datas[$key]);
                            break;
                        case 'equalTo':
                            $this->equalTo($key, $this->datas[$key]);
                            break;
                        case 'isLength':
                            $this->isLength($key, $this->datas[$key]);
                            break;
                        case 'notCorrectDateFormat':
                            $this->notCorrectDateFormat($key, $this->datas[$key]);
                            break;
                        case 'notInsideSelectBox':
                            $this->notInsideSelectBox($key, $this->datas[$key]);
                            break;
                        case 'notAreaCode':
                            $this->notAreaCode($key, $this->datas[$key]);
                            break;
                        case 'notTel':
                            $this->notTel($key, $this->datas[$key]);
                            break;
                        case 'notGoodImage':
                            $this->notGoodImage($key);
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }

        return $this->getErrors();
    }

    private function notBlank($key, $value)
    {
        $value = trim($value);

        if (is_null($value) || empty($value)) {
            $this->errors[$key][] = 'Ce Champ ne peut être vide.';
        }
    }

    private function notNull($key, $value)
    {
        if ($value <= 0) {
            $this->errors[$key][] = 'Ce Champ ne peut être nul ou négatif.';
        }
    }

    private function notMail($key, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$key][] = 'Cet email n\'est pas valide.';
        }
    }

    private function equalTo($key, $value)
    {
        foreach ($this->datas as $keyData => $valueData) {
            if ($keyData === 'password' || $keyData === 'confirm_password' || $keyData === 'new_password') {
                if ($value !== $valueData) {
                    $this->errors[$key][] = 'Le mot de passe saisi ne correspond pas.';
                }
            }
        }
    }

    private function isLength($key, $value)
    {
        if (strlen($value) <= 4) {
            $this->errors[$key][] = 'La taille du mot de passe ne doit pas être inférieure à 4 caractères.';
        }
    }

    private function notCorrectDateFormat($key, $value)
    {
        if (!preg_match("#^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$#", $value)) {
            $this->errors[$key][] = 'Le format de ce champ est invalide.';
        } else {
            $date = explode('-', $value);
            if (!checkdate($date[1], $date[2], $date[0])) {
                $this->errors[$key][] = 'Cette date n\'est pas valide.';
            }
        }
    }

    private function notInsideSelectBox($key, $value)
    {
        $options = ['recis', 'ufs', 'si', 'emc', 'op', 'cdd', 'cdi', 'stage'];
        if (!in_array($value, $options)) {
            $this->errors[$key][] = 'La valeur est incorrecte.';
        }
    }

    private function notAreaCode($key, $value)
    {
        if (!preg_match("#^\+[0-9]{1,4}$#", $value)) {
            $this->errors[$key][] = 'l\'indicatif est incorrect.';
        }
    }

    private function notTel($key, $value)
    {
        if (!preg_match("#^[0-9]{8,15}$#", $value)) {
            $this->errors[$key][] = 'Le format du numéro est incorrect.';
        }
    }

    private function notGoodImage($key)
    {
        $maxSize = 2097152;
        $authorizedExtensions = ['.jpeg', '.png', '.jpg'];
        $fileExtension = '.' . strtolower(substr(strrchr($_FILES[$key]['name'], '.'), 1));

        if ($_FILES[$key]['error'] > 0) {
            $this->errors[$key][] = 'Une erreur s\'est produite lors du chargement de l\'image';
        } elseif ($_FILES[$key]['size'] >= $maxSize) {
            $this->errors[$key][] = 'La taille du fichier est trop grande.';
        } elseif (!in_array($fileExtension, $authorizedExtensions)) {
            $this->errors[$key][] = 'Cet format d\'image n\'est pas autorisée.';
        }
    }

    private function getErrors()
    {
        return $this->errors;
    }
}
