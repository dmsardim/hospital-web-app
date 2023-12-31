<?php

class Patients extends \Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public $sex;
    public $religion;
    public $phone;
    public $address;
    public $nik;

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("hospitaldb");
        $this->setSource("patients");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Patients[]|Patients|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Patients|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface {
        return parent::findFirst($parameters);
    }

}
