<?php

class DbConnector {

    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct()
    {
        $this->PDO = new PDO("mysql:host=" . Config::DATABASE_HOST . ";dbname=" . Config::DATABASE_NAME , Config::DATABASE_USERNAME, Config::DATABASE_PASSWORD);
        $this->PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

    public function __destruct()
    {
        $this->PDO = null;
    }

    public function getPDO()
    {
        return $this->PDO;
    }

}