<?php

use Doctrine\DBAL\Connection;

class Storage
{
    /**
     * @var Connection
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @param PersistedInterface $object
     * @return \PersistedInterface
     */
    public function save($object)
    {
        if(!is_null($object->id())) {
            $this->db->update('objects', array('serialized' => serialize($object)), array('id' => $object->id()));
        } else {
            $this->db->insert('objects', array('className' => get_class($object), 'serialized' => serialize($object)));
            $object->persisted($this->db->lastInsertId());
        }
        return $object;
    }

    public function load($id)
    {
        $row = $this->db->fetchAssoc('SELECT * FROM objects WHERE id = ?', array(intval($id)));
        if ($row) {
            $obj = unserialize($row['serialized']);
            $obj->persisted($id);
            return $obj;
        }
        return null;
    }
}