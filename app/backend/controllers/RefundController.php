<?php


namespace Yabasi\Backend\Controllers;


use Yabasi\Address;
use Yabasi\Bank;
use Yabasi\City;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Images;
use Yabasi\Mail;
use Yabasi\Order;
use Yabasi\Ordertype;
use Yabasi\Refund;
use Yabasi\User;

class RefundController extends ControllerBase
{

    public function initialize()
    {
        self::getName();
        self::getModul();
        self::isAuthorityVolt();
        self::isAuthorityWrite("order");
        self::checkmodul('order');
        self::checkLicenceKey();
        self::isAuth();
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'order';
        $this->view->subpage = 'refund';
    }

    public function indexAction($table=false)
    {
        self::isAuthority("refund", "read");
        if ($table=="seen"){
            $refund=Refund::find("seen='1'");
            foreach ($refund as $refund){
                $refund->setSeen(0);
                $refund->update();
            }
        }
    }

    public function detailAction($id = false)
    {


        if (is_numeric($id)) {
            $refund = Refund::findFirst($id);
            if ($refund) {
                $refund->setSeen(0);
                $refund->update();
                $this->view->refund_code = $refund->getCode();
                $this->view->create_at = $refund->getCreatedAt();
                $this->view->refund_amount =(float) $refund->getRefundAmount();
                $this->view->id = $id;
                $this->view->note = $refund->getNote();
                $this->view->refund=$refund;

                $order = Order::findFirst($refund->getOrderId());
                if ($order) {
                        if ($order->getMetaKey()=='order'){
                        $detail = json_decode($order->getMetaValue(), true);
                            if ($detail) {
                                $product=Order::find('top_id='.$order->getId().' and meta_key="products" ');
                                $arr=array();
                                    foreach ($product as $product){
                                        $parse = json_decode($product->getMetaValue(), true);
                                        $ordertext=Ordertype::findFirst($product->getOrderStatus());
                                        $arr[]=array(
                                            'id'=>$parse['id'],
                                            'order_id'=>$product->getId(),
                                            'name'=>$parse['name'],
                                            'currency'=>$parse['currency'],
                                            'item_price'=>$product->getTotalPrice(),
                                            'status'=>$product->getOrderStatus(),
                                            'text'=>$ordertext->getName()
                                        );
                                    }



                                $this->view->code = $detail['code'];
                                $this->view->order_date = $order->getTotalPrice();
                                $this->view->branch = $detail['branch'];
                                $this->view->products = $arr;
                                $this->view->order_currency = $order->getCurrency();
                                $this->view->total_order = (float)$order->getTotalPrice();
                                $this->view->refund_currency = $order->getCurrency();
                                $image = Images::findFirst($detail['image']);
                                    if ($image) {
                                        $imageInfo = $image->getMetaValue();
                                        $this->view->image = $imageInfo;
                                    }

                                        $bank = Bank::findFirst($detail['bank']);
                                        if ($bank) {
                                            $this->view->bank_name = $bank->getName();
                                        }

                                    $this->view->orderStatusValue = $order->getOrderStatus();
                                    $orderStatus = Ordertype::find();
                                    if ($orderStatus) {
                                        $this->view->orderStatus = $orderStatus;
                                    }

                             }
                     }else if ($order->getMetaKey()=="products"){
                            $orders = Order::findFirst($order->getTopId());
                            $detail = json_decode($orders->getMetaValue(), true);
                            if ($detail) {
                                $product = Order::findFirst('id=' . $refund->getOrderId() . ' and meta_key="products" ');

                                $arr = array();

                                    $parse = json_decode($product->getMetaValue(), true);
                                    $ordertext = Ordertype::findFirst($product->getOrderStatus());
                                    $arr[] = array(
                                        'id' => $parse['id'],
                                        'order_id' => $product->getId(),
                                        'name' => $parse['name'],
                                        'currency' => $product->getCurrency(),
                                        'item_price' => $product->getTotalPrice(),
                                        'status' => $product->getOrderStatus(),
                                        'text' => $ordertext->getName()
                                    );

                                $this->view->code = $detail['code'];
                                $this->view->order_date = $order->getCreatedAt();
                                $this->view->products = $arr;
                                $this->view->order_currency = $order->getCurrency();
                                $this->view->total_order = $order->getTotalPrice();
                                $this->view->refund_currency = $order->getCurrency();
                                $image = Images::findFirst($detail['image']);
                                if ($image) {
                                    $imageInfo = $image->getMetaValue();
                                    $this->view->image = $imageInfo;
                                }

                                $bank = Bank::findFirst($detail['bank']);
                                if ($bank) {
                                    $this->view->bank_name = $bank->getName();
                                }

                                $this->view->orderStatusValue = $order->getOrderStatus();
                                $orderStatus = Ordertype::find();
                                if ($orderStatus) {
                                    $this->view->orderStatus = $orderStatus;
                                }
                            }

                        }
                }
                $user = User::findFirst($refund->getUserId());
                if ($user) {
                    $this->view->user_name = $user->getName();
                    $this->view->user_phone = $user->getPhone();
                    $this->view->user_email = $user->getEmail();

                    $address = Address::findFirst($refund->getUserId());
                    if ($address) {
                        $this->view->user_address = $address->getAddress();

                        $country = Country::findFirst($address->getCountryId());
                        if ($country) {
                            $this->view->user_country = $country->getCountryName();

                        }
                        $city = City::findFirst($address->getCityId());
                        if ($city) {
                            $this->view->user_city = $city->getCityName();

                        }

                        $dist = District::findFirst($address->getDistId());
                        if ($dist) {
                            $this->view->user_dist = $dist->getDistrictName();

                        }
                    }
                }

            }
        }
    }

    public function doAction($id = false, $status = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            $refund = Refund::findFirst($id);
            if ($refund) {
                $order_status = Order::findFirst($refund->getOrderId());
                if ($order_status) {
                    $order_status->setOrderStatus($status);
                    $order_status->save();
                }
            }
        }


    }
    public function saveAction($id = false,$text=false,$price=false)
    {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if (is_numeric($id)){
                $refund=Refund::findFirst($id);
                $order = Order::findFirst($refund->getOrderId());
                if ($order) {
                    if ($order->getMetaKey()=='order'){
                        $order->setOrderStatus('19');
                        $orderProduct=Order::find('top_id='.$refund->getOrderId());
                        if ($orderProduct){
                            foreach ($orderProduct as $orderProduct){
                                $orderProduct->setOrderStatus('19');
                                $orderProduct->update();
                            }
                        }
                        if ($text){
                            $refund->setNote($text);
                        }
                        if ($price){
                            $refund->setRefundAmount($price);
                        }
                        $refund->setStatus(2);
                        if ($order->save() && $refund->save()){
                            require APP_PATH.'/library/Mail.php';
                            $test = Mail::siparis($refund->getUserId(),$order->getId());
                            echo $test;
                        }


                    }
                    else if ($order->getMetaKey()=='products'){
                        $orderProduct=Order::findFirst($refund->getOrderId());
                        $orderProductPrice=$orderProduct->getTotalPrice();
                        $orderPrice=Order::findFirst($orderProduct->getTopId());
                        $orderPrices=$orderPrice->getTotalPrice();
                        $price=$orderPrices-$orderProductPrice;
                        $orderPrice->setTotalPrice($price);
                        $orderProduct->setOrderStatus('19');
                        if ($text){
                            $refund->setNote($text);
                        }
                        if ($price){
                            $refund->setRefundAmount($price);
                        }
                        if ($orderPrice->save() && $orderProduct->save() && $refund->save()){
                            require APP_PATH.'/library/Mail.php';

                            $test = Mail::siparis($refund->getUserId(),$order->getId());
                            echo $test;
                        }
                    }
                }
            }
        }

    }
    public function cancelAction($id=false,$text=false,$price=false){
        $this->view->disable();
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if (is_numeric($id)){
                $refund=Refund::findFirst($id);
                $order=Order::findFirst($refund->getOrderId());
                if ($order){
                    if ($order->getMetaKey()=='order'){
                        $order->setOrderStatus('18');
                        $orderProduct=Order::find('top_id='.$order->getId());
                        foreach ($orderProduct as $orderProduct){
                            $orderProduct->setOrderStatus('18');
                            $orderProduct->update();
                        }
                        if ($text){
                            $refund->setNote($text);
                        }
                        if ($price){
                            $refund->setRefundAmount($price);
                        }
                        $refund->setStatus(3);
                        if ($order->save() && $refund->save()){
                            require APP_PATH.'/library/Mail.php';

                            $test = Mail::siparis($refund->getUserId(),$order->getId());
                            echo $test;

                        }}
                    if ($order->getMetaKey()=='products'){
                        $order->setOrderStatus('18');
                        if ($text){
                            $refund->setNote($text);
                        }
                        if ($price){
                            $refund->setRefundAmount($price);
                        }
                        $refund->setStatus(3);
                        if ($order->save() && $refund->save()){
                            require APP_PATH.'/library/Mail.php';

                            $test = Mail::siparis($refund->getUserId(),$order->getId());
                            echo $test;
                        }
                    }
                }
            }
        }

    }
}
