<?php
namespace Yabasi;
class Productvariant extends \Phalcon\Mvc\Model
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
    protected $pro_id;

    /**
     *
     * @var string
     */
    protected $variant_id;

    /**
     *
     * @var string
     */
    protected $variant_name;

    /**
     *
     * @var string
     */
    protected $stock;

    /**
     *
     * @var string
     */
    protected $weight;

    /**
     *
     * @var string
     */
    protected $purchase_price;

    /**
     *
     * @var string
     */
    protected $sale_price;

    /**
     *
     * @var integer
     */
    protected $created_at;

    /**
     *
     * @var integer
     */
    protected $updated_at;

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
     * Method to set the value of field pro_id
     *
     * @param string $pro_id
     * @return $this
     */
    public function setProId($pro_id)
    {
        $this->pro_id = $pro_id;

        return $this;
    }

    /**
     * Method to set the value of field variant_id
     *
     * @param string $variant_id
     * @return $this
     */
    public function setVariantId($variant_id)
    {
        $this->variant_id = $variant_id;

        return $this;
    }

    /**
     * Method to set the value of field variant_name
     *
     * @param string $variant_name
     * @return $this
     */
    public function setVariantName($variant_name)
    {
        $this->variant_name = $variant_name;

        return $this;
    }

    /**
     * Method to set the value of field stock
     *
     * @param string $stock
     * @return $this
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Method to set the value of field weight
     *
     * @param string $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Method to set the value of field purchase_price
     *
     * @param string $purchase_price
     * @return $this
     */
    public function setPurchasePrice($purchase_price)
    {
        $this->purchase_price = $purchase_price;

        return $this;
    }

    /**
     * Method to set the value of field sale_price
     *
     * @param string $sale_price
     * @return $this
     */
    public function setSalePrice($sale_price)
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    /**
     * Method to set the value of field created_at
     *
     * @param integer $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Method to set the value of field updated_at
     *
     * @param integer $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

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
     * Returns the value of field pro_id
     *
     * @return string
     */
    public function getProId()
    {
        return $this->pro_id;
    }

    /**
     * Returns the value of field variant_id
     *
     * @return string
     */
    public function getVariantId()
    {
        return $this->variant_id;
    }

    /**
     * Returns the value of field variant_name
     *
     * @return string
     */
    public function getVariantName()
    {
        return $this->variant_name;
    }

    /**
     * Returns the value of field stock
     *
     * @return string
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Returns the value of field weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Returns the value of field purchase_price
     *
     * @return string
     */
    public function getPurchasePrice()
    {
        return $this->purchase_price;
    }

    /**
     * Returns the value of field sale_price
     *
     * @return string
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }

    /**
     * Returns the value of field created_at
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Returns the value of field updated_at
     *
     * @return integer
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("productvariant");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Productvariant[]|Productvariant|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Productvariant|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
