<?php

namespace Yabasi;

class City extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $cityID;

    /**
     *
     * @var integer
     */
    protected $countryID;

    /**
     *
     * @var string
     */
    protected $cityName;

    /**
     *
     * @var string
     */
    protected $plateNo;

    /**
     *
     * @var string
     */
    protected $phoneCode;

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
     * Method to set the value of field CountryID
     *
     * @param integer $countryID
     * @return $this
     */
    public function setCountryID($countryID)
    {
        $this->countryID = $countryID;

        return $this;
    }

    /**
     * Method to set the value of field CityName
     *
     * @param string $cityName
     * @return $this
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Method to set the value of field PlateNo
     *
     * @param string $plateNo
     * @return $this
     */
    public function setPlateNo($plateNo)
    {
        $this->plateNo = $plateNo;

        return $this;
    }

    /**
     * Method to set the value of field PhoneCode
     *
     * @param string $phoneCode
     * @return $this
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phoneCode = $phoneCode;

        return $this;
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
     * Returns the value of field countryID
     *
     * @return integer
     */
    public function getCountryID()
    {
        return $this->countryID;
    }

    /**
     * Returns the value of field cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Returns the value of field plateNo
     *
     * @return string
     */
    public function getPlateNo()
    {
        return $this->plateNo;
    }

    /**
     * Returns the value of field phoneCode
     *
     * @return string
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("city");
        $this->hasMany('CityID', 'Yabasi\Town', 'CityID', ['alias' => 'Town']);
        $this->belongsTo('CountryID', 'Yabasi\Country', 'CountryID', ['alias' => 'Country']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return City[]|City|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return City|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
