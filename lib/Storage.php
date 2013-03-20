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
            'serialized' => self::extractJsonPart(serialize($object)),
        );

        if(!is_null($object->id())) {
            $this->db->update('objects', $data, array('id' => $object->id()));
        } else {
            $this->db->insert('objects', $data);
            $object->persisted($this->db->lastInsertId());
        }
        return $object;
    }

    /**
     * @param integer $id
     * @return \PersistedInterface|null
     */
    public function load($id)
    {
        self::register($this);

        $row = $this->db->fetchAssoc('SELECT * FROM objects WHERE id = ?', array(intval($id)));
        if ($row) {
            $obj = unserialize(self::appendPhpSerializationPrefix($row['className'], $row['serialized']));
            $obj->persisted($id);
            return $obj;
        }
        return null;
    }

    /**
     * @param string $className
     * @return array id => serialized data
     */
    public function querySerializedData($className)
    {
        $stmt = $this->db->executeQuery('SELECT id, className, serialized FROM objects WHERE className = ?', array($className));

        $return = array();
        while($row = $stmt->fetch()) {
            $return[$row['id']] = self::appendPhpSerializationPrefix($row['className'], $row['serialized']);
        }
        return $return;
    }

//----------------------------------------------------------------------------------------------------------------------

    private static function extractJsonPart($phpSerializedString)
    {
        return substr($phpSerializedString, strpos($phpSerializedString, ':{') + 1);
    }

    private static function appendPhpSerializationPrefix($className, $json)
    {
        return 'C:' . strlen($className) . ':"' . $className . '":' . (mb_strlen($json) - 2) . ':' . $json;
    }
}