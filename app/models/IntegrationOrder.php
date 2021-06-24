<?php
namespace Yabasi;

class IntegrationOrder extends \Phalcon\Mvc\Model
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
    protected $order_code;

    /**
     *
     * @var string
     */
    protected $order_detail;

    /**
     *
     * @var string
     */
    protected $total_price;

    /**
     *
     * @var string
     */
    protected $status;

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
     * Method to set the value of field order_code
     *
     * @param string $order_code
     * @return $this
     */
    public function setOrderCode($order_code)
    {
        $this->order_code = $order_code;

        return $this;
    }

    /**
     * Method to set the value of field order_detail
     *
     * @param string $order_detail
     * @return $this
     */
    public function setOrderDetail($order_detail)
    {
        $this->order_detail = $order_detail;

        return $this;
    }

    /**
     * Method to set the value of field total_price
     *
     * @param string $total_price
     * @return $this
     */
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Returns the value of field order_code
     *
     * @return string
     */
    public function getOrderCode()
    {
        return $this->order_code;
    }

    /**
     * Returns the value of field order_detail
     *
     * @return string
     */
    public function getOrderDetail()
    {
        return $this->order_detail;
    }

    /**
     * Returns the value of field total_price
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("yabasi_shop");
        $this->setSource("integration_order");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationOrder[]|IntegrationOrder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return IntegrationOrder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
