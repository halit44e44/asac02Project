<?php

namespace Yabasi;

class Town extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $townID;

    /**
     *
     * @var integer
     */
    protected $cityID;

    /**
     *
     * @var string
     */
    protected $townName;

    /**
     * Method to set the value of field TownID
     *
     * @param integer $townID
     * @return $this
     */
    public function setTownID($townID)
    {
        $this->townID = $townID;

        return $this;
    }

    /**
     * Method to set the value of field CityID
     *
     * @param integer $cityID
     * @return $this
     */
    public function setCityID($cityID)
    {
        $this->cityID = $cityID;

        return $this;
    }

    /**
     * Method to set the value of field TownName
     *
     * @param string $townName
     * @return $this
     */
    public function setTownName($townName)
    {
        $this->townName = $townName;

        return $this;
    }

    /**
     * Returns the value of field townID
     *
     * @return integer
     */
    public function getTownID()
    {
        return $this->townID;
    }

    /**
     * Returns the value of field cityID
     *
     * @return integer
     */
    public function getCityID()
    {
        return $this->cityID;
    }

    /**
     * Returns the value of field townName
     *
     * @return string
     */
    public function getTownName()
    {
        return $this->townName;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("town");
        $this->hasMany('TownID', 'Yabasi\District', 'TownID', ['alias' => 'District']);
        $this->belongsTo('CityID', 'Yabasi\City', 'CityID', ['alias' => 'City']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Town[]|Town|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Town|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
