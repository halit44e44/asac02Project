<?php
namespace Yabasi;

class IntegrationCategory extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $name;

    /**
     *
     * @var integer
     */
    protected $site_id;

    /**
     *
     * @var string
     */
    protected $place_top_id;

    /**
     *
     * @var string
     */
    protected $place_id;

    /**
     *
     * @var string
     */
    protected $custom_fields;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
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
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Method to set the value of field place_top_id
     *
     * @param string $place_top_id
     * @return $this
     */
    public function setPlaceTopId($place_top_id)
    {
        $this->place_top_id = $place_top_id;

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
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Returns the value of field place_top_id
     *
     * @return string
     */
    public function getPlaceTopId()
    {
        return $this->place_top_id;
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
        $this->setSource("integration_category");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationCategory[]|IntegrationCategory|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationCategory|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
