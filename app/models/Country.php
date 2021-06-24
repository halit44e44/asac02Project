<?php

namespace Yabasi;

class Country extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $countryID;

    /**
     *
     * @var string
     */
    protected $binaryCode;

    /**
     *
     * @var string
     */
    protected $tripleCode;

    /**
     *
     * @var string
     */
    protected $countryName;

    /**
     *
     * @var string
     */
    protected $phoneCode;

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
     * Method to set the value of field BinaryCode
     *
     * @param string $binaryCode
     * @return $this
     */
    public function setBinaryCode($binaryCode)
    {
        $this->binaryCode = $binaryCode;

        return $this;
    }

    /**
     * Method to set the value of field TripleCode
     *
     * @param string $tripleCode
     * @return $this
     */
    public function setTripleCode($tripleCode)
    {
        $this->tripleCode = $tripleCode;

        return $this;
    }

    /**
     * Method to set the value of field CountryName
     *
     * @param string $countryName
     * @return $this
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

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
     * Returns the value of field countryID
     *
     * @return integer
     */
    public function getCountryID()
    {
        return $this->countryID;
    }

    /**
     * Returns the value of field binaryCode
     *
     * @return string
     */
    public function getBinaryCode()
    {
        return $this->binaryCode;
    }

    /**
     * Returns the value of field tripleCode
     *
     * @return string
     */
    public function getTripleCode()
    {
        return $this->tripleCode;
    }

    /**
     * Returns the value of field countryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
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
        $this->setSource("country");
        $this->hasMany('CountryID', 'Yabasi\City', 'CountryID', ['alias' => 'City']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Country[]|Country|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Country|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
