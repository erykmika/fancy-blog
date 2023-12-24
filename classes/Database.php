<?php

// Import database configuration.
require '__DIR__/../db_config.php';

/**
 * This class represents a connection to a database. It utilizes the Singleton pattern.
 */
class Database
{

    /** @var Database $database The field for storing the Database instance */
    private static $database;

    /** @var PDO $con Connection to the database */
    private $con;

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->con = new PDO("mysql:host=". host . 
                             "; dbname=" . dbname, 
                             username,
                             password
                             );
    }

    /**
     * Get the Database instance
     * 
     * @return Database The database instance
     */
    public static function getDatabase()
    {
        if(Database::$database == null) {
            Database::$database = new Database();
        }
		
        return Database::$database;
    }

    /**
     * Get the database connection
     * 
     * @return PDO Connection to the database
     */
    public function getCon()
    {
        return $this->con;
    }
}
