<?php

namespace Core\Table;

use Cocur\Slugify\Slugify;
use Core\Database\MysqlDatabase;

/**
 * Class Table - Generic Class that manages all queries about tables
 */
abstract class AbstractTable
{
    /**
     * Database table name
     *
     * @var string $table
     */
    protected $table;

    /**
     * Database connection
     *
     * @var Core\Database\MysqlDatabase $db
     */
    protected $db;

    /**
     * Instance of Slugify Class
     *
     * @var Slugify
     */
    protected $slugify;

    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
        $this->slugify = new Slugify();

        if (empty($this->table)) {
            $parts = explode('\\', get_class($this));
            $className = end($parts);
            $this->table = strtolower(str_replace('Table', 's', $className));
			
        }
    }

    /**
     * Find all occurences about a database table
     *
     * @return Core\Entity\Entity
     */
    public function findAll()
    {
        return $this->db->query(
            'SELECT * FROM ' . $this->table . '',
            str_replace('Table', 'Entity', get_class($this))
        );
    }

    /**
     * Find one occurence about database table by id
     *
     * @param int $id
     * @return Core\Entity\Entity
     */
    public function findById($id)
    {
        return $this->db->prepare(
            "SELECT * FROM $this->table WHERE id = ?",
            [$id],
            str_replace('Table', 'Entity', get_class($this)),
            true
        );
    }

    /**
     * Delete a entry in a database table by Id 
     *
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        return $this->db->prepare("DELETE FROM $this->table WHERE id = $id", [$id]);
    }
}
