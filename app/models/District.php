<?php

namespace Yabasi;

class District extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $districtID;

    /**
     *
     * @var integer
     */
    protected $townID;

    /**
     *
     * @var string
     */
    protected $districtName;

    /**
     * Method to set the value of field DistrictID
     *
     * @param integer $districtID
     * @return $this
     */
    public function setDistrictID($districtID)
    {
        $this->districtID = $districtID;

        return $this;
    }

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
     * Method to set the value of field DistrictName
     *
     * @param string $districtName
     * @return $this
     */
    public function setDistrictName($districtName)
    {
        $this->districtName = $districtName;

        return $this;
    }

    /**
     * Returns the value of field districtID
     *
     * @return integer
     */
    public function getDistrictID()
    {
        return $this->districtID;
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
     * Returns the value of field districtName
     *
     * @return string
     */
    public function getDistrictName()
    {
        return $this->districtName;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("district");
        $this->hasMany('DistrictID', 'Yabasi\Neighborhood', 'DistrictID', ['alias' => 'Neighborhood']);
        $this->belongsTo('TownID', 'Yabasi\Town', 'TownID', ['alias' => 'Town']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return District[]|District|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return District|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
