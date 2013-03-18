<?php
namespace Test;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

class DbFixture
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    public $db;

    public function __construct()
    {
        $this->db = DriverManager::getConnection(
            array(
                'memory' => true,
                'user' => '',
                'password' => '',
                'driver' => 'pdo_sqlite',
            ),
            new Configuration
        );
    }

    public function install()
    {
        self::installSchema($this->db);
    }

//----------------------------------------------------------------------------------------------------------------------

    private static function installSchema(Connection $db)
    {
        $db->exec(<<<SQL

CREATE TABLE objects (
  id INTEGER CONSTRAINT pk_objects PRIMARY KEY AUTOINCREMENT,
  className VARCHAR(1024),
  serialized TEXT
);

SQL
        );
    }
}
