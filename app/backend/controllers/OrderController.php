<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

// sipariş sistemi
use Phalcon\Security;
use PHPMailer\PHPMailer\PHPMailer;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Mail;
use Yabasi\Ordertype;
use Yabasi\Address;
use Yabasi\Bank;
use Yabasi\Cargo;
use Yabasi\City;
use Yabasi\Images;
use Yabasi\Order;
use Yabasi\Paymenttype;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Settings;
use Yabasi\User;
use Yabasi\Variant;

class OrderController extends ControllerBase
{
    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuthorityVolt();
        self::isAuthorityWrite("order");
        self::checkmodul('order');
        self::isAuth();
        self::checkLicenceKey();
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'order';
        $this->view->subpage = 'order';
    }

    public function indexAction($id=false,$table=false)
    {
     if (is_numeric($id)&& $table=false) {
        $this->view->top_id = $id;

    }
     else if ( is_numeric($id) && $table="seen") {
         $this->view->top_id = $id;
         if ($id == "0") {
             $order = Order::find("seen=1 and meta_key='order'");
             if ($order) {
                 foreach ($order as $order) {
                     $order->setSeen(0);
                     $order->setUpdatedAt(self::getnow());
                     $order->update();
                 }
             }
         }else{
             $order = Order::findFirst($id);
             if ($order){
                 $order->setSeen(0);
                 $order->setUpdatedAt(self::getnow());
                 $order->update();
             }
         }
     }
        self::isAuthority("order", "read");

        $Paymenttype = Paymenttype::find('status=1');
        if ($Paymenttype) {
            $this->view->Paymenttype = $Paymenttype;
        }
        $byCargo = Cargo::find('status=1');
        if ($byCargo) {
            $this->view->byCargo = $byCargo;
        }

        $orderStatus = Ordertype::find('status=1');
        if ($orderStatus) {
            $this->view->orderStatus = $orderStatus;

        }


    }

    public function detailAction($id = false)
    {

        if (is_numeric($id)) {
            $order = Order::findFirst($id);
            if($order->getMetaKey()=="order"){
            $product=Order::find('top_id='.$id.' and meta_key="products" ');
            $arr=array();
            foreach ($product as $item){
                $parse = json_decode($item->getMetaValue(), true);
                $variants=$parse['variant'];
                $ordertext=Ordertype::findFirst($item->getOrderStatus());
                $variant=Productvariant::findFirst("pro_id=".$parse['id']." and variant_id="."'$variants'");
                $arr[]=array(
                   'id'=>$parse['id'],
                    'order_id'=>$item->getId(),
                    'name'=>$parse['name'],
                    'currency'=>$parse['currency'],
                    'item_price'=>$item->getTotalPrice(),
                    'status'=>$item->getOrderStatus(),
                    'piece'=>$item->getPiece(),
                    'text'=>$ordertext->getName(),
                    'variant'=>$this->variant($parse['id'],$parse['variant'])
                );
            }
            if ($order) {
                $this->view->order=$order;
                $detail = json_decode($order->getMetaValue(), true);
                if ($detail) {
                    $this->view->name = $detail['name'];
                    $this->view->user_id = $detail['user_id'];
                    $this->view->code = $detail['code'];
                    $this->view->bank = $detail['bank'];
                    $this->view->account_number = $detail['account_number'];
                    $this->view->branch = $detail['branch'];
                    $this->view->payment_type = Paymenttype::findFirst($detail['payment_type']);
                    $this->view-> cargo_price = (float)$detail['cargo_price'];
                    $this->view->user_id = $detail['cargo'];
                    $this->view->user_id = $detail['cargo_type'];
                    $this->view->cargo_currency = $detail['cargo_currency'];
                    $this->view->total_price = $detail['total_price'];
                    $this->view->order_currency = $order->getCurrency();
                    $this->view->gift_package = $detail['gift_package'];
                    $this->view->gift_note = $detail['gift_note'];
                    $this->view->order_date = $item->getCreatedAt();
                    $this->view->ip = $detail['ip'];
                    $this->view->created_at = $detail['created_at'];
                    $this->view->updated_at = $detail['updated_at'];
                    //$this->view->order_status = $detail['order_status'];
                    //$this->view->status = $detail['status'];
                    $this->view->currency =$order->getCurrency();
                    $this->view->products = $arr;

                    $this->view->delivery_address = $detail['delivery_address'];
                    $this->view->invoice_address = $detail['invoice_address'];
                    $this->view->id = $id;

                    /* logo */
                    $logo = Images::findFirst('meta_key="theme_content/logo"');
                    if ($logo) {
                        $this->view->logo = $logo->getMetaValue();
                    }

                    /* image işlemleri */
                    $image = Images::findFirst($detail['image']);
                    if ($image) {
                        $imageInfo = $image->getMetaValue();
                        $this->view->image = $imageInfo;
                    }

                    $bank = Bank::findFirst($detail['bank']);
                    if ($bank) {
                        $bankInfo = $bank->getName();
                        $this->view->bank = $bankInfo;
                    }

                    $cargo = Cargo::findFirst($detail['cargo']);
                    if ($cargo) {
                        $cargoInfo = $cargo->getName();
                        $this->view->cargo = $cargoInfo;
                    }

                    $adres = Settings::findFirst('name="adres"');
                    $adres_info = null;
                    if ($adres) {
                        $this->view->address = $adres->getValue();
                    }
                    $this->view->orderStatusValue = $order->getOrderStatus();
                    $orderStatus = Ordertype::find();
                    if ($orderStatus) {
                        $this->view->orderStatus = $orderStatus;
                    }


                    $user_name = '';
                    $user_idno = '';
                    $user = User::findFirst($order->getUserId());
                    if ($user) {
                        $user_name = $user->getName();
                        $user_idno = $user->getIdNo();
                        $this->view->user_name = $user_name;
                        $this->view->user_idno = $user_idno;
                    }

                }
            } else {
                $this->response->redirect('');
            }


        }}
    }

    public function updateAction()
    {
        self::isAuthority("order", "edit");
        $this->view->type = 'update';
    }

    public function insertAction()
    {
        self::isAuthority("order", "write");
        $this->view->type = 'insert';
    }

    public function doAction($id = false, $status = false)
    {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            $order = Order::findFirst($id);
            if ($status==9 || $status==10 || $status==11 || $status==19){

                if ($order->getMetaKey()=="products"){
                    $parse=json_decode($order->getMetaValue(),true);
                    if ($parse['variant']!=null){
                        $variants=$parse['variant'];
                        $variant=Productvariant::findFirst('pro_id='.$order->getProId()." and variant_id="."'$variants'");
                        $variant->setStock((int)$variant->getStock()+$order->getPiece());
                        if ($variant->save()){
                            echo "ok";

                        }
                    }
                    $order->setOrderStatus($status);
                    $order->update();
                    $product=Product::findFirst($order->getProId());
                    $product->setUnit($product->getUnit()+$order->getPiece());
                    $product->save();

                }else if($order->getMetaKey()=="order"){
                    $orders=Order::find("top_id=".$order->getId());
                    foreach ($orders as $orders){
                        if ($orders->getOrderStatus()!=9 && $orders->getOrderStatus()!=10 && $orders->getOrderStatus()!=11 && $orders->getOrderStatus()!=19){
                            $parse=json_decode($orders->getMetaValue(),true);
                            if ($parse['variant']!=null){
                                $variants=$parse['variant'];
                                $variant=Productvariant::findFirst('pro_id='.$orders->getProId()." and variant_id="."'$variants'");
                                $variant->setStock((int)$variant->getStock()+$orders->getPiece());
                                if ($variant->save()){
                                    echo "ok";

                                }
                            }
                            $orders->setOrderStatus($status);
                            $orders->update();
                            $product=Product::findFirst($orders->getProId());
                            $product->setUnit($product->getUnit()+$orders->getPiece());
                            $product->save();
                            $order->setOrderStatus($status);
                            $order->update();
                        }

                    }
                    require APP_PATH.'/library/Mail.php';

                    $test = Mail::siparis($order->getUserId(),$order->getId());
                    echo $test;
                }
            }
            else{
                if ($order->getMetaKey()=="products"){
                    $order->setOrderStatus($status);
                    $order->update();
                }
                else if($order->getMetaKey()=="order"){
                    $orders=Order::find("top_id=".$order->getId());
                    foreach ($orders as $orders){
                        if ($orders->getOrderStatus()!=9 && $orders->getOrderStatus()!=10 && $orders->getOrderStatus()!=11 && $orders->getOrderStatus()!=19){
                            $orders->setOrderStatus($status);
                            $orders->update();
                            $order->setOrderStatus($status);
                            $order->update();
                        }
                    }
                    require APP_PATH.'/library/Mail.php';

                    $test = Mail::siparis($order->getUserId(),$order->getId());
                    echo $test;
                }
            }
        }

    }
    public function variant($prodcut,$variants){
        $variant=Productvariant::findFirst("pro_id=".$prodcut." and variant_id="."'$variants'");
        $span="";
        if ($variant){
            $variants=explode(",",$variants);
            foreach ($variants as $str){
                $name=Variant::findFirst($str);
                $ana=Variant::findFirst($name->getTopId());
                $span.='<span>'.$ana->getName().':'.$name->getName() .'</span> <br>';
            }
            return $span;
        }
    }



    public function cargoAction($id = false, $cargo = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            $this->view->disable();
            if (is_numeric($id) && $cargo){
                $order=Order::findFirst($id);
                $order->setCargoNumber($cargo);
                $order->save();
            }
        }



    }
}
