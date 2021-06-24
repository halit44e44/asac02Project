<?php

namespace Yabasi;

class Neighborhood extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $neighborhoodID;

    /**
     *
     * @var integer
     */
    protected $districtID;

    /**
     *
     * @var string
     */
    protected $neighborhoodName;

    /**
     *
     * @var string
     */
    protected $zipCode;

    /**
     * Method to set the value of field NeighborhoodID
     *
     * @param integer $neighborhoodID
     * @return $this
     */
    public function setNeighborhoodID($neighborhoodID)
    {
        $this->neighborhoodID = $neighborhoodID;

        return $this;
    }

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
     * Method to set the value of field NeighborhoodName
     *
     * @param string $neighborhoodName
     * @return $this
     */
    public function setNeighborhoodName($neighborhoodName)
    {
        $this->neighborhoodName = $neighborhoodName;

        return $this;
    }

    /**
     * Method to set the value of field ZipCode
     *
     * @param string $zipCode
     * @return $this
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Returns the value of field neighborhoodID
     *
     * @return integer
     */
    public function getNeighborhoodID()
    {
        return $this->neighborhoodID;
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
     * Returns the value of field neighborhoodName
     *
     * @return string
     */
    public function getNeighborhoodName()
    {
        return $this->neighborhoodName;
    }

    /**
     * Returns the value of field zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("neighborhood");
        $this->belongsTo('DistrictID', 'Yabasi\District', 'DistrictID', ['alias' => 'District']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Neighborhood[]|Neighborhood|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Neighborhood|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
