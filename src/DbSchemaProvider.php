<?php

namespace JacekB\MedioModelGenerator;

class DbSchemaProvider
{
    /**
     * @var $dbConnector DbConnector
     */
    private $dbConnector;

    /**
     * @param DbConnector $dbConnector
     */
    public function __construct(DbConnector $dbConnector)
    {
        $this->dbConnector = $dbConnector;
    }

    /**
     * @return array
     */
    public function getSchema()
    {
        $tablesList = $this->getTablesList();
        if(empty($tablesList)) {
            return array();
        }

        $result = array();
        foreach($tablesList as $tableName) {
            $columns = $this->getColumnListForTable($tableName);
            $result[$tableName] = $columns;
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getTablesList()
    {
        $statement = $this->dbConnector->getPDO()->query('SHOW TABLES');
        $result = $statement->fetchAll(\PDO::FETCH_NUM);

        foreach($result as $key => $value) {
            $result[$key] = $value[0];
        }

        return $result;
    }

    /**
     * @param string $tableName
     * @return array
     */
    private function getColumnListForTable($tableName)
    {
        $statement = $this->dbConnector->getPDO()->query('DESC ' . $tableName);
        $result = $statement->fetchAll();

        $columnList = array();
        foreach($result as $value) {
            $columnList[] = $value['Field'];
        }

        return $columnList;
    }


}