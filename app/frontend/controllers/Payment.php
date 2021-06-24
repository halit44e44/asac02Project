<?php


namespace Yabasi\Frontend\Controllers;


use Phalcon\Mvc\Model;
use Yabasi\Paymenttype;

class Payment extends Model {

    public static function paymentMethods() {
        $methods = Paymenttype::find(array('conditions' => 'status=1', 'order' => 'id desc'));
        return $methods;
    }
}