<?php

namespace Core\Entity;

use DateTime;

/**
 * class Entity - Generic class that represents a database record 
 */
abstract class Entity
{
    /**
     * Format a field to date without hours
     *
     * @param \DateTime $field
     * @return \DateTime
     */
    public function getDateWhithoutHours($field)
    {
        return (new DateTime($field))->format('d/m/Y');
    }

    /**
     * Format a field to date with hours
     *
     * @param \DateTime $field
     * @return \DateTime
     */
    public function getDateWithHours($field)
    {
        return (new DateTime($field))->format('d/m/Y à H:i:s');
    }

    /**
     * Get the small Text about one field
     *
     * @return string
     */
    public function getShortText($field, $limit)
    {
        return substr($field, 0, $limit) . '...';
    }
}
