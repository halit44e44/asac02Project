<?php
namespace Yabasi;

class IntegrationProduct extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $place;

    /**
     *
     * @var integer
     */
    protected $site_id;

    /**
     *
     * @var string
     */
    protected $place_id;

    /**
     *
     * @var string
     */
    protected $place_category;

    /**
     *
     * @var string
     */
    protected $custom_fields;


    /**
     * Method to set the value of field id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field place
     *
     * @param integer $place
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Method to set the value of field site_id
     *
     * @param integer $site_id
     * @return $this
     */
    public function setSiteId($site_id)
    {
        $this->site_id = $site_id;

        return $this;
    }

    /**
     * Method to set the value of field place_id
     *
     * @param string $place_id
     * @return $this
     */
    public function setPlaceId($place_id)
    {
        $this->place_id = $place_id;

        return $this;
    }

    /**
     * Method to set the value of field place_category
     *
     * @param string $place_category
     * @return $this
     */
    public function setPlaceCategory($place_category)
    {
        $this->place_category = $place_category;

        return $this;
    }

    /**
     * Method to set the value of field custom_fields
     *
     * @param string $custom_fields
     * @return $this
     */
    public function setCustomFields($custom_fields)
    {
        $this->custom_fields = $custom_fields;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field place
     *
     * @return integer
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Returns the value of field site_id
     *
     * @return integer
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * Returns the value of field place_id
     *
     * @return string
     */
    public function getPlaceId()
    {
        return $this->place_id;
    }

    /**
     * Returns the value of field place_category
     *
     * @return string
     */
    public function getPlaceCategory()
    {
        return $this->place_category;
    }

    /**
     * Returns the value of field custom_fields
     *
     * @return string
     */
    public function getCustomFields()
    {
        return $this->custom_fields;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("yabasi_shop");
        $this->setSource("integration_product");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationProduct[]|IntegrationProduct|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationProduct|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
