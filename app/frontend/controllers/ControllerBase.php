<?php
declare(strict_types=1);

namespace Yabasi\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Security;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;
use Yabasi\Cargocity;
use Yabasi\Cats;
use Yabasi\Content;
use Yabasi\Contentcats;
use Yabasi\Images;
use Yabasi\Menu;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Settings;
use Yabasi\Shopcart;
use Yabasi\Themecontent;
use Yabasi\User;
use Yabasi\Themes;

class ControllerBase extends Controller {

    public  function totaldiscount($id = false)
    {
        if (is_numeric($id)) {
            $pro = Product::findFirst($id);
            if ($pro) {
                if ($pro->getDiscountRate() != 0){
                    $discount = '';
                    if ($pro->getDiscountType() == 1) {
                        $discount = $pro->getDiscountRate() . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                        return '<span>' . $discount . '</span>';
                    } elseif($pro->getDiscountType() == 2) {
                        $discount = '%' . $pro->getDiscountRate();
                        return '<span>' . $discount . '</span>';
                    }
                }
                else{
                    return "";
                }

            }
        }
    }
    public static function oldpricesepet($id = false,$variantId)
    {
        if (is_numeric($id)) {

            $pro = Product::findFirst($id);
            if ($variantId==null){
                if ($pro) {
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $oldprice = $format->format($pro->getSalePrice());
                    return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                }
            }else{

                $variant = Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variantId'");
                $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                $oldprice = $format->format($variant->getSalePrice());
                return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
            }

        }
    }
    public static function oldprice($id = false)
    {
        if (is_numeric($id)) {
            $pro = Product::findFirst($id);
            if ($pro) {
                $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                $oldprice = $format->format($pro->getSalePrice());
                return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
            }
        }
    }
    public  function totalprice($id,$variantId=false,$currency=false) {
        if (is_numeric($id)) {
            if ($currency == false) {
                $pro = Product::findFirst($id);
                if (!$variantId) {
                    $sale_price = $pro->getSalePrice();
                    $discount_type = $pro->getDiscountType();
                    $discount_rate = $pro->getDiscountRate();
                    $total_price = $pro->getSalePrice();

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);
                        $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                        $total_price = $format->format($total_price);
                        $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                        $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                        $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                        $total_price = $format->format($total_price);
                        $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                        $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());

                    }
                    return preg_replace('/[^0-9,"."]/', '', $total_price) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                } else {
                    $variant = Productvariant::findFirst("pro_id=" . $id . " and variant_id=" . "'$variantId'");
                    $sale_price = $variant->getSalePrice();
                    $discount_type = $pro->getDiscountType();
                    $discount_rate = $pro->getDiscountRate();

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);
                        $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                        $total_price = $format->format($total_price);
                        $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                        $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                        $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                        $total_price = $format->format($total_price);
                        $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                        $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                    }
                    return preg_replace('/[^0-9,"."]/', '', $total_price) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                }

            } else {
                $pro = Product::findFirst($id);
                if (!$variantId) {
                    $sale_price = $pro->getSalePrice();
                    $discount_type = $pro->getDiscountType();
                    $discount_rate = $pro->getDiscountRate();
                    $total_price = $pro->getSalePrice();

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);


                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;


                    }
                    return $total_price;
                } else {
                    $variant = Productvariant::findFirst("pro_id=" . $id . " and variant_id=" . "'$variantId'");
                    $sale_price = $variant->getSalePrice();
                    $discount_type = $pro->getDiscountType();
                    $discount_rate = $pro->getDiscountRate();

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;


                    }
                    return $total_price;
                }
            }
        }
    }

    public function decimalAdd($a,$b,$numDecimals=2) {
        $intSum         = (float)str_replace(".","",$a) - (float)str_replace(".","",$b);
        $paddedIntSum   = str_pad(abs($intSum),$numDecimals,0,STR_PAD_LEFT);
        $result         = ($intSum<0?"-":"").($intSum<100&&$intSum>-100?"0":"").substr_replace($paddedIntSum,".",-$numDecimals,0);
        return $result;
    }
    protected function getTranslator(): \Phalcon\Translate\Adapter\AdapterInterface
    {

        $language = $this->request->getBestLanguage();
        $lang = [];

        $lang = $this->request->get("lang");
        if ($lang) {
            $language = $lang;
        } else {
            $language = 'tr-TR';
        }

        $translationFile = APP_PATH . '/lang/' . $language . '.php';

        if (true !== file_exists($translationFile)) {
            $translationFile =  APP_PATH . "/lang/tr-TR.php";
        }

        $language = @$_COOKIE['lang'];
        if (isset($language)) {

            if ($language == 'turkish') {
                $translationFile =  APP_PATH . "/lang/tr-TR.php";
            } else if ($language == 'english') {
                $translationFile =  APP_PATH . "/lang/en-EN.php";
            } else if ($language == 'arabic') {
                $translationFile =  APP_PATH . "/lang/ar-AR.php";
            } else if ($language == 'spanish') {
                $translationFile =  APP_PATH . "/lang/es-ES.php";
            }
        }

        require $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);

        return $factory->newInstance( 'array', ['content' => $lang] );
    }


    protected function language() {
        $language = @$_COOKIE['lang'];
        if (!isset($language)) {
            setcookie('lang', 'turkish', time()+15*86400);
            $language = 'turkish';
        }
        $this->view->language = $language;
    }

    protected function getlanguage() {
        $this->view->cevir = $this->getTranslator();
    }

    protected function settings($name = false) {
        if ($name) {
            $setting = Settings::findFirst('name='.$name);
            if ($setting) {
                return $setting->getValue();
            }
        }
    }

    protected function getAuth() {
        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {
            $user = User::findFirst('email="'.$auth.'" and status=1');
            if ($user) {
                $this->view->auth = $user->getEmail();
                $this->view->user_info = $user->getName();
                $this->view->user = $user->getId();
            }else{
                unset($_COOKIE['auth']);
                setcookie('auth', '', time()-7000000, '/');
            }
        }
    }

    protected function isAuth() {
        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {
            $user = User::findFirst('email="'.$auth.'" and status=1');
            if (!$user) {
                return 'error';
            }
        } else {
            return 'error';
        }
    }

    protected function getnow() {
        return time() + 1200;
    }

    protected function getManset() {
        $mansetler = Contentcats::findFirst('sef="manset" and status=1');
        if ($mansetler) {
            $manset = Content::find(array('conditions' => 'content_cat_id='.$mansetler->getId().' and status=1', 'order' => 'id desc'));
            if (count($manset) != 0) {
                $this->view->mansetler = $manset;
            }
        }
    }

    protected function yeniFirsatlar() {
        $firsatlar = Product::find('new_chance=2 and status=1');
        if (count($firsatlar) != 0) {
            $this->view->yenifirsatlar = $firsatlar;
        }
    }

    protected function gununFirsatlari() {
        $firsatlar = Product::find('daily_chance=2 and status=1');
        if (count($firsatlar) != 0) {
            $this->view->gununfirsatlari = $firsatlar;
        }
    }

    protected function modul1() {

        $query = $this->modelsManager->createQuery('select * from \Yabasi\Cats where unmissable_chance=2 and status=1 order by id asc LIMIT 0,1');
        $modul1 = $query->execute();
        if (count($modul1) != 0) {
            $this->view->modul1 = $modul1;

            foreach ($modul1 as $item) {
                $firsatlar = Cats::find('top_id='.$item->getId().' and status=1');
                if ($firsatlar) {
                    $this->view->modul1_cats = $firsatlar;
                }
            }
        }
    }

    protected function modul3() {

        $modul3 = Cats::find(array('conditions' => 'banner=2 and status=1', 'limit' => 3));
        if (count($modul3) != 0) {
            $this->view->modul3 = $modul3;
        }
    }

    protected function modul4() {

        $query = $this->modelsManager->createQuery('select * from \Yabasi\Cats where unmissable_chance=2 and status=1 order by id asc LIMIT 1,1');
        $modul4 = Cats::findFirst(array('status=1 and unmissable_chance=2', 'limit' => 1,"order"=>"rand()"));
        if ($modul4){
            $this->view->modul4 = $modul4;
            $cat=explode(",",$this->getCats($modul4->getId()));
            foreach ($cat as $cats){
                $firsatlar = Product::find(array('conditions' => ' status=1'));
                foreach ($firsatlar as $firsatlar){
                    $cat_id = explode(",",$firsatlar->getCatsId());
                    foreach ($cat_id as $cat_id){
                        if ($cats==$cat_id){
                            $arr[]=array("id"=>$firsatlar->getId(),
                                "name"=>$firsatlar->getName(),
                                "sef"=>$firsatlar->getSef(),
                                "cats"=>$modul4->getId(),
                                "cats2"=>$firsatlar->getCatsId(),
                                'discount_rate' => $firsatlar->getDiscountRate()
                            ) ;
                        }
                    }
                }
            }
        }
        $arr=json_encode($arr);
        $this->view->modul4_pro = $arr=json_decode($arr,true);
    }

    protected function modul5() {
        $items = Product::find(array('conditions' => 'status=1', 'order' => 'id desc', 'limit' => 15));
        if (count($items) > 0) {
            $this->view->soneklenen = $items;
        }
    }

    protected function populer() {
        $items = Cats::find(array('conditions' => 'status=1 and banner=2', 'order' => 'id desc', 'limit' => 5));
        if (count($items) > 0) {
            $this->view->populers = $items;
        }
    }

    protected function getMainCats() {
        $cats = Cats::find('top_id=0 and status=1');
        if ($cats) {
            $this->view->maincats = $cats;
        }
    }

    protected function navMenu() {
        $menu = Menu::find(array('conditions' => 'status=1 and which=1', 'order' => 'row_number asc'));
        if (count($menu) > 0) {
            $this->view->navmenu = $menu;
        }

        $menu = Menu::find(array('conditions' => 'status=1 and which=2', 'order' => 'row_number asc'));
        if (count($menu) > 0) {
            $this->view->footermenu = $menu;
        }

        $footercats = Contentcats::find('status=1 and nav=2');
        if (count($footercats) > 0) {
            $this->view->footercats = $footercats;
        }

    }

    public function getImage($id = false, $table = false) {
        $image = '';
        $images = Images::find('status=1 and meta_key="' . $table . '" and content_id=' . $id);
        if ($images) {
            foreach ($images as $images){
                $arr[]=array("url"=>$images->getMetaValue());

            }
            if (!empty($arr)){
                return $arr;
            }

        }
    }

    public function salePrice($price){
        $format       = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
        $total_price = $format->format($price);
        $clean_symbol = preg_replace( '/[^0-9,"."]/', '', $total_price );
        $total_price  = $clean_symbol;
        return $total_price;
    }
    public function getAuthId($email = false) {
        if ($email) {
            $user = User::findFirstByEmail($email);
            if ($user) {
                return $user->getId();
            } else {
                return 0;
            }
        } else {
            if (isset($_COOKIE['auth'])){
                $auth = $_COOKIE['auth'];
                $user = User::findFirstByEmail($auth);
                if ($user) {
                    return $user->getId();
                } else {
                    return 0;
                }
            }

        }
    }

    protected function getUserId() {

        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {
            $user = User::findFirst('email="'.$auth.'"');
            if ($user) {
                return $user->getId();
            }
        } else {
            return 0;
        }

    }


    protected function getSessionId() {

        $auth = @$_COOKIE['auth'];
        $session = @$_COOKIE['session_id'];
        $cerez = @$_COOKIE['cerez'];

        if (!isset($cerez)){
            setcookie('cerez', 'cerez', time() + 15 * 86400);
            $cerez = Themecontent::findFirst('name="cerez"');
            if ($cerez) {
                $this->view->cerez=$cerez;
            }
        }
        if (!isset($auth) && !isset($session)) {
            $random = new \Phalcon\Security\Random();
            $code =  $random->hex(13);
            setcookie('session_id', $code, time() + 15 * 86400);
            //echo json_encode(array('status' => 'ok'));

        }else if ($auth){
            unset($_COOKIE['session_id']);
            setcookie('session_id', '', time()-7000000, '/');
        }
    }

    protected function sepet($id){
        $session = $_COOKIE['session_id'];
        if (isset($session)){
            $shop=Shopcart::find('session_id='."'$session'");
            foreach ($shop as $shops){
                $varint=$shops->getMetaValue();
                $shopcart=Shopcart::findFirst("pro_id=".$shops->getProId()." and user_id=".$id ." and meta_value="."'$varint'");
                if ($shopcart && $shopcart->getVoucher()==null){
                    $shopcart->setPiece($shopcart->getPiece()+$shops->getPiece());
                    $shops->setUserId($id);
                    $shops->setSessionId("0");
                    $shopcart->save();
                    $shops->delete();
                }else{
                    $shops->setUserId($id);
                    $shops->setSessionId("0");
                    $shops->update();
                }
            }
        }

    }
    protected function cargoDate(){
        $day = date('w',  strtotime("+2 day"));
        $tarih=date("d-m-Y",strtotime("+2 day") );
        if ($day == 0) {
            $day = "Pazartesi";
            $tarih=date("d-m-Y",strtotime("+3 day") );
        } else if ($day == 1) {
            $day = "Pazartesi";
        } else if ($day == 2) {
            $day = "Salı";
        } else if ($day == 3) {
            $day = "Çarşamba";
        } else if ($day == 4) {
            $day = "Perşembe";
        } else if ($day == 5) {

            $day = "Cuma";
        } else if ($day == 6) {
            $day = "Cumartesi";
        }
        $tarih = explode(" ",$tarih);
        $tarih = explode("-",$tarih[0]);

        switch ($tarih[1]) {
            case "01":
                $tarih[1] = "Ocak";
                break;

            case "02":
                $tarih[1] = "Şubat";
                break;

            case "03":
                $tarih[1] = "Mart";
                break;

            case "04":
                $tarih[1] = "Nisan";
                break;

            case "05":
                $tarih[1] = "Mayıs";
                break;

            case "06":
                $tarih[1] = "Haziran";
                break;

            case "07":
                $tarih[1] = "Temmuz ";
                break;

            case "08":
                $tarih[1] = "Ağustos";
                break;

            case "09":
                $tarih[1] = "Eylül ";
                break;

            case "10":
                $tarih[1] = "Ekim";
                break;

            case "11":
                $tarih[1] = "Kasım";
                break;

            case "12":
                $tarih[1] = "Aralık";
                break;
        }
        return $tarih[0]." ".$tarih[1]." ".$day;
    }

    protected function sepetcount(){
        $count = 0;
        $auth = @$_COOKIE['auth'];
        $session_id = @$_COOKIE['session_id'];

        if (isset($auth)){

            $user = $this->getAuthId($auth);

            $shopcart = Shopcart::find("user_id=".$user);
            if (count($shopcart) > 0) {
                $count = $shopcart->count();
            }

        } else if (isset($session_id)){

            $shopcart = Shopcart::findFirst("session_id="."'$session_id'");
            if ($shopcart) {
                $count = $shopcart->count();
            } else {
                $count = 0;
            }
        }

        $this->view->count = $count;
    }

    public  function totalpricevouchers($sale_price,$discount_type,$discount_rate) {
        $total_price    = 0;
        if ($discount_type == 1) {
            $total_price = $sale_price-$discount_rate;
        }
        else if ($discount_type == 2) {
            // yüzde
            $total_price = ($sale_price * $discount_rate) / 100;
            $total_price = $sale_price - $total_price;
        }
        return $total_price;

    }
    public function getBreadCrumbs($id) {
        if (is_numeric($id)){
            $cats =Cats::find('id='.$id);
            if (count($cats)) {
                $return = '';
                foreach ($cats as $cat) {
                    $return .= $this->getBreadCrumbs($cat->getTopId());
                    $return .=$id.",";
                }
                return $return;
            }
        }
    }
    public function getCats($id)
    {
        if (is_numeric($id)){
            $catsdd =Cats::find();
            $return = "";
            $return .= "$id,";
            $i=0;
            foreach ($catsdd as $cat) {
                if ($id==$cat->getTopId()){
                    $return .= $this->getCats($cat->getId());
                    $i++;
                }
            }
            return $return;

        }
    }
    public  function sepettotalprice($id,$voucher)
    {

        $total = Shopcart::findFirst($id);
        $total->setVoucher($voucher);
        $total->save();

    }
    public  function sepetVouvherDelete()
    {
        $shopcart=Shopcart::find("user_id=".$this->getUserId());
        if ($shopcart){
            foreach ($shopcart as $item){
                $item->setVoucher(null);
                $item->Save();
            }
        }
    }
    public  function sepettotalpriceUser($id,$voucher)
    {
        $total = Shopcart::find("user_id=" . $id);
        foreach ($total as $total) {
            $total->setVoucher($voucher);
            $total->save();
        }
    }
    public function kategoriPrice($catsId,$cats=false){
        if ($cats==false){
            $check = Product::find("status=1");
            foreach ($check as $item) {
                $catMarka= explode(",",self::getCats($catsId));
                foreach ($catMarka as $catMarka){
                    $catsPro = explode(',',$item->getCatsId());
                    foreach ($catsPro as $value) {
                        if ($catMarka==$value) {
                            $maxmin[]=$item->getSalePrice();
                        }
                    }
                }
            }
            $max = max($maxmin);
            $min = min($maxmin);
        }else{
            $max = Product::maximum(
                [
                    'column'     => 'CAST(sale_price AS UNSIGNED)',
                    'conditions' => "status=1 and (daily_chance=2 or new_chance=2 or unmissable_chance=2)",
                ]
            );
            $min = Product::minimum(
                [
                    'column'     => 'CAST(sale_price AS UNSIGNED)',
                    'conditions' => "status=1 and (daily_chance=2 or new_chance=2 or unmissable_chance=2)",
                ]
            );
            //  return $min;

        }
        $price="";
        if ($min>0&&$max<100){
            if ($min>0&&$min<25){
                $price.=' <li><input type="radio" name="filterByPrice" value="0-25" id="price1"><label for="price1">0 TL - 25 TL</label></li>';
            } if ($min>25&&$min<50){
                $price.=' <li><input type="radio" name="filterByPrice" value="25-50" id="price2"><label for="price2">25 TL - 50 TL</label></li>';
            }
            if ($min<100){
                $price.=' <li><input type="radio" name="filterByPrice" value="50-100" id="price3"><label for="price3">50 TL - 100 TL</label></li>';
            }
        }if ($max>100&&$max<500) {
            if ($min>0&&$min<25){
                $price.=' <li><input type="radio" name="filterByPrice" value="0-25" id="price1"><label for="price1">0 TL - 25 TL</label></li>';
            }
            if ($min>25&&$min<50){
                $price.=' <li><input type="radio" name="filterByPrice" value="25-50" id="price2"><label for="price2">25 TL - 50 TL</label></li>';
            }
            if ($min>50&&$min<100){
                $price.=' <li><input type="radio" name="filterByPrice" value="50-100" id="price3"><label for="price3">50 TL - 100 TL</label></li>';
            }
            if ($min>100&&$min < 250) {
                $price .= '   <li><input type="radio" name="filterByPrice" value="100-250" id="price4"><label for="price4">100 TL - 250 TL</label></li>';
            }
            if ($min>250&&$min < 500) {
                $price .= '<li><input type="radio" name="filterByPrice" value="250-500" id="price5"><label for="price5">250 TL - 500 TL</label></li>';
            }
        }
        if ($max>500&&$max<1500){
            if ($max>0&&$min<25){
                $price.=' <li><input type="radio" name="filterByPrice" value="0-25" id="price1"><label for="price1">0 TL - 25 TL</label></li>';
            } if ($max>25&&$min<50){
                $price.=' <li><input type="radio" name="filterByPrice" value="25-50" id="price2"><label for="price2">25 TL - 50 TL</label></li>';
            }
            if ($max>50&&$min<100){
                $price.=' <li><input type="radio" name="filterByPrice" value="50-100" id="price3"><label for="price3">50 TL - 100 TL</label></li>';
            }
            if ($max>100&&$min<250){
                $price.='   <li><input type="radio" name="filterByPrice" value="100-250" id="price4"><label for="price4">100 TL - 250 TL</label></li>';
            }
            if ($max>250&&$min<500){
                $price.='<li><input type="radio" name="filterByPrice" value="250-500" id="price5"><label for="price5">250 TL - 500 TL</label></li>';
            }
            if ($max>500&&$min<750){
                $price.='<li><input type="radio" name="filterByPrice" value="500-750" id="price6"><label for="price6">500 TL - 750 TL</label></li>';
            }
            if ($max>1000&&$min<1500){
                $price.='<li><input type="radio" name="filterByPrice" value="1000-1500" id="price7"><label for="price7">1000 TL - 1500 TL</label></li>';
            }
        }
        if ($max>1500&&$max<3000){
            if ($max>0&&$min<25){
                $price.=' <li><input type="radio" name="filterByPrice" value="0-25" id="price1"><label for="price1">0 TL - 25 TL</label></li>';
            } if ($max>25&&$min<50){
                $price.=' <li><input type="radio" name="filterByPrice" value="25-50" id="price2"><label for="price2">25 TL - 50 TL</label></li>';
            }
            if ($max>50&&$min<100){
                $price.=' <li><input type="radio" name="filterByPrice" value="50-100" id="price3"><label for="price3">50 TL - 100 TL</label></li>';
            }  if ($max>100&&$min<250){
                $price.='   <li><input type="radio" name="filterByPrice" value="100-250" id="price4"><label for="price4">100 TL - 250 TL</label></li>';
            }if ($max>250&&$min<500){
                $price.='<li><input type="radio" name="filterByPrice" value="250-500" id="price5"><label for="price5">250 TL - 500 TL</label></li>';
            }
            if ($max>500&&$min<1000){
                $price.='<li><input type="radio" name="filterByPrice" value="500-1000" id="price6"><label for="price6">500 TL - 1000 TL</label></li>';
            }
            if ($min<1500&&$max>1000){
                $price.='<li><input type="radio" name="filterByPrice" value="1000-1500" id="price7"><label for="price7">1000 TL - 1500 TL</label></li>';
            }
            if ($min<3000){
                $price.='<li><input type="radio" name="filterByPrice" value="1500-3000" id="price8"><label for="price8">1500 TL - 3000 TL</label></li>';
            }
        }
        if ($max>3000&&$max<10000){
            if ($max>0&&$min<100){
                $price.=' <li><input type="radio" name="filterByPrice" value="0-100" id="price1"><label for="price1">0 TL - 100 TL</label></li>';
            }  if ($max>100&&$min<250){
                $price.='   <li><input type="radio" name="filterByPrice" value="100-250" id="price2"><label for="price2">100 TL - 250 TL</label></li>';
            }if ($max>250&&$min<500){
                $price.='<li><input type="radio" name="filterByPrice" value="250-500" id="price3"><label for="price3">250 TL - 500 TL</label></li>';
            }
            if ($max>500&&$min<1000){
                $price.='<li><input type="radio" name="filterByPrice" value="500-1000" id="price4"><label for="price4">500 TL - 1000 TL</label></li>';
            }
            if ($max>1000&&$min<1500){
                $price.='<li><input type="radio" name="filterByPrice" value="1000-1500" id="price5"><label for="price5">1000 TL - 1500 TL</label></li>';
            }
            if ($max>1500&&$min<3000){
                $price.='<li><input type="radio" name="filterByPrice" value="1500-3000" id="price6"><label for="price6">1500 TL - 3000 TL</label></li>';
            }
            if ($max>3000&&$min<5000){
                $price.='<li><input type="radio" name="filterByPrice" value="3000-5000" id="price7"><label for="price7">3000 TL - 5000 TL</label></li>';
            }
            if ($max>5000&&$min<100000){
                $price.='<li><input type="radio" name="filterByPrice" value="5000-10000" id="price8"><label for="price8">5000 TL - 10000 TL</label></li>';
            }

        }
        if ($max>10000){
            if ($max>0&&$min<100){
                $price.=' <li><input type="radio" name="filterByPrice" value="0-100" id="price1"><label for="price1">50 TL - 100 TL</label></li>';
            }  if ($max>100&&$min<250){
                $price.='   <li><input type="radio" name="filterByPrice" value="100-250" id="price2"><label for="price2">100 TL - 250 TL</label></li>';
            }if ($max>250&&$min<500){
                $price.='<li><input type="radio" name="filterByPrice" value="250-500" id="price3"><label for="price3">250 TL - 500 TL</label></li>';
            }
            if ($max>500&&$min<1000){
                $price.='<li><input type="radio" name="filterByPrice" value="750-1000" id="price4"><label for="price4">750 TL - 1000 TL</label></li>';
            }
            if ($max>1000&&$min<1500){
                $price.='<li><input type="radio" name="filterByPrice" value="1000-1500" id="price5"><label for="price5">1000 TL - 1500 TL</label></li>';
            }
            if ($max>1500&&$min<3000){
                $price.='<li><input type="radio" name="filterByPrice" value="1500-3000" id="price6"><label for="price6">1500 TL - 3000 TL</label></li>';
            }
            if ($max>3000&&$min<5000){
                $price.='<li><input type="radio" name="filterByPrice" value="3000-5000" id="price7"><label for="price7">3000 TL - 5000 TL</label></li>';
            }
            if ($max>5000&&$min<100000){
                $price.='<li><input type="radio" name="filterByPrice" value="5000-10000" id="price8"><label for="price8">5000 TL - 10000 TL</label></li>';
            }if ($max>5000&&$min<100000){
                $price.='<li><input type="radio" name="filterByPrice" value="10000-10000" id="price9"><label for="price9">10000 TL - Ve Üzeri</label></li>';
            }

        }

        return $price;
    }

    protected function getactivetheme() {
        $themes = Themes::findFirst('status=1');
        if ($themes) {
            $this->view->activetheme = $themes->getId();
        }

        $top = Themecontent::findFirst('name="top_metin" and status=1 and theme_id='.$themes->getId());
        if ($top) {
            $this->view->top_metin = $top->getValue();
        }
    }


    public function point($user_id, $operation) {
        $filepath = realpath (dirname(__FILE__));
        require_once($filepath . "/../../library/Point.php");
        $point = new \Point();

        $point->set($user_id, $operation);
    }

    public function getMetas() {
        $meta_tag = Settings::findFirst('name="meta_tags"');
        if ($meta_tag) {
            $this->view->meta_tag = $meta_tag->getValue();
        }

        $google_analytics = Settings::findFirst('name="meta_google_analytics"');
        if ($google_analytics) {
            $this->view->google_analytics = $google_analytics->getValue();
        }

        $google_order = Settings::findFirst('name="meta_google_order"');
        if ($google_order) {
            $this->view->google_order = $google_order->getValue();
        }

        $cart_tracking_code = Settings::findFirst('name="meta_cart_tracking_code"');
        if ($cart_tracking_code) {
            $this->view->cart_tracking_code = $cart_tracking_code->getValue();
        }

        $home_tracking_code = Settings::findFirst('name="meta_home_tracking_code"');
        if ($home_tracking_code) {
            $this->view->home_tracking_code = $home_tracking_code->getValue();
        }

        $product_tracking_code = Settings::findFirst('name="meta_product_tracking_code"');
        if ($product_tracking_code) {
            $this->view->product_tracking_code = $product_tracking_code->getValue();
        }
    }

    protected function getSeo() {
        $seo_home = Settings::findFirst('name="seo_home"');
        if ($seo_home) {
            $parse_home = json_decode($seo_home->getValue(), true);
            $this->view->title = '<title>'.$parse_home['title'].'</title>';
        }

        $seo_cats = Settings::findFirst('name="seo_cats"');
        if ($seo_cats) {
            $parse_cats = json_decode($seo_cats->getValue(), true);
            $id = 1;
            $this->view->cats_title = '<title>'.$this->seo('cats', $id).' - '.$parse_home['title'].'</title>';
            $this->view->seo_cats = $parse_cats;
        }
    }

    protected function seo($table = false, $id = false) {
        if ($table && is_numeric($id)) {
            if ($table == 'product') {
                $data = Product::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle()) {
                        return $data->getSeoTitle();
                    } else {
                        $data->getName();
                    }
                }
            } else if ($table == 'cats') {
                $data = Cats::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle()) {
                        return $data->getSeoTitle();
                    } else {
                        $data->getName();
                    }
                }
            }
        }
    }

    public function log($user_id,$table_id,$table_name,$process){
        $filepath = realpath (dirname(__FILE__));
        require_once($filepath . "/../../library/Kayit.php");
        $log=new \Kayit();
        $log->log($user_id,$table_id,$table_name,$process);
    }

    public  function sepetStok(){
        $user = @$_COOKIE['auth'];
        $session_id = @$_COOKIE['session_id'];
        if (isset($session_id) && !isset($user)){

            $shop=Shopcart::find("session_id="."'$session_id'");
            if (count($shop) > 0) {
                foreach ($shop as $shop){
                    $shopcart=Shopcart::findFirst($shop->getId());
                    if ($shopcart){
                        if ($shopcart->getMetaValue()!=null){
                            $var=$shopcart->getMetaValue();
                            $variant=Productvariant::findFirst("pro_id=".$shopcart->getProId()." and variant_id="."'$var'");
                            if ($variant->getStock()==0){
                                $shopcart->delete();
                            }
                            else if ($variant->getStock()<$shopcart->getPiece()){
                                $shopcart->setPiece($variant->getStock());
                                $shopcart->save();
                            }
                        }else{
                            $pro=Product::findFirst($shopcart->getProId());
                            if ($pro->getUnit()==0){
                                $shopcart->delete();
                            }
                            else if ($pro->getUnit()<$shopcart->getPiece()){
                                $shopcart->setPiece($pro->getUnit());
                                $shopcart->save();
                            }
                        }
                    }
                }
            }

        } else if ($user){
            $user = @$_COOKIE['auth'];
            $shop=Shopcart::find("user_id=".$this->getAuthId($user));
            foreach ($shop as $shop){
                $shopcart=Shopcart::findFirst($shop->getId());
                if ($shopcart){
                    if ($shopcart->getMetaValue()!=null){
                        $var=$shopcart->getMetaValue();
                        $variant=Productvariant::findFirst("pro_id=".$shopcart->getProId()." and variant_id="."'$var'");
                        if ($variant->getStock()==0){
                            $shopcart->delete();
                        }
                        if ($variant->getStock()<$shopcart->getPiece()){
                            $shopcart->setPiece($variant->getStock());
                            $shopcart->save();
                        }
                    }else{
                        $pro=Product::findFirst($shopcart->getProId());
                        if ($pro->getUnit()==0){
                            $shopcart->delete();
                        }
                        if ($pro->getUnit()<$shopcart->getPiece()){
                            $shopcart->setPiece($pro->getUnit());
                            $shopcart->save();
                        }
                    }
                }
            }
        }
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public function totalproduct() {
        $pro = Product::count();
        $this->view->total_product = $pro;
    }


    public  function cargocity($cityId,$townId ){
        $return="false";
        $cargocity=Cargocity::findFirst("city_id=".$cityId);
        if ($cargocity){
            if ($cargocity->getTownId()==0){
                $return= "true";
            }else{
                $town=explode(",",$cargocity->getTownId());
                foreach ($town as $town){
                    if ($town==$townId){
                        $return= "true";
                    }
                }
            }
        }
        return $return;
    }
    public  function sepettoplam($id, $price = false)
    {
        if (isset($_COOKIE['auth'])) {
            $toplam_fiyat = 0;
            $total = Shopcart::find("user_id=" . $id);
            foreach ($total as $total) {
                if ($total->getVoucher() == null) {
                    $toplam_fiyat += self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                } else if ($total->getVoucher() != null) {
                    $parse = json_decode($total->getVoucher(), true);
                    $sale_price = self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                    $discount_type = $parse['discount_type'];
                    $discount_rate = $parse['discount'];
                    $total_price = 0;
                    if ($discount_type == 1) {
                        $total_price = $sale_price - ($discount_rate * $total->getPiece());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    $toplam_fiyat += $total_price;
                }
            }
            if ($price == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        } else {
            $toplam_fiyat = 0;
            $total = Shopcart::find("session_id=" . "'$id'");
            foreach ($total as $total) {
                if ($total->getVoucher() == null) {
                    $toplam_fiyat += self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                } else if ($total->getVoucher() != null) {
                    $parse = json_decode($total->getVoucher(), true);
                    $sale_price = self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                    $discount_type = $parse['discount_type'];
                    $discount_rate = $parse['discount'];
                    $total_price = 0;
                    if ($discount_type == 1) {
                        $total_price = $sale_price - ($discount_rate * $total->getPiece());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    $toplam_fiyat += $total_price;
                }
            }
            if ($price == false) {

            } else {
                return $toplam_fiyat;
            }
        }
    }
    public static function cargo($id, $priece = false)
    {
        if (isset($_COOKIE['auth'])) {
            $toplam_fiyat = 0;
            $total = Shopcart::find("user_id=" . $id);
            foreach ($total as $total) {
                $pro = Product::findFirst($total->getProId());
                if ($pro->getShippingFee() == null) {
                    $toplam_fiyat += 0;
                } else {
                    $toplam_fiyat += $pro->getShippingFee();
                }

            }
            if ($priece == false) {

            } else {
                return $toplam_fiyat;
            }
        } else {
            $toplam_fiyat = 0;

            $total = Shopcart::find("session_id=" . "'$id'");
            foreach ($total as $total) {
                $pro = Product::findFirst($total->getProId());
                if ($pro->getShippingFee() == null) {
                    $toplam_fiyat += 0;
                } else {
                    $toplam_fiyat += $pro->getShippingFee();
                }
            }
            if ($priece == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        }
    }
    public  static function totalpriceVocuher($id,$variant=false) {
        if (is_numeric($id)) {
            if ($variant!=null){
                $pro = Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variant'");
                $product = Product::findFirst($id);
                if ($pro) {
                    $sale_price     = $pro->getSalePrice();
                    $discount_type  = $product->getDiscountType();
                    $discount_rate  = $product->getDiscountRate();
                    $total_price    = 0;

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate   = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    return $total_price;
                }
            }else{
                $pro = Product::findFirst($id);

                if ($pro) {
                    $sale_price     = $pro->getSalePrice();
                    $discount_type  = $pro->getDiscountType();
                    $discount_rate  = $pro->getDiscountRate();
                    $total_price    = 0;

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate   = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    return $total_price;
                }
            }

        }
    }

    public function getMobileNav($id = 0) {

        $cats = Cats::find('top_id='.$id);
        if (count($cats)) {
            $return = '';
            foreach ($cats as $cat) {
                if ($this->countCat($cat->getId())) {
                    $return .= $this->getBreadCrumbs($cat->getTopId());
                    $return .= '<li class="breadcrumb-item"> <a href="kategori/'.$cat->getSef().'" class="text-muted">'.$cat->getName().'</a> </li>';
                }
            }
            return $return;
        }
    }

    public function countCat($id) {
        if (is_numeric($id)) {
            $count = Cats::count('status=1 and id='.$id);
            return $count;
        }
    }

    function md5login($email=false,$sifre=false) {
        if ($email && $sifre){
            $yeni_sifre = md5('^_^'.$sifre.'*_-');
            $user=User::findFirst("email="."'$email'");
            if ($user){
                if ($yeni_sifre==$user->getPassword()){
                    $security = new Security();
                    $password = $security->hash($sifre);
                    $user->setPassword($password);
                    if ($user->save()){
                        setcookie('auth', $email, time() + 15 * 86400, '/');

                        self::sepet($user->getId());
                        $this->log($user->getId(), $user->getId(), "user", "loginok");
                        return json_encode(array('status' => 'ok'));
                    } else {
                        $this->log($user->getId(), $user->getId(), "user", "loginfail");
                        return json_encode(array('status' => 'fail'));
                    }
                }
            }
        }

    }
}