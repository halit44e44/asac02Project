<?php

namespace Yabasi;

class Cats extends \Phalcon\Mvc\Model
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
    protected $user_id;

    /**
     *
     * @var integer
     */
    protected $top_id;

    /**
     *
     * @var string
     */
    protected $seo_title;

    /**
     *
     * @var string
     */
    protected $sef;

    /**
     *
     * @var string
     */
    protected $keyword;

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
    protected $short_content;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @var string
     */
    protected $top_info;

    /**
     *
     * @var string
     */
    protected $sub_info;

    /**
     *
     * @var string
     */
    protected $unmissable_chance;

    /**
     *
     * @var string
     */
    protected $banner;

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
     * Method to set the value of field top_id
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
     * Method to set the value of field keyword
     *
     * @param string $keyword
     * @return $this
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

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
     * Method to set the value of field top_info
     *
     * @param string $top_info
     * @return $this
     */
    public function setTopInfo($top_info)
    {
        $this->top_info = $top_info;

        return $this;
    }

    /**
     * Method to set the value of field sub_info
     *
     * @param string $sub_info
     * @return $this
     */
    public function setSubInfo($sub_info)
    {
        $this->sub_info = $sub_info;

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
     * Method to set the value of field banner
     *
     * @param string $banner
     * @return $this
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

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
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * Returns the value of field seo_title
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
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
     * Returns the value of field keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
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
     * Returns the value of field short_content
     *
     * @return string
     */
    public function getShortContent()
    {
        return $this->short_content;
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
     * Returns the value of field top_info
     *
     * @return string
     */
    public function getTopInfo()
    {
        return $this->top_info;
    }

    /**
     * Returns the value of field sub_info
     *
     * @return string
     */
    public function getSubInfo()
    {
        return $this->sub_info;
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
     * Returns the value of field banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
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
    public function initialize()
    {
        $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("cats");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cats[]|Cats|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cats|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
