<?php

use Doctrine\DBAL\Connection;

class Storage
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var self
     */
    private static $instance;

    /**
     * @param self $storage
     */
    public static function register($storage)
    {
        self::$instance = $storage;
    }

    public static function get()
    {
        return self::$instance;
    }

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @param PersistedInterface $object
     * @param null|integer $ref
     * @return \PersistedInterface
     */
    public function save($object, $ref = null)
    {
        self::register($this);

        $data = array(
            'ref' => $ref,
            'className' => get_class($object),
            'serialized' => serialize($object),
            'meta' => join(',', $object->meta())
        );

        if(!is_null($object->id())) {
            $this->db->update('objects', $data, array('id' => $object->id()));
        } else {
            $this->db->insert('objects', $data);
            $object->persisted($this->db->lastInsertId());
        }
        return $object;
    }

    public function load($id)
    {
        self::register($this);

        $row = $this->db->fetchAssoc('SELECT * FROM objects WHERE id = ?', array(intval($id)));
        if ($row) {
            $obj = unserialize($row['serialized']);
            $obj->persisted($id);
            return $obj;
        }
        return null;
    }
}