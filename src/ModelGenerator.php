<?php

namespace JacekB\MedioModelGenerator;

use \Gnugat\Medio\Model\Method;
use \Gnugat\Medio\Model\Argument;
use \Gnugat\Medio\Model\Object;
use \Gnugat\Medio\Model\Property;
use \Gnugat\Medio\PrettyPrinter;

class ModelGenerator
{

    /**
     * @var \Gnugat\Medio\PrettyPrinter
     */
    private $medioPrettyPrinter;

    /**
     * @param PrettyPrinter $medioPrettyPrinter
     */
    public function __construct(PrettyPrinter $medioPrettyPrinter)
    {
        $this->medioPrettyPrinter = $medioPrettyPrinter;
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

        return $this->medioPrettyPrinter->generateCode($object);
    }
}
