<?php

namespace App\Entity\Admin;

use Core\Entity\Entity;

class FormationEntity extends Entity
{
    /**
     * Get Short Text about Category Description
     * 
     */
    public function getExcerpt()
    {
        return substr($this->entitled, 0, 20) . '...';
    }

    /**
     * Get Short Path of image
     *
     */
    public function getShortPath()
    {
        return substr($this->path, 0, 15) . '...';
    }

    /**
     * Get Image
     *
     */
    public function getPathImage()
    {
        return SCRIPTS . substr($this->path, stripos($this->path, 'uploads'), strlen($this->path));
    }
}
