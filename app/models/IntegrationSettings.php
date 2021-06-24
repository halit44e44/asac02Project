<?php
namespace Yabasi;

class IntegrationSettings extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $settings_data;

    /**
     *
     * @var string
     */
    protected $setup;

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
     * Method to set the value of field settings_data
     *
     * @param string $settings_data
     * @return $this
     */
    public function setSettingsData($settings_data)
    {
        $this->settings_data = $settings_data;

        return $this;
    }

    /**
     * Method to set the value of field setup
     *
     * @param string $setup
     * @return $this
     */
    public function setSetup($setup)
    {
        $this->setup = $setup;

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
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field settings_data
     *
     * @return string
     */
    public function getSettingsData()
    {
        return $this->settings_data;
    }

    /**
     * Returns the value of field setup
     *
     * @return string
     */
    public function getSetup()
    {
        return $this->setup;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("yabasi_shop");
        $this->setSource("integration_settings");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationSettings[]|IntegrationSettings|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationSettings|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
