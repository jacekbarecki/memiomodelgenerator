<?php

namespace JacekB\MemioModelGenerator;

use \Memio\Memio\Model\Method;
use \Memio\Memio\Model\Argument;
use \Memio\Memio\Model\Object;
use \Memio\Memio\Model\Property;
use \Memio\Memio\PrettyPrinter;

class ModelGenerator
{

    /**
     * @var \Memio\Memio\PrettyPrinter
     */
    private $memioPrettyPrinter;

    /**
     * @param PrettyPrinter $memioPrettyPrinter
     */
    public function __construct(PrettyPrinter $memioPrettyPrinter)
    {
        $this->memioPrettyPrinter = $memioPrettyPrinter;
    }

    /**
     * @return string
     */
    public function getModelsCode()
    {
        $dbConnector = new DbConnector();
        $dbSchemaProvider = new DbSchemaProvider($dbConnector);
        $schema = $dbSchemaProvider->getSchema();

        $output = '';
        foreach($schema as $tableName => $columnList) {
            $output .= $this->generateModelCode($tableName, $columnList);
            $output .= PHP_EOL;
        }
        return $output;

    }

    /**
     * @param string $modelName
     * @param array $columns
     * @return string
     */
    private function generateModelCode($modelName, array $columns) {
        $object = new Object(ucfirst($modelName));

        foreach($columns as $column) {
            $property = Property::make($column);
            $object->addProperty($property);

            $getter = Method::make('get' . ucfirst($column))->setBody('return $this->' . $column . ';');
            $object->addMethod($getter);

            $setterArgument = Argument::make('string', $column);
            $setter = Method::make('set' . ucfirst($column))->addArgument($setterArgument)->setBody('$this->' . $column . ' = $' . $column . ';');
            $object->addMethod($setter);
        }

        return $this->memioPrettyPrinter->generateCode($object);
    }
}
