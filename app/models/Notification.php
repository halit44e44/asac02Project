<?php

namespace Yabasi;

class Notification extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $email_news;

    /**
     *
     * @var string
     */
    protected $email_order;

    /**
     *
     * @var string
     */
    protected $sms_news;

    /**
     *
     * @var string
     */
    protected $sms_order;

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
     * Method to set the value of field email_news
     *
     * @param string $email_news
     * @return $this
     */
    public function setEmailNews($email_news)
    {
        $this->email_news = $email_news;

        return $this;
    }

    /**
     * Method to set the value of field email_order
     *
     * @param string $email_order
     * @return $this
     */
    public function setEmailOrder($email_order)
    {
        $this->email_order = $email_order;

        return $this;
    }

    /**
     * Method to set the value of field sms_news
     *
     * @param string $sms_news
     * @return $this
     */
    public function setSmsNews($sms_news)
    {
        $this->sms_news = $sms_news;

        return $this;
    }

    /**
     * Method to set the value of field sms_order
     *
     * @param string $sms_order
     * @return $this
     */
    public function setSmsOrder($sms_order)
    {
        $this->sms_order = $sms_order;

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
     * Returns the value of field email_news
     *
     * @return string
     */
    public function getEmailNews()
    {
        return $this->email_news;
    }

    /**
     * Returns the value of field email_order
     *
     * @return string
     */
    public function getEmailOrder()
    {
        return $this->email_order;
    }

    /**
     * Returns the value of field sms_news
     *
     * @return string
     */
    public function getSmsNews()
    {
        return $this->sms_news;
    }

    /**
     * Returns the value of field sms_order
     *
     * @return string
     */
    public function getSmsOrder()
    {
        return $this->sms_order;
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
    {  $model= new \Yabasi\ModelController();
        $this->setSchema($model->model());
        $this->setSource("notification");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notification[]|Notification|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notification|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
