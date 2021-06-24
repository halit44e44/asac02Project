<?php


namespace Yabasi\Frontend\Controllers;


use Phalcon\Security;
use Phalcon\Security\Random;
use Yabasi\Address;
use Yabasi\Bank;
use Yabasi\Cargo;
use Yabasi\Cats;
use Yabasi\City;
use Yabasi\Content;
use Yabasi\Country;
use Yabasi\Currency;
use Yabasi\Images;
use Yabasi\Mail;
use Yabasi\Order;
use Yabasi\Paymenttype;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Settings;
use Yabasi\Shopcart;
use Yabasi\Town;
use Yabasi\User;
use Yabasi\Vouchers;
use Yabasi\Voucheruse;

class SepetController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->sepetStok();
        $this->view->page = 'basket';
    }

    public function indexAction() {

        $cargo=Settings::findFirst("name='cargo'");
        if ($cargo){
            $this->view->cargo=$cargo->getValue();
        }

        $oneriler = Product::find(array('conditions' => 'status=1', 'limit' => 5, 'order' => 'rand()'));
        if (count($oneriler) > 0) {
            $this->view->oneriler = $oneriler;
        }

        $auth = @$_COOKIE['auth'];
        if (isset($auth)){
            $user=$this->getAuthId($auth);
            $this->view->user=$user;

            $shopcart=Shopcart::find("user_id=".$user);
            if (count($shopcart) > 0) {
                $this->view->shopcart=$shopcart;
                $this->view->shopcarts=$shopcart;
                $this->view->count=$shopcart->count();
            }

        }

        $user = @$_COOKIE['session_id'];
        if (isset($user)){
            $shopcart=Shopcart::find("session_id="."'$user'");
            if (count($shopcart) > 0) {
                $this->view->shopcart=$shopcart;
                $this->view->shopcarts=$shopcart;
                $this->view->count=$shopcart->count();
                $this->view->user=$user;
            }
        }

    }

    public function adresAction() {
        $cargo=Settings::findFirst("name='cargo'");
        $ulkeler = Country::find();
        if ($ulkeler) {
            $this->view->ulkeler = $ulkeler;
        }

        $sehirler = City::find();
        if ($sehirler) {
            $this->view->sehirler = $sehirler;
        }

        $ilceler = Town::find();
        if ($ilceler) {
            $this->view->ilceler = $ilceler;
        }
        if ($cargo){
            $this->view->cargo=$cargo->getValue();
        }

        $auth = @$_COOKIE['auth'];

        if (isset($auth)){
            $user=$this->getAuthId($auth);
            $shopcart=Shopcart::find("user_id=".$user);
            if ($shopcart->count()==0){
                $this->response->redirect('');
            }
            $this->view->shopcart=$shopcart;
            $this->view->shopcarts=$shopcart;
            $this->view->count=$shopcart->count();
            $this->view->user=$user;
            $adress=Address::find("user_id=".$user);
            $this->view->adres=$adress;
            $this->view->faturaadres=$adress;
            $this->view->session="no";


        }if (isset($_COOKIE['session_id'])){
            //$user=$_COOKIE['session_id'];
            $user = $_COOKIE['session_id'];
            $shopcart=Shopcart::find("session_id="."'$user'");
            $this->view->shopcart=$shopcart;
            $this->view->shopcarts=$shopcart;
            $this->view->user=$user;
            $this->view->count=$shopcart->count();
            $this->view->session="ok";
        }

    }

    public function odemeAction($teslimat=false,$fatura=false) {


        if (!$teslimat || !$fatura ){
            $this->response->redirect('sepet/adres');
        }

        if (is_numeric($teslimat) && is_numeric($fatura)){

            $teslimatAdres  = Address::findFirst('id='.$teslimat ." and user_id=".$this->getUserId());
            $faturaAdres    = Address::findFirst('id='.$fatura ." and user_id=".$this->getUserId());
            $settingCurency    = Settings::findFirst('name="main_currency"');

            $this->view->adres       = $teslimatAdres;
            $this->view->faturaadres = $faturaAdres;

            if (!$teslimatAdres){
                $this->response->redirect('sepet/adres');
            }

            if (!$faturaAdres){
                $this->response->redirect('sepet/adres');
            }


            $bank = Bank::find("status=1");
            if (count($bank) > 0) {
                $this->view->bank = $bank;
            }

            $cargoFirma = Cargo::find("status=1");
            if (count($cargoFirma) > 0) {
                $this->view->cargofirma = $cargoFirma;
            }

            $cargo = Settings::findFirst("name='cargo'");
            if ($cargo){
                $this->view->cargo  = $cargo->getValue();
            }

            $auth = @$_COOKIE['auth'];

            if (isset($auth)){
                $user                   = $this->getAuthId($auth);
                $shopcart               = Shopcart::find("user_id=".$user);
                $this->view->shopcart   = $shopcart;
                $this->view->shopcarts  = $shopcart;
                $this->view->count      = $shopcart->count();
                $this->view->user       = $user;
            } else {
                $this->response->redirect('uye/giris');
            }

            if ($this->request->isPost()) {
                $this->view->disable();
                if ($this->cargocity($teslimatAdres->getCityId(),$teslimatAdres->getCityId())=="true"){
                    $cargoprice=0;
                    $price=$this->sepettoplam($user,$user);
                }
                elseif ($cargo->getValue() !=null){
                    if (round($this->sepettoplam($user,$user)-$cargo->getValue())>=0){
                        $cargoprice=0;
                        $price=$this->sepettoplam($user,$user);
                    }
                    else{
                        $cargoprice=self::cargo($user,$user);
                        $price=$this->sepettoplam($user,$user)+self::cargo($user,$user);
                    }
                }
                else{
                    $cargoprice=self::cargo($user,$user);
                    $price=$this->sepettoplam($user,$user)+self::cargo($user,$user);
                }

                $Paymenttype    = $this->request->getPost("odeme");
                $cargofirma     = $this->request->getPost("cargo_firma");
                $gift_package   = $this->request->getPost("gift_package");
                $gift_note      = $this->request->getPost("gift_note");
                $adres          = $this->request->getPost("adress");
                $fatura_adres   = $this->request->getPost("faturaadres");

                if ($gift_package){
                    $gift_package = 1;
                } else {
                    $gift_package = 2;
                }

                $browser = $_SERVER['HTTP_USER_AGENT'] ;
                $ip      = $this->request->getClientAddress();

                if ($cargoprice == 0){
                    $cargo_type = 1;
                } else {
                    $cargo_type = 0;
                }

                $user = @$_COOKIE['auth'];
                $users  = $this->getUserId($user);
                $city   = City::findFirst($teslimatAdres->getCityId());

                $random = new Random();
                $code   = $random->hex(6);

                $order = new Order();
                $order->setProId(0);
                $order->setStatus(1);
                $order->setUpdatedAt(time());
                $order->setCreatedAt(time());
                $order->setUserId($users);
                $order->setMetaKey("order");
                $order->setCity($city->getCityName());
                $order->setPiece(0);
                $order->setTopId(0);
                $order->setTotalPrice($price);
                $order->setOrderStatus(1);
                $order->setCurrency($settingCurency->getValue());

                $usd    = Currency::findFirst("kur='usd'");
                $euro   = Currency::findFirst("kur='eur'");

                $arr = array(
                    "code"          => $code,
                    "payment_type"  => $Paymenttype,
                    "cargo"         => $cargofirma,
                    "cargo_type"    => $cargo_type,
                    "cargo_price"   => $cargoprice,
                    "gift_package"  => $gift_package,
                    "gift_note"     => $gift_note,
                    "ip"            => $ip,
                    "browser"       => $browser,
                    "currency"=> [
                        "try"  => 1.00,
                        "usd"  => $usd->getForexBuying(),
                        "euro" => $euro->getForexBuying(),
                    ],
                    "delivery_address" => $adres,
                    "invoice_address"  => $fatura_adres
                );

                $order->setMetaValue(json_encode($arr));
                if ($order->save()){
                    $this->log($auth,$order->getId(),"order","successful");
                    $this->response->redirect('sepet/basarili/'.$code);
                } else {
                    $this->log($auth,$order->getId(),"order","unsuccessful");
                    $this->response->redirect('sepet/basarisiz/');
                }

                $shopcart = Shopcart::find("user_id=".$this->getAuthId($user));


                foreach ($shopcart as $shopcart){
                    $orders = New Order();

                    $product = Product::findFirst($shopcart->getProId());
                    $rate    = $product->getSaleRate();
                    if ($rate) {
                        $sale_rate = 'TL';
                        if ($rate == 2) {
                            $sale_rate = 'USD';
                        } else if ($rate == 3) {
                            $sale_rate = 'EURO';
                        }
                    }

                    $orders->setProId($shopcart->getProId());
                    $orders->setStatus(1);
                    $orders->setUpdatedAt(time());
                    $orders->setCreatedAt(time());
                    $orders->setUserId($users);
                    $orders->setMetaKey("products");
                    $orders->setCity($city->getCityName());
                    $orders->setTopId($order->getId());
                    $orders->setPiece($shopcart->getPiece());
                    $orders->setTotalPrice(self::totalprice($shopcart->getProId(),$shopcart->getMetaValue(),true));
                    $orders->setOrderStatus(1);
                    $orders->setCurrency($sale_rate);

                    $arr = array(
                        "id"=>$shopcart->getProId(),
                        "name"=>$product->getName(),
                        "variant"=>$shopcart->getMetaValue(),
                        "currency"=>"$sale_rate"

                    );

                    $orders->setMetaValue(json_encode($arr));
                    if ($orders->save()){
                        $shopcart->delete();
                        $stock=$product->getUnit();
                        $product->setUnit($stock-$shopcart->getPiece());
                        $product->save();

                        $variantId = $shopcart->getMetaValue();
                        if ($shopcart->getMetaValue()!=null){
                            $proVariant = Productvariant::findFirst("pro_id=".$product->getId()." and variant_id="."'$variantId'"  );
                            $proVariant->setStock($proVariant->getStock()-$shopcart->getPiece());
                            $proVariant->save();
                        }



                    }
                    self::point($users, 'shopping');


                }
                require APP_PATH.'/library/Mail.php';
                $mail = Mail::siparis($this->getAuthId($user),$order->getId());
                if ($mail) {
                    echo $mail;
                } else {return false;}

            }
        }
        else{
            $this->response->redirect('sepet/adres');
        }

    }

    public function basariliAction($code = false) {
        if ($code) {
            $this->view->code = $code;
        }
    }

    public function basarisizAction() {

    }


    public function deleteAction($id) {
        $this->view->disable();
        if (is_numeric($id)){
            if ($this->request->isAjax()){
                $shopcart=Shopcart::findFirst($id);
                if ($shopcart->delete()){
                    echo "ok";
                }
            }
        }
    }

    public function adetAction($id=false,$adet=false) {
        $this->view->disable();
        if (is_numeric($id)){
            if ($this->request->isAjax()){
                $shopcart=Shopcart::findFirst($id);
                if ($shopcart->getVoucher()!=null){
                    echo "Hediye çeki kullanıdığınız için artırma veya azaltma işlemı yapamazsınız";
                }else if ($shopcart->getVoucher()==null){
                    $shopcart->setPiece($adet);
                    if ($shopcart->save()){
                        echo "ok";
                    }else{
                        echo "Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!";
                    }
                }

            }
        }
    }


    public function voucherAction($code=false) {
        $this->view->disable();
        $auth = @$_COOKIE['auth'];
        $user=$this->getAuthId($auth);
        $voucher=Vouchers::findFirst("code="."'$code'"." and status=1");
        if ($voucher){
            $meta_value=json_decode($voucher->getMetaValue(),true);
            $sepet=Shopcart::find("user_id=".$user);
            $sepetPiece=Shopcart::find("user_id=".$user);
            $start=strtotime(date("d-m-Y", $meta_value['start_date']));
            $end=strtotime(date("d-m-Y", $meta_value['end_date']));
            $time=strtotime(date("d-m-Y",time()));
            $usecount=Voucheruse::findFirst("voucher_id=".$voucher->getId());
            if ($start<=$time && $end>=$time){
                if ($voucher){
                    if ($user!=0){
                        $use=Voucheruse::findFirst("voucher_id=".$voucher->getId()." and user_id=".$user);
                        $limit_of_per_person=$meta_value['limit_of_per_person'];
                        $voucher_value=$meta_value['voucher_value'];
                        //hediye çekı daha önce kullanılmış mı kontrolu
                        if ($use){
                            $maximum_usage=VoucherUse::find("voucher_id=".$voucher->getId());
                            $count= $maximum_usage->count();
                            $limit=$limit_of_per_person-$use->getUseOf();
                            //hediye çekının kullanım sayısı bitmişni kontrolu
                            if ($count<=$meta_value['maximum_usage']){
                                $piece=0;
                                $total=0;

                                if ($meta_value['limit_of_per_person']>$use->getUseOf()){
                                    if ($meta_value['voucher_type']=="1"){
                                        $i=0;
                                        foreach ($sepet as $sepet2){
                                            if ($voucher_value==0){
                                                $piece+=$sepet2->getPiece();
                                                $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                $i=0.1;
                                            }
                                        }
                                        if ($i==0.1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                    }
                                    else if($meta_value['voucher_type']==2){
                                        $i=0;
                                        foreach ($voucher_value as $item){
                                            foreach ($sepet as $sepet2){
                                                if ($item==$sepet2->getProId()){
                                                    $i+=$sepet2->getPiece();
                                                    $piece+=$sepet2->getPiece();
                                                    $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                }if ($item==0){
                                                    $piece+=$sepet2->getPiece();
                                                    $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                    $i=0.1;
                                                }
                                            }
                                        }
                                        if ($i>=1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                echo  "ok";
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo  "ok";
                                            }
                                        }
                                        if ($i==0.1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                        if ($i==0){
                                            echo "Kod  sepetenizdekı urunlerde geçerli değildir";
                                        }
                                    }
                                    else if($meta_value['voucher_type']==3){
                                        $i=0;
                                        foreach ($voucher_value as $item){
                                            foreach ($sepet as $sepet2){
                                                $product=Product::findFirst($sepet2->getProId());
                                                $catsPro = explode(',', $product->getCatsId());
                                                foreach ($catsPro as $cats){
                                                    $cats= explode(",",self::getBreadCrumbs($cats));
                                                    foreach ($cats as $cats){
                                                        if ($item==$cats ){
                                                            $piece+=$sepet2->getPiece();
                                                            $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                            $i+=$sepet2->getPiece();
                                                        }
                                                        if ($item==0){
                                                            $piece+=$sepet2->getPiece();
                                                            $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                            $i=0.1;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                        if ($i>=1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }

                                        if ($i==0.1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                        if ($i==0){
                                            echo "Kod  sepetenizdekı urunlerde geçerli değildir";
                                        }

                                    }
                                    else if($meta_value['voucher_type']==4){
                                        $voucher_value=$meta_value['voucher_value'];
                                        $i=0;
                                        foreach ($voucher_value as $item){
                                            foreach ($sepet as $sepet2){
                                                $product=Product::findFirst($sepet2->getProId());
                                                if ($item==$product->getBrandId()){
                                                    $i+=$sepet2->getPiece();
                                                    $piece+=$sepet2->getPiece();
                                                    $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                }
                                                if ($item==0){
                                                    $i=0.1;
                                                    $piece+=$sepet2->getPiece();
                                                    $total+=$this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                }
                                            }
                                        }
                                        if ($i>=1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                        if ($i==0.1){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$limit);
                                                $use->save();
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                        if ($i==0){
                                            echo "Kod  sepetenizdekı urunlerde geçerli değildir";
                                        }

                                    }
                                    else if($meta_value['voucher_type']==5){
                                        foreach ($sepetPiece as $sepetPiece){
                                            $piece+=$sepetPiece->getPiece();
                                        }
                                        $voucher_value=$meta_value['voucher_value'];
                                        $i=false;
                                        foreach ($voucher_value as $item){
                                            if ($item==$user){
                                                $i=true;

                                            }
                                            if ($item==0){
                                                $i=true;
                                            }
                                        }
                                        if ($i==true){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$piece);
                                                $use->save();
                                                $this->sepettotalpriceUser($user,$voucher->getMetaValue());
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                        else{
                                            echo "geçersiz kod";
                                        }
                                    }
                                    else if($meta_value['voucher_type']==6){
                                        foreach ($sepetPiece as $sepetPiece){
                                            $piece+=$sepetPiece->getPiece();
                                        }
                                        $voucher_value=$meta_value['voucher_value'];
                                        $i=false;
                                        $users=User::findFirst($user);
                                        foreach ($voucher_value as $item){
                                            if ($item==$users->getGroupId()){
                                                $i=true;
                                            }
                                            if ($item==0){
                                                $i=true;
                                            }
                                        }
                                        if ($i==true){
                                            if ($piece<=$limit_of_per_person-$use->getUseOf()){
                                                $use->setUseOf($use->getUseOf()+$piece);
                                                $use->save();
                                                $this->sepettotalpriceUser($user,$voucher->getMetaValue());
                                                echo  "ok";
                                            }
                                            else{
                                                $this->sepetVouvherDelete();
                                                echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                            }
                                        }
                                        else{
                                            echo "geçersiz kod";
                                        }
                                    }
                                }
                                else{
                                    echo "Sepetinizde maksimum ".$limit." tane  ürün bulunmalıdır";
                                }
                            }
                            else{
                                echo "kod kullanımı bitmişdir";
                            }
                        }
                        if (!$use) {
                            $limit = $limit_of_per_person;
                            $newUse = new Voucheruse();
                            $newUse->setUserId($user);
                            $newUse->setVoucherId($voucher->getId());
                            $newUse->setCreatedAt($this->getnow());
                            $newUse->setUpdatedAt($this->getnow());
                            if ($usecount){
                                $count=$usecount->count();
                            }else{

                                $count=0;
                            }
                            if ($count < $meta_value['maximum_usage']) {
                                $piece = 0;
                                $total = 0;
                                if ($meta_value['voucher_type'] == "1") {
                                    $i = 0;
                                    foreach ($sepet as $sepet2) {
                                        if ($voucher_value == 0) {
                                            $piece += $sepet2->getPiece();
                                            $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                            $i = 0.1;
                                        }
                                    }
                                    if ($i == 0.1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }

                                } else if ($meta_value['voucher_type'] == "2") {
                                    $voucher_value = $meta_value['voucher_value'];
                                    $i = 0;
                                    foreach ($voucher_value as $item) {
                                        foreach ($sepet as $sepet2) {
                                            if ($item == $sepet2->getProId()) {
                                                $i += $sepet2->getPiece();
                                                $piece += $sepet2->getPiece();
                                                $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                            }
                                            if ($item == 0) {
                                                $i = 0.1;
                                                $piece += $sepet2->getPiece();
                                                $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                            }
                                        }
                                    }
                                    if ($i >= 1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }
                                    if ($i == 0.1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }
                                    if ($i == 0) {
                                        echo "Kod  sepetenizdekı urunlerde geçerli değildir";
                                    }
                                } else if ($meta_value['voucher_type'] == 3) {
                                    $voucher_value = $meta_value['voucher_value'];
                                    $i = 0;
                                    foreach ($voucher_value as $item) {
                                        foreach ($sepet as $sepet2) {
                                            $product = Product::findFirst($sepet2->getProId());
                                            $catsPro = explode(',', $product->getCatsId());
                                            foreach ($catsPro as $cats) {
                                                $cats = explode(",", self::getBreadCrumbs($cats));
                                                foreach ($cats as $cats) {
                                                    if ($item == $cats) {
                                                        $i += $sepet2->getPiece();
                                                        $piece += $sepet2->getPiece();
                                                        $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                    }
                                                    if ($item == 0) {
                                                        $i = 0.1;
                                                        $piece += $sepet2->getPiece();
                                                        $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($i >= 1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }
                                    if ($i == 0.1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }
                                    if ($i == 0) {
                                        echo "Kod  sepetenizdekı urunlerde geçerli değildir";
                                    }
                                } else if ($meta_value['voucher_type'] == 4) {
                                    $voucher_value = $meta_value['voucher_value'];
                                    $i = 0;
                                    foreach ($voucher_value as $item) {
                                        foreach ($sepet as $sepet2) {
                                            $product = Product::findFirst($sepet2->getProId());
                                            if ($item == $product->getBrandId()) {
                                                $i += $sepet2->getPiece();
                                                $piece += $sepet2->getPiece();
                                                $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());
                                            }
                                            if ($item == 0) {
                                                $i = 0.1;
                                                $piece += $sepet2->getPiece();
                                                $total += $this->sepettotalprice($sepet2->getId(),$voucher->getMetaValue());

                                            }
                                        }
                                    }
                                    if ($i >= 1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }

                                    if ($i == 0.1) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }
                                    if ($i == 0) {
                                        echo "Kod  sepetenizdekı urunlerde geçerli değildir";
                                    }

                                } else if ($meta_value['voucher_type'] == 5) {
                                    foreach ($sepetPiece as $sepetPiece) {
                                        $piece += $sepetPiece->getPiece();
                                    }
                                    $voucher_value = $meta_value['voucher_value'];
                                    $i = false;
                                    foreach ($voucher_value as $item) {
                                        if ($item == $user) {
                                            $i = true;
                                        }
                                        if ($item == 0) {
                                            $i = true;
                                        }

                                    }
                                    if ($i == true) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $newUse->setUseOf($piece);
                                            $this->sepettotalpriceUser($user,$voucher->getMetaValue());
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }


                                    } else {
                                        echo "geçersiz kod";
                                    }
                                } else if ($meta_value['voucher_type'] == "6") {
                                    foreach ($sepetPiece as $sepetPiece) {
                                        $piece += $sepetPiece->getPiece();
                                    }
                                    $voucher_value = $meta_value['voucher_value'];
                                    $i = false;
                                    $users = User::findFirst($user);
                                    foreach ($voucher_value as $item) {
                                        if ($item == $users->getGroupId()) {
                                            $i = true;
                                        }
                                        if ($item == 0) {
                                            $i = true;
                                        }
                                    }
                                    if ($i == true) {
                                        if ($piece <= $limit_of_per_person) {
                                            echo "ok";
                                            $this->sepettotalpriceUser($user,$voucher->getMetaValue());
                                            $newUse->setUseOf($piece);
                                            $newUse->save();
                                        } else {
                                            $this->sepetVouvherDelete();
                                            echo "Sepetinizde maksimum " . $limit . " tane  ürün bulunmalıdır";
                                        }
                                    }
                                    else {
                                        echo "Yazmış olduğunuz kupon kodu geçersizdir!";
                                    }
                                }
                                else {
                                    echo "Yazmış olduğunuz kupon kodu kullanılmıştır!";
                                }
                            }
                            else {
                                echo "Yazmış olduğunuz kupon kodunun kullanılmıştır!";
                            }
                        }

                    }
                    if ($user==0){
                        echo "Lütfen önce üye girişi yapınız!";
                    }

                }
                else{
                    echo "Yazmış olduğunuz kupon kodu hatalıdır!";
                }
            }else{
                echo "Yazmış olduğunuz kupon kodunun tarihi geçmiştir!";
            }
        }else{
            echo "Yazmış olduğunuz kupon kodu hatalıdır!";
        }
    }

    public function bilgiAction()
    {

        /* sözleşmeler */
        $aydinlatma = Content::findFirst(1);
        if ($aydinlatma) {
            $this->view->aydinlatma = $aydinlatma;
        }

        $uyeliksozlesme = Content::findFirst(2);
        if ($uyeliksozlesme) {
            $this->view->uyeliksozlesme = $uyeliksozlesme;
        }

        $gizlilik = Content::findFirst(3);
        if ($gizlilik) {
            $this->view->gizlilik = $gizlilik;
        }


        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $auth = @$_COOKIE['auth'];

                $name = $this->request->getPost('name');
                $phone = $this->request->getPost('phone');
                $email = $this->request->getPost('email');

                //tc kimlik


                if ($name && $phone && $email) {

                    $user = User::findFirst('email="' . $email . '"');
                    if ($user) {
                        echo json_encode(array('status' => 'hasuser'));
                        exit;
                    }
                    $doesPhone = User::findFirst('phone="' . $phone . '"');
                    if ($doesPhone) {
                        echo json_encode(array('status' => 'hasphone'));
                        exit;
                    }

                    $security = new Security();
                    $randompass = new \Phalcon\Security\Random();
                    $sifre = $randompass->hex(6);
                    $password = $security->hash($sifre);
                    $random = new \Phalcon\Security\Random();
                    $code = $random->hex(15);
                    $ip = $this->request->getClientAddress();
                    $browser = $_SERVER['HTTP_USER_AGENT'];
                    $user = new User();
                    $user->setGroupId(2);
                    $user->setName($name);
                    $user->setPhone($phone);
                    $user->setEmail($email);
                    $user->setPassword($password);
                    $user->setBrowser($browser);
                    $user->setIp($ip);
                    $user->setIdNo("");
                    $user->setCode($code);
                    $user->setCreatedAt(self::getnow());
                    $user->setUpdatedAt(self::getnow());
                    if ($user->save()) {
                        setcookie('auth', $email, time()+15*86400);
                        require APP_PATH . '/library/Mail.php';
                        echo json_encode(array('status' => 'ok'));
                        $test = Mail::sifre($email, $sifre);
                        self::sepet($user->getId());
                        self::point($user, 'register');


                    }


                }
            }
        }
    }

    public function countAction() {
        $this->view->disable();
        $auth = @$_COOKIE['auth'];
        $session_id = @$_COOKIE['session_id'];
        if (isset($auth)) {
            $user = $this->getAuthId($auth);
            $count = Shopcart::count("user_id=".$user);
            echo $count;
        } else if (isset($session_id)){

            if (isset($session_id)) {
                $count = Shopcart::count("session_id="."'$session_id'");
                echo $count;
            } else {
                echo 0;
            }
        }
    }

}