<?php

namespace Yabasi;

class Product extends \Phalcon\Mvc\Model
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
    protected $cats_id;

    /**
     *
     * @var string
     */
    protected $top_id;

    /**
     *
     * @var integer
     */
    protected $brand_id;

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     *
     * @var string
     */
    protected $variants;

    /**
     *
     * @var string
     */
    protected $variant_id;

    /**
     *
     * @var integer
     */
    protected $feature_id;

    /**
     *
     * @var integer
     */
    protected $supplier_id;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @var string
     */
    protected $short_content;

    /**
     *
     * @var string
     */
    protected $seo_title;

    /**
     *
     * @var string
     */
    protected $keyword;

    /**
     *
     * @var string
     */
    protected $search_keywords;

    /**
     *
     * @var string
     */
    protected $sef;

    /**
     *
     * @var string
     */
    protected $image;

    /**
     *
     * @var string
     */
    protected $purchase_price;

    /**
     *
     * @var string
     */
    protected $purchase_rate;

    /**
     *
     * @var string
     */
    protected $market_price;

    /**
     *
     * @var string
     */
    protected $market_rate;

    /**
     *
     * @var string
     */
    protected $sale_price;

    /**
     *
     * @var string
     */
    protected $sale_rate;

    /**
     *
     * @var string
     */
    protected $vat_definition;

    /**
     *
     * @var string
     */
    protected $vat_rate;

    /**
     *
     * @var string
     */
    protected $shipping_fee;

    /**
     *
     * @var string
     */
    protected $discount_type;

    /**
     *
     * @var integer
     */
    protected $discount_rate;

    /**
     *
     * @var integer
     */
    protected $transfer_discount;

    /**
     *
     * @var string
     */
    protected $barcode;

    /**
     *
     * @var string
     */
    protected $stock_code;

    /**
     *
     * @var integer
     */
    protected $unit;

    /**
     *
     * @var string
     */
    protected $unit_type;

    /**
     *
     * @var integer
     */
    protected $cargo_weight;

    /**
     *
     * @var string
     */
    protected $offer;

    /**
     *
     * @var string
     */
    protected $gift;

    /**
     *
     * @var string
     */
    protected $recommended_products;

    /**
     *
     * @var string
     */
    protected $warranty;

    /**
     *
     * @var string
     */
    protected $new_chance;

    /**
     *
     * @var string
     */
    protected $daily_chance;

    /**
     *
     * @var string
     */
    protected $unmissable_chance;

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
     *
     * @var string
     */
    protected $status;

    /**
     * Is data dont isset, return empty string
     *
     * @param string $price
     * @return real $price
    */
    private function dataIsExist($data)
    {
        if(isset($data) && !empty($data) && $data != null){
            return $data;
        }else{
            return "";
        }
    }

    /**
     * Method convert price text to real type 
     *
     * @param string $price
     * @return real $price
    */
    private function priceTextCorrector($price)
    {
        if(isset($price) && !empty($price) && $price != null){
            $price = str_replace(array("_.", "_"), "", $price);
            return str_replace(",", ".", $price);
        }else{
            return "";
        }
    }

    /**
     * Method convert price type to numbers
     *
     * @param string $type
     * @return integer $type
    */
    private function priceTypeConverter($type)
    {
        if(isset($type) && !empty($type) && $type != null){
            return str_replace(array("TL", "USD", "EURO"), array(1, 2, 3), $type);
        }else{
            return 0;
        }
    }

    /**
     * Method convert vat definition to numbers
     *
     * @param string $type
     * @return integer $type
    */
    private function definitionConverter($type)
    {
        if(isset($type) && !empty($type) && $type != null){
            return str_replace(array("price", "percentage"), array(1, 2), $type);
        }else{
            return 0;
        }
    }

    /**
     * Method convert vat definition to numbers
     *
     * @param string $type
     * @return integer $type
    */
    private function vatDefinitionConverter($type)
    {
        if(isset($type) && !empty($type) && $type != null){
            return str_replace(array("included", "notincluded"), array(1, 2), $type);
        }else{
            return 0;
        }
    }

     /**
     * Method convert discount type to numbers
     *
     * @param string $type
     * @return integer $type
    */
    private function discountTypeConverter($type)
    {
        if(isset($type) && !empty($type) && $type != null){
            return str_replace(array("price", "percentage"), array(1, 2), $type);
        }else{
            return 0;
        }
    }

    /**
     * Method convert unit type to numbers
     *
     * @param string $type
     * @return integer $type
     */
    private function unitTypeConverter($type)
    {
        if(isset($type) && !empty($type) && $type != null){
            $oldType = array("Piece", "cm", "Dozen", "gram", "kg", "Person", "Package", "metre", "m2", "pair");
            $newType = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
            return str_replace($oldType, $newType, $type);
        }else{
            return 0;
        }
    }

    /**
     * Method convert array to string
     *
     * @param array $data
     * @return string $data
     */
    private function arrayToString($data)
    {
        if(isset($data) && !empty($data) && $data != null){
            return @implode(",", $data);
        }else{
            return "";
        }
    }

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
     * Method to set the value of field id
     *
     * @param integer $top_id
     * @return $this
     */
    public function setTopId($top_id)
    {
        $this->top_id = $top_id;

        return $this;
    }

    /**
     * Method to set the value of field cats_id
     *
     * @param string $cats_id
     * @return $this
     */
    public function setCatsId($cats_id)
    {
        $this->cats_id = $cats_id;

        return $this;
    }

    /**
     * Method to set the value of field brand_id
     *
     * @param integer $brand_id
     * @return $this
     */
    public function setBrandId($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field variant_id
     *
     * @param string $variants
     * @return $this
     */
    public function setVariants($variants) {
        $this->variants = $variants;
        return $this;
    }

    /**
     * Method to set the value of field variant_id
     *
     * @param string $variant_id
     * @return $this
     */
    public function setVariantId($variant_id) {
        $this->variant_id = $variant_id;
        return $this;
    }

    /**
     * Method to set the value of field feature_id
     *
     * @param integer $feature_id
     * @return $this
     */
    public function setFeatureId($feature_id)
    {
        $this->feature_id = $this->arrayToString($feature_id);

        return $this;
    }

    /**
     * Method to set the value of field supplier_id
     *
     * @param integer $supplier_id
     * @return $this
     */
    public function setSupplierId($supplier_id)
    {
        $this->supplier_id = $supplier_id;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Method to set the value of field content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Method to set the value of field short_content
     *
     * @param string $short_content
     * @return $this
     */
    public function setShortContent($short_content)
    {
        $this->short_content = $short_content;

        return $this;
    }

    /**
     * Method to set the value of field seo_title
     *
     * @param string $seo_title
     * @return $this
     */
    public function setSeoTitle($seo_title)
    {
        $this->seo_title = $seo_title;

        return $this;
    }

    /**
     * Method to set the value of field keyword
     *
     * @param string $search_keywords
     * @return $this
     */
    public function setSearchKeywords($search_keywords)
    {
        $this->search_keywords = $this->dataIsExist($search_keywords);
        return $this;
    }

    /**
     * Method to set the value of field keyword
     *
     * @param string $keyword
     * @return $this
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $this->dataIsExist($keyword);
        return $this;
    }

    /**
     * Method to set the value of field sef
     *
     * @param string $sef
     * @return $this
     */
    public function setSef($sef)
    {
        $this->sef = $sef;

        return $this;
    }

    /**
     * Method to set the value of field image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

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
        $this->purchase_price = $this->priceTextCorrector($purchase_price);

        return $this;
    }

    /**
     * Method to set the value of field purchase_rate
     *
     * @param string $purchase_rate
     * @return $this
     */
    public function setPurchaseRate($purchase_rate)
    {
        $this->purchase_rate = $this->priceTypeConverter($purchase_rate);

        return $this;
    }

    /**
     * Method to set the value of field market_price
     *
     * @param string $market_price
     * @return $this
     */
    public function setMarketPrice($market_price)
    {
        $this->market_price = $this->priceTextCorrector($market_price);
        
        return $this;
    }

    /**
     * Method to set the value of field market_rate
     *
     * @param string $market_rate
     * @return $this
     */
    public function setMarketRate($market_rate)
    {
        $this->market_rate = $this->priceTypeConverter($market_rate);

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
        $this->sale_price = $this->priceTextCorrector($sale_price);

        return $this;
    }

    /**
     * Method to set the value of field sale_rate
     *
     * @param string $sale_rate
     * @return $this
     */
    public function setSaleRate($sale_rate)
    {
        $this->sale_rate = $this->priceTypeConverter($sale_rate);

        return $this;
    }

    /**
     * Method to set the value of field vat_definition
     *
     * @param string $vat_definition
     * @return $this
     */
    public function setVatDefinition($vat_definition)
    {
        $this->vat_definition = $this->vatDefinitionConverter($vat_definition);
        
        return $this;
    }

    /**
     * Method to set the value of field vat_rate
     *
     * @param string $vat_rate
     * @return $this
     */
    public function setVatRate($vat_rate)
    {
        $this->vat_rate = $vat_rate;

        return $this;
    }

    /**
     * Method to set the value of field shipping_fee
     *
     * @param string $shipping_fee
     * @return $this
     */
    public function setShippingFee($shipping_fee)
    {
        $this->shipping_fee = $this->priceTextCorrector($shipping_fee);

        return $this;
    }

    /**
     * Method to set the value of field discount_type
     *
     * @param string $discount_type
     * @return $this
     */
    public function setDiscountType($discount_type)
    {
        $this->discount_type = $this->discountTypeConverter($discount_type);

        return $this;
    }

    /**
     * Method to set the value of field discount_rate
     *
     * @param integer $discount_rate
     * @return $this
     */
    public function setDiscountRate($discount_rate)
    {
        $this->discount_rate = $discount_rate;

        return $this;
    }

    /**
     * Method to set the value of field transfer_discount
     *
     * @param integer $transfer_discount
     * @return $this
     */
    public function setTransferDiscount($transfer_discount)
    {
        $this->transfer_discount = $transfer_discount;

        return $this;
    }

    /**
     * Method to set the value of field barcode
     *
     * @param string $barcode
     * @return $this
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Method to set the value of field stock_code
     *
     * @param string $stock_code
     * @return $this
     */
    public function setStockCode($stock_code)
    {
        $this->stock_code = $stock_code;

        return $this;
    }

    /**
     * Method to set the value of field unit
     *
     * @param integer $unit
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Method to set the value of field unit_type
     *
     * @param string $unit_type
     * @return $this
     */
    public function setUnitType($unit_type)
    {
        $this->unit_type = $this->unitTypeConverter($unit_type);

        return $this;
    }

    /**
     * Method to set the value of field cargo_weight
     *
     * @param integer $cargo_weight
     * @return $this
     */
    public function setCargoWeight($cargo_weight)
    {
        $this->cargo_weight = $cargo_weight;

        return $this;
    }

    /**
     * Method to set the value of field offer
     *
     * @param string $offer
     * @return $this
     */
    public function setOffer($offer)
    {
        $this->offer = $this->arrayToString($offer);

        return $this;
    }

    /**
     * Method to set the value of field gift
     *
     * @param string $gift
     * @return $this
     */
    public function setGift($gift)
    {
        $this->gift = $this->arrayToString($gift);

        return $this;
    }

    /**
     * Method to set the value of field recommended_products
     *
     * @param string $recommended_products
     * @return $this
     */
    public function setRecommendedProducts($recommended_products)
    {
        $this->recommended_products = $this->arrayToString($recommended_products);

        return $this;
    }

    /**
     * Method to set the value of field warranty
     *
     * @param string $warranty
     * @return $this
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Method to set the value of field new_chance
     *
     * @param string $new_chance
     * @return $this
     */
    public function setNewChance($new_chance)
    {
        $this->new_chance = $new_chance;

        return $this;
    }

    /**
     * Method to set the value of field daily_chance
     *
     * @param string $daily_chance
     * @return $this
     */
    public function setDailyChance($daily_chance)
    {
        $this->daily_chance = $daily_chance;

        return $this;
    }

    /**
     * Method to set the value of field unmissable_chance
     *
     * @param string $unmissable_chance
     * @return $this
     */
    public function setUnmissableChance($unmissable_chance)
    {
        $this->unmissable_chance = $unmissable_chance;

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
     * Returns the value of field top_id
     *
     * @return integer
     */
    public function getTopId()
    {
        return $this->top_id;
    }

    /**
     * Returns the value of field cats_id
     *
     * @return string
     */
    public function getCatsId()
    {
        return $this->cats_id;
    }

    /**
     * Returns the value of field brand_id
     *
     * @return integer
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field variants
     *
     * @return string
     */
    public function getVariants()
    {
        return $this->variants;
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
     * Returns the value of field feature_id
     *
     * @return integer
     */
    public function getFeatureId()
    {
        return $this->feature_id;
    }

    /**
     * Returns the value of field supplier_id
     *
     * @return integer
     */
    public function getSupplierId()
    {
        return $this->supplier_id;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Returns the value of field content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the value of field short_content
     *
     * @return string
     */
    public function getShortContent()
    {
        return $this->short_content;
    }

    /**
     * Returns the value of field seo_title
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    /**
     * Returns the value of field keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Returns the value of field keyword
     *
     * @return string
     */
    public function getSearchKeywords()
    {
        return $this->search_keywords;
    }

    /**
     * Returns the value of field sef
     *
     * @return string
     */
    public function getSef()
    {
        return $this->sef;
    }

    /**
     * Returns the value of field image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * Returns the value of field purchase_rate
     *
     * @return string
     */
    public function getPurchaseRate()
    {
        return $this->purchase_rate;
    }

    /**
     * Returns the value of field market_price
     *
     * @return string
     */
    public function getMarketPrice()
    {
        return $this->market_price;
    }

    /**
     * Returns the value of field market_rate
     *
     * @return string
     */
    public function getMarketRate()
    {
        return $this->market_rate;
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
     * Returns the value of field sale_rate
     *
     * @return string
     */
    public function getSaleRate()
    {
        return $this->sale_rate;
    }

    /**
     * Returns the value of field vat_definition
     *
     * @return string
     */
    public function getVatDefinition()
    {
        return $this->vat_definition;
    }

    /**
     * Returns the value of field vat_rate
     *
     * @return string
     */
    public function getVatRate()
    {
        return $this->vat_rate;
    }

    /**
     * Returns the value of field shipping_fee
     *
     * @return string
     */
    public function getShippingFee()
    {
        return $this->shipping_fee;
    }

    /**
     * Returns the value of field discount_type
     *
     * @return string
     */
    public function getDiscountType()
    {
        return $this->discount_type;
    }

    /**
     * Returns the value of field discount_rate
     *
     * @return integer
     */
    public function getDiscountRate()
    {
        return $this->discount_rate;
    }

    /**
     * Returns the value of field transfer_discount
     *
     * @return integer
     */
    public function getTransferDiscount()
    {
        return $this->transfer_discount;
    }

    /**
     * Returns the value of field barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Returns the value of field stock_code
     *
     * @return string
     */
    public function getStockCode()
    {
        return $this->stock_code;
    }

    /**
     * Returns the value of field unit
     *
     * @return integer
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Returns the value of field unit_type
     *
     * @return string
     */
    public function getUnitType()
    {
        return $this->unit_type;
    }

    /**
     * Returns the value of field cargo_weight
     *
     * @return integer
     */
    public function getCargoWeight()
    {
        return $this->cargo_weight;
    }

    /**
     * Returns the value of field offer
     *
     * @return string
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Returns the value of field gift
     *
     * @return string
     */
    public function getGift()
    {
        return $this->gift;
    }

    /**
     * Returns the value of field recommended_products
     *
     * @return string
     */
    public function getRecommendedProducts()
    {
        return $this->recommended_products;
    }

    /**
     * Returns the value of field warranty
     *
     * @return string
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Returns the value of field new_chance
     *
     * @return string
     */
    public function getNewChance()
    {
        return $this->new_chance;
    }

    /**
     * Returns the value of field daily_chance
     *
     * @return string
     */
    public function getDailyChance()
    {
        return $this->daily_chance;
    }

    /**
     * Returns the value of field unmissable_chance
     *
     * @return string
     */
    public function getUnmissableChance()
    {
        return $this->unmissable_chance;
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
    public function initialize() {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("product");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product[]|Product|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
