<?php

namespace App\Entity\Admin;

use Core\Entity\Entity;

class ImageEntity extends Entity
{
    /**
     * Get Short Text about Entitled
     * 
     */
    public function getShortEntitled()
    {
        if (strlen($this->entitled) <= 35) {
            return $this->entitled;
        }

        return substr($this->entitled, 0, 40) . '...';
    }

    /**
     * Get Short Text about Image Description
     * 
     */
    public function getExcerpt()
    {
        return substr($this->description, 0, 20) . '...';
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
