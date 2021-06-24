<?php
declare(strict_types=1);

namespace Yabasi\Frontend\Controllers;

use NumberFormatter;
use Phalcon\Mvc\View\Engine\Volt;
use Yabasi\Cargo;
use Yabasi\Comment;
use Yabasi\Content;
use Yabasi\ContentCats;
use Yabasi\Currency;
use Yabasi\Filter;
use Yabasi\Order;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Shopcart;
use Yabasi\User;
use Yabasi\Variant;

class InsertController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
    }
    public function commentAction($comment=false,$point=false,$anonim=false,$pro_id=false){
        $this->view->disable();
        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {
            $user=$this->getAuthId($auth);
            $browser= $_SERVER['HTTP_USER_AGENT'] ;
            $ip= $this->request->getClientAddress();
            if ($user!=0 && isset($browser) && isset($ip) && isset($comment) && isset($point) && isset($anonim) && isset($pro_id)){
                if ($this->request->isAjax()){
                    $comments=new Comment();
                    $comments->setProId($pro_id);
                    $comments->setUserId($user);
                    $comments->setAnonymous($anonim);
                    $comments->setComment($comment);
                    $comments->setCreatedAt(time());
                    $comments->setUpdatedAt(time());
                    $comments->setIpAddress($ip);
                    $comments->setUserAgent($browser);
                    $comments->setPoint($point);
                    $comments->setStatus(2);
                    $comments->setSeen(1);
                    if ($comments->save()){
                        self::point($user, 'comment');
                        echo "ok";
                    }
                }

            }
        }
    }
    public function shopcartAction($pro=false,$piece=false,$variant=false){
        $this->view->disable();

        $user = @$_COOKIE['auth'];
        $session_id = @$_COOKIE['session_id'];

     if (isset($session_id)){

         $shopcart=Shopcart::findFirst("pro_id=".$pro." and session_id="."'$session_id'");
            $product=Product::findFirst($pro);
            if ($shopcart && $shopcart->getMetaValue()!=null && $shopcart->getVoucher()==null){
                $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                if ($shopcart->count()>1){
                    $shopcart2=Shopcart::findFirst("pro_id=".$pro." and session_id="."'$session_id'" ." and meta_value="."'$variant'");
                    if ($shopcart2){
                        if ($variantpro->getStock()>=$piece+$shopcart2->getPiece()){
                            $pieces=$piece+$shopcart2->getPiece();
                            $shopcart2->setPiece($pieces);
                            if ($shopcart2->save()){
                                echo "ok";
                            }
                        }
                        else{
                            $pieces=$variantpro->getStock();
                            $shopcart2->setPiece($pieces);
                            if ($shopcart2->save()){
                                echo "ok";
                            }
                        }
                    }
                    else{
                        if ($piece>$variantpro->getStock()){
                            $piece=$variantpro->getStock();

                        }
                        $this->shopinsertSession($pro,$piece,$variant,$session_id);
                    }

                }
            }
            else   if (!$shopcart){
                if ($variant!=null){
                    $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                    if ($piece>$variantpro->getStock()){
                        $piece=$variantpro->getStock();
                    }
                }else{
                    if ($piece>$product->getUnit()){
                        $piece=$product->getUnit();

                    }
                }
                $this->shopinsertSession($pro,$piece,$variant,$session_id);
            }
            else{
                if ($variant!=null){
                    $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                    if ($piece>$variantpro->getStock()){
                        $piece=$variantpro->getStock();
                    }
                }

                $shopcart8=Shopcart::find("pro_id=".$pro." and meta_value="."'$variant'"." and session_id="."'$session_id'");
                if ($shopcart8->count()>1 && $variant!=null){
                    foreach ($shopcart8 as $shopcart8){

                        if ($variant==$shopcart8->getMetaValue() && $shopcart8->getVoucher()==null)
                        {
                            if ($variant!=null){

                                $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                                if ($piece+$shopcart8->getPiece() >$variantpro->getStock()){
                                    $piece=$variantpro->getStock();
                                    $shopcart8->setPiece($piece);
                                    $shopcart8->Save();
                                    echo "ok";
                                }else{
                                    $shopcart8->setPiece($piece+$shopcart8->getPiece());
                                    $shopcart8->Save();
                                    echo "ok";
                                }
                            }else{
                                if ($piece+$shopcart8->getPiece()>$product->getUnit()){
                                    $piece=$product->getUnit();
                                    $shopcart8->setPiece($piece);
                                    $shopcart8->Save();
                                    echo "ok";
                                }else{
                                    $shopcart8->setPiece($piece+$shopcart8->getPiece());
                                    $shopcart8->Save();
                                    echo "ok";
                                }
                            }

                        }
                    }
                }
                elseif ($variant==null ){

                    if ($shopcart->getVoucher()==null){
                        if ($piece+$shopcart->getPiece()>$product->getUnit()){
                            $piece=$product->getUnit();

                        }else{
                            $piece=$shopcart->getPiece()+$piece;
                        }
                        $shopcart->setPiece($piece);
                        if ($shopcart->save()){
                            echo "ok";
                        }
                    }else{
                        $shopcart8=Shopcart::find("pro_id=".$pro." and session_id="."'$session_id'");
                        if ($shopcart8->count()>1){

                            foreach ($shopcart8 as $item){
                                if ($item->getVoucher()==null){
                                    if ($piece+$item->getPiece()>$product->getUnit()){
                                        $piece=$product->getUnit();

                                    }else{
                                        $piece=$item->getPiece()+$piece;
                                    }
                                    $item->setPiece($piece);
                                    if ($item->save()){
                                        echo "ok";
                                    }
                                }
                            }
                        }else{
                            $this->shopinsertSession($pro,$piece,$variant,$session_id);
                        }
                    }
                }
                else{
                    $this->shopinsertSession($pro,$piece,$variant,$session_id);
                }
            }

        }
        else if ($user){

            $auth=$this->getAuthId($user);
            $shopcart=Shopcart::findFirst("pro_id=".$pro." and user_id=".$auth);
            $product=Product::findFirst($pro);
            if ($shopcart && $shopcart->getMetaValue()!=null && $shopcart->getVoucher()==null){
                $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                if ($shopcart->count()>1){
                    $shopcart2=Shopcart::findFirst("pro_id=".$pro." and user_id=".$auth ." and meta_value="."'$variant'");
                    if ($shopcart2){
                        if ($variantpro->getStock()>=$piece+$shopcart2->getPiece()){
                            $pieces=$piece+$shopcart2->getPiece();
                            $shopcart2->setPiece($pieces);
                            if ($shopcart2->save()){
                                echo "ok";
                            }
                        }
                        else{
                            $pieces=$variantpro->getStock();
                            $shopcart2->setPiece($pieces);
                            if ($shopcart2->save()){
                                echo "ok";
                            }
                        }
                    }
                   else{
                       if ($piece>$variantpro->getStock()){
                           $piece=$variantpro->getStock();

                       }
                       $this->shopinsertUser($pro,$piece,$variant,$user);
                   }

                }
            }
            else   if (!$shopcart){
                if ($variant!=null){
                    $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                    if ($piece>$variantpro->getStock()){
                        $piece=$variantpro->getStock();
                    }
                }else{
                    if ($piece>$product->getUnit()){
                        $piece=$product->getUnit();

                    }
                }
                $this->shopinsertUser($pro,$piece,$variant,$user);

            }
            else{
                if ($variant!=null){
                    $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                    if ($piece>$variantpro->getStock()){
                        $piece=$variantpro->getStock();
                    }
                }


                    $shopcart8=Shopcart::find("pro_id=".$pro." and meta_value="."'$variant'"." and user_id=".$auth);
                    if ($shopcart8->count()>1 && $variant!=null){
                        foreach ($shopcart8 as $shopcart8){

                            if ($variant==$shopcart8->getMetaValue() && $shopcart8->getVoucher()==null)
                            {
                                if ($variant!=null){

                                    $variantpro=Productvariant::findFirst("pro_id=".$pro." and variant_id="."'$variant'");
                                    if ($piece+$shopcart8->getPiece() >$variantpro->getStock()){
                                        $piece=$variantpro->getStock();
                                        $shopcart8->setPiece($piece);
                                        $shopcart8->Save();
                                        echo "ok";
                                    }else{
                                        $shopcart8->setPiece($piece+$shopcart8->getPiece());
                                        $shopcart8->Save();
                                        echo "ok";
                                    }
                                }else{
                                    if ($piece+$shopcart8->getPiece()>$product->getUnit()){
                                        $piece=$product->getUnit();
                                        $shopcart8->setPiece($piece);
                                        $shopcart8->Save();
                                        echo "ok";
                                    }else{
                                        $shopcart8->setPiece($piece+$shopcart8->getPiece());
                                        $shopcart8->Save();
                                        echo "ok";
                                    }
                                }

                            }
                        }
                    }
                    elseif ($variant==null ){

                        if ($shopcart->getVoucher()==null){
                            if ($piece+$shopcart->getPiece()>$product->getUnit()){
                                $piece=$product->getUnit();

                            }else{
                                $piece=$shopcart->getPiece()+$piece;
                            }
                            $shopcart->setPiece($piece);
                            if ($shopcart->save()){
                                echo "ok";
                            }
                        }else{
                            $shopcart8=Shopcart::find("pro_id=".$pro." and user_id=".$auth);
                            if ($shopcart8->count()>1){

                                foreach ($shopcart8 as $item){
                                    if ($item->getVoucher()==null){
                                        if ($piece+$item->getPiece()>$product->getUnit()){
                                            $piece=$product->getUnit();

                                        }else{
                                            $piece=$item->getPiece()+$piece;
                                        }
                                        $item->setPiece($piece);
                                        if ($item->save()){
                                            echo "ok";
                                        }
                                    }
                                }
                            }else{
                                $this->shopinsertUser($pro,$piece,$variant,$user);
                            }
                        }
                    }
                    else{
                        $this->shopinsertUser($pro,$piece,$variant,$user);
                    }
            }

            }

    }
    public function orderAction(){
        $price=$this->request->getPost("price");
        $Paymenttype=$this->request->getPost("payment_type");
        $cargoprice=$this->request->getPost("cargo");
        $cargofirma=$this->request->getPost("cargo_firma");
        $gift_package=$this->request->getPost("gift_package");
        $gift_note=$this->request->getPost("gift_note");
        if ($gift_package){
            $gift_package="Evet";
        }else(
            $gift_package="Hayır");
        $browser= $_SERVER['HTTP_USER_AGENT'] ;
        $ip= $this->request->getClientAddress();
        if ($cargoprice==0){
            $cargo_type=1;
        }else{
            $cargo_type=0;
        }
        $user = @$_COOKIE['auth'];
        if (isset($user)) {
            $users=$this->getUserId($user);
            $order=new Order();
            $order->setProId(0);
            $order->setStatus(1);
            $order->setUpdatedAt(time());
            $order->setCreatedAt(time());
            $order->setUserId($users);
            $order->setMetaKey("order");
            $order->setTopId(0);
            $order->setTotalPrice($price);
            $order->setOrderStatus(1);
            $order->setCurrency("TL");
            $random = new \Phalcon\Security\Random();
            $code =  $random->hex(9);
            $usd=Currency::findFirst("kur=usd");
            $euro=Currency::findFirst("kur=eur");
            $arr=array(
                "code"=>$code,
                "payment_type"=>$Paymenttype,
                "cargo"=>$cargofirma,
                "cargo_type"=>$cargo_type,
                "cargo_price"=>$cargoprice,
                "gift_package"=>$gift_package,
                "gift_note"=>$gift_note,
                "ip"=>$ip,
                "browser"=>$browser,
                "currency"=> [
                    "try"=>1.00,
                    "usd"=> $usd,
                    "euro"=> $euro,
                ],
                "delivery_address"=> "Karakavak Mah. Tepecik Sok. No:34",
                "invoice_address"=> "Akpınar Mah. Saray Sok. No:34"

            );
            $order->setMetaValue(json_decode($arr,true));
            $shopcart=Shopcart::find("user_id=".$users);

            foreach ($shopcart as $shopcart){
                $orders=New Order();
                $orders->setProId($shopcart->getProId());
                $product=Product::findFirst();
                $orders->setStatus(1);
                $orders->setUpdatedAt(time());
                $orders->setCreatedAt(time());
                $orders->setUserId($users);
                $orders->setMetaKey("products");
                $orders->setTopId($order->getId());
                $orders->setTotalPrice(self::totalprice($shopcart->getProId()));
                $orders->setOrderStatus(1);
                $orders->setCurrency("TL");
                $arr=array(
                    "id"=>$shopcart->getProId(),
                    "name"=>$product->getName(),
                    "currency"=>"TL"

                );
                $orders->setMetaValue(json_encode($arr));
                $shopcart->delete();
            }
        }

    }
    public function variantAction($id,$variant){
        $this->view->disable();
        if ($this->request->isajax()){
            $variant=Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variant'");
            if ($variant){
                if ($variant->getStock()>0){
                    echo "ok";
                }
            }
        }
    }
    public function shopinsertUser($pro,$piece,$variant,$user){
        $shop=new Shopcart();
        $shop->setUpdatedAt(time());
        $shop->setCreatedAt(time());
        $shop->setProId($pro);
        $shop->setPiece($piece);
        $shop->setSessionId("0");
        $shop->setMetaValue($variant);
        $shop->setUserId($this->getAuthId($user));
        if ($shop->save()){
            echo "ok";
        }
    }
    public function shopinsertSession($pro,$piece,$variant,$user){
        $shop=new Shopcart();
        $shop->setUpdatedAt(time());
        $shop->setCreatedAt(time());
        $shop->setProId($pro);
        $shop->setPiece($piece);
        $shop->setSessionId($user);
        $shop->setMetaValue($variant);
        $shop->setUserId("0");
        if ($shop->save()){
            echo "ok";
        }
    }
    public  function urunAction($id,$variant=false){
        $urun="";
        if ($variant==false){
            $pro=Product::findFirst($id);
            if ($pro->getUnit()==0){
                $urun.='  <a href="" class="spt_kapali ttu" lang="tr">Ürün Tukendi<i
                            class="las la-cart-plus"></i></a>';
            }else{
                $urun.=' <a href="javascript:void(0)" onclick="sepet()" class="spt_ekle ttu" lang="tr">Sepete Ekle<i
                            class="fas fa-cart-plus"></i></a>';
            }
        }else{
            $variant=Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variant'");
            if ($variant){
                if ($variant->getStock()>0){
                    $urun.=' <a href="javascript:void(0)" onclick="sepet()" class="spt_ekle ttu" lang="tr">Sepete Ekle<i
                            class="fas fa-cart-plus"></i></a>';
                }else{
                    $urun.='  <a href="" class="spt_kapali ttu" lang="tr">Ürün Tukendi<i
                            class="las la-cart-plus"></i></a>';
                }
            }else{
                $urun.='  <a href="" class="spt_kapali ttu" lang="tr">Ürün Tukendi<i
                            class="las la-cart-plus"></i></a>';
            }


        }

        return $urun;

    }
    public  function urunFiyatAction($id,$variant=false){
        $urun="";
        $pro=Product::findFirst($id);
        if ($variant==false){
            if ($pro->getDiscountRate()!=0 && $pro->getDiscountRate()!=null){
                $urun.='<div class="urn_ind">';
                $urun.=self::totaldiscount($pro->getId());
                $urun.='<span>indirim</span> </div>';
                $urun.='  <del> '.self::oldprice($pro->getid()).'</del>';
                $urun.='  <span> '.self::totalprice($pro->getid()).'</span>' ;


            }else{
                $urun.='<div class="urn_ind">';
                $urun.=self::totaldiscount($pro->getId());
                $urun.='<span>indirim</span> </div>';
                $urun.='  <del> '.self::oldprice($pro->getid()).'</del>';
                $urun.='  <span> '.self::totalprice($pro->getid()).'</span>' ;
                $urun.='<span>'.self::totalprice($pro->getid()).'</span>';
            }
        }else{
            $var=Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variant'");
            if ($var){
                if ($pro->getDiscountRate()!=0 && $pro->getDiscountRate()!=null) {
                    $urun .= '<div class="urn_ind">';
                    $urun .= self::totaldiscount($pro->getId());
                    $urun .= '<span>indirim</span> </div>';
                    $urun .= '  <del> ' . self::oldpricesepet($pro->getid(), $variant) . '</del>';
                    $urun .= '  <span> ' . self::totalprice($pro->getid(), $variant) . '</span>';
                }else{
                    $urun.='<span>'.self::totalprice($pro->getid(),$variant).'</span>';
                }
            }else{
                if ($pro->getDiscountRate()!=0 && $pro->getDiscountRate()!=null){
                    $urun.='<div class="urn_ind">';
                    $urun.=self::totaldiscount($pro->getId());
                    $urun.='<span>indirim</span> </div>';
                    $urun.='  <del> '.self::oldprice($pro->getid()).'</del>';
                    $urun.='  <span> '.self::totalprice($pro->getid()).'</span>' ;


                }else{
                    $urun.='<span>'.self::totalprice($pro->getid()).'</span>';
                }
            }

        }
        return $urun;

    }

}

