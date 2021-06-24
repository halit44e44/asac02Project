<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;
use Phalcon\Translate\Adapter\NativeArray;
use Yabasi\Auth;
use Yabasi\Comment;
use Yabasi\Images;
use Yabasi\Modul;
use Yabasi\Modules;
use Yabasi\Order;
use Yabasi\Pnotification;
use Yabasi\Points;
use Yabasi\Product;
use Yabasi\Request;
use Yabasi\Settings;
use Yabasi\User;
use Yabasi\Usergroup;
use Phalcon\Security;

class ControllerBase extends Controller {

    public function site_url() {
        $setting = Settings::findFirst('name="site_url" and status=1');
        if ($setting) {
            if ($setting->getValue() != null && $setting->getValue() != '') {
                return $setting->getValue();
            }
        }
    }
    public function getModul(){
        $modul=Modul::find("status=1");
        foreach ($modul as $module){
            $sef="modul".$module->getSef();
            $this->view->$sef="ok";
        }

    }

    protected function db($table = false) {
        if ($table) {
            return "\Yabasi".'\\'.ucfirst($table);
        }
    }

    protected function isAuth() {

        $user=$this->cookies->get('user');
        $code=$this->cookies->get('password');
        $users=User::findFirst("email="."'$user'");
        $security  = new Security();
        $ip= $this->request->getClientAddress();
        $browser= $_SERVER['HTTP_USER_AGENT'] ;
        if ($users ) {
            if ( $security->checkHash( "$code",$users->getCode())){
                if ($ip==$users->getIp()){
                    if ($browser==$users->getBrowser()){
                    }
                    else{
                        $this->response->redirect('backend/login');
                    }
                }
                else{
                    $this->response->redirect('backend/login');
                }
            }else{
                $this->response->redirect('backend/login');
            }

        } else{
            $this->response->redirect('backend/login');
        }
    }
    protected function getName() {

        if ($this->cookies->has('user')) {
            $auth = $this->cookies->get('user');
            if ($auth) {
                $user = User::findFirst('email="'.$auth.'"');
                if ($user) {
                    $this->view->user_info = $user->getName();
                }
            } else {
                $this->response->redirect('');
            }
        }

    }
    protected function isAuthorityVolt(){
        $email = $this->cookies->get('user');

        if (!$email) {
            $this->response->redirect("backend/login");
        }

        $user = User::findFirst('email="'.$email.'"');
        if ($user) {
            $group = Usergroup::findFirst($user->getGroupId());
            if ($group) {
                $auth = Auth::find('group_id="'.$group->getId().'"');
                if ($auth) {

                    foreach ($auth as $auth){
                        $modules=Modules::find($auth->getModuleId());
                        foreach ($modules as $modules){
                            $checkAuth = Auth::findFirst('group_id='.$user->getGroupId().' and module_id='.$modules->getId().' and '.  "read=0");

                            if ($checkAuth){
                                $a=$modules->getSef();
                                $this->view->$a="ok";
                            }
                        }
                    }

                } else {

                    $this->response->redirect("backend/login");

                }
            }
        }

    }
    protected function isAuthorityWrite($module=false){
        $email = $this->cookies->get('user');
        if (!$email) {
            $this->response->redirect("backend/login");
        }

        $user = User::findFirst('email="'.$email.'"');
        if ($user) {
            $group = Usergroup::findFirst($user->getGroupId());
            if ($group) {
                $auth = Auth::findFirst($group->getId());
                if ($auth) {
                    $modules = Modules::findFirst('sef="'.$module.'"');
                    if ($modules) {
                        $checkAuth = Auth::findFirst('group_id='.$user->getGroupId().' and module_id='.$modules->getId().' and write=0');
                        if ($checkAuth){
                            $this->view->write="ok";
                        }
                    }
                } else {

                    $this->response->redirect("backend/login");

                }
            }
        }

    }
    protected function isAuthorityRemove($module=false){
        if ($module=="cats"){
            $module="category";
        }
        $email = $this->cookies->get('user');

        if (!$email) {
            $this->response->redirect("backend/login");
        }

        $user = User::findFirst('email="'.$email.'"');
        if ($user) {
            $group = Usergroup::findFirst($user->getGroupId());
            if ($group) {
                $auth = Auth::findFirst($group->getId());
                if ($auth) {
                    $modules = Modules::findFirst('sef="'.$module.'"');
                    if ($modules) {
                        $checkAuth = Auth::findFirst('group_id='.$user->getGroupId().' and module_id='.$modules->getId().' and remove=0');

                        if ($checkAuth){
                            return "noauth";
                        }

                    }
                } else {

                    $this->response->redirect("backend/login");

                }
            }

        }

    }
    protected function isAuthorityEdit($module=false){
        if ($module=="cats"){
            $module="category";
        }
        $email = $_COOKIE["user"];

        if (!$email) {
            $this->response->redirect("backend/login");
        }

        $user = User::findFirst('email="'.$email.'"');
        if ($user) {
            $group = Usergroup::findFirst($user->getGroupId());
            if ($group) {
                $auth = Auth::findFirst($group->getId());
                if ($auth) {
                    $modules = Modules::findFirst('sef="'.$module.'"');
                    if ($modules) {
                        $checkAuth = Auth::findFirst('group_id='.$user->getGroupId().' and module_id='.$modules->getId().' and edit=0');

                        if ($checkAuth){
                            return "noauth";
                        }

                    }
                } else {

                    $this->response->redirect("backend/login");

                }
            }

        }

    }
    public function isAuthority($module = false, $process = false) {

        if ($module && $process) {
            $email = $this->cookies->get('user');

            if (!$email) {
                $this->response->redirect("backend/login");
            }

            $user = User::findFirst('email="'.$email.'"');
            if ($user) {
                $group = Usergroup::findFirst($user->getGroupId());
                if ($group) {
                    $auth = Auth::findFirst($group->getId());
                    if ($auth) {
                        $modules = Modules::findFirst('sef="'.$module.'"');
                        if ($modules) {

                            $checkAuth = Auth::findFirst('group_id='.$user->getGroupId().' and module_id='.$modules->getId().' and '.$process.'=1');
                            if ($user->getGroupId()=="1"  && $module=="modules") {

                            } else if ($checkAuth){

                            } else if(!$checkAuth) {
                                $this->response->redirect("backend/");
                            }
                        }
                    } else {
                        $this->response->redirect("backend/login");
                    }
                }
            }
        }
    }

    protected function logout() {
        setcookie('user', '', time() - 3600);
        unset($_COOKIE['user']);
        $this->cookies->delete('user');
        $this->response->redirect('backend/login');
    }

    protected function getnow() {
        return time() + 1200;
    }

    protected function getStockUnit($unit_id = false) {
        if (is_numeric($unit_id)) {
            if ($unit_id == 1) {
                return "Adet";
            } else if ($unit_id == 2) {
                return 'Kg';
            }
        }
    }

    protected function getTranslator(): NativeArray {

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
            $translationFile =  APP_PATH . "/lang/en-EN.php";
        }

        require $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);

        return $factory->newInstance( 'array', ['content' => $lang] );
    }

    public function log($user_id,$table_id,$table_name,$process){
        $filepath = realpath (dirname(__FILE__));
        require_once($filepath . "/../../library/Logs.php");
        $log=new \Logs();

        $log->log($user_id,$table_id,$table_name,$process);
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
            $auth=$this->cookies->get('user');
            if ($auth) {
                $user = User::findFirstByEmail($auth);
                if ($user) {
                    return $user->getId();
                } else {
                    return 0;
                }
            }

        }
    }

    public function parseKeywords($keywords = false) {
        if ($keywords) {
            $json = json_decode($keywords);
            $parse = '';
            foreach ($json as $json) {
                $parse .= $json->value.", ";
            }
            return rtrim($parse, ", ");
        }
    }

    public function unixToDate($date = false) {
        if (is_numeric($date)) {
            return date('d-m-Y', (int) $date);
        }
    }

    public function getBreadCrumbs($id = 0, $table_name) {

        $tables = array(
            'contentcats',
            'cats',
            'feature',
            'variant',
            'order'
        );

        if (in_array($table_name, $tables)) {
            if ($table_name && is_numeric($id)){
                $cats = $this->db($table_name)::find('id='.$id);
                if (count($cats)) {
                    $tableName = $table_name;
                    if ($table_name == 'cats') {
                        $tableName = 'category';
                    }
                    $return = '';
                    foreach ($cats as $cat) {
                        if ($this->countCat($cat->getId(), $table_name)) {
                            $return .= $this->getBreadCrumbs($cat->getTopId(),$table_name);
                            $return .= '<li class="breadcrumb-item"> <a href="backend/'.$tableName.'/index/'.$id.'" class="text-muted">'.$cat->getName().'</a> </li>';
                        }
                    }
                    return $return;
                }
            }
        }
    }

    public function countCat($id, $table_name) {
        if (is_numeric($id)) {
            $count = $this->db($table_name)::count('id='.$id);
            return $count;
        }
    }

    protected function getRandomFileName() {
        $length = 20;
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }



    public function generateSef($status = false, $table = false, $slugurl = false,$id = false){
        if ($status=="insert"){
            $sef=self::db($table)::findFirstBySef($slugurl);
            if ($sef){
                $slug=self::db($table)::find();
                $i=1;
                foreach ($slug as $slugs){
                    if(self::db($table)::findFirstBySef($slugurl."-"."$i")){
                        $i++;
                    }
                    else{
                        return $slugurl."-"."$i";
                    }
                }

            }else{
                return $slugurl;
            }
        } else if($status="update"){
            $sef=self::db($table)::findFirstBySef($slugurl);
            $sefID=self::db($table)::findFirst($id);
            if ($sefID->sef==$slugurl){
                return $slugurl;
            }
            else if (!$sef){
                return $slugurl;
            }else {

                $slug=self::db($table)::find();
                $i=1;
                foreach ($slug as $slugs) {

                    if (self::db($table)::findFirstBySef($slugurl . "-" . "$i")) {
                        $i++;
                    } else {
                        return $slugurl . "-" . "$i";

                    }
                }
            }

        }
    }


    /* toplam vizör analiz başlar */
    public function totalEarnings($start = false, $end = false) {

        $orders = Order::find('meta_key="order" and status=1 and order_status=8');
        if ($orders) {
            $total_price = 0;

            $main_currency = 'TL';
            $order_currency = 'TL';
            $getCurrency = Settings::findFirst('name="main_currency"');
            if ($getCurrency) {
                $main_currency = $getCurrency->getValue();
            }
            foreach ($orders as $order) {

                $order_date = $order->getCreatedAt();
                $order_currency = $order->getCurrency();

                if ($start && $end) {
                    if ($order_date >= $start && $order_date <= $end) {
                        if ($order_currency == $main_currency) {
                            $total_price += $order->getTotalPrice();
                        }
                    }
                } else {
                    if ($order_currency == $main_currency) {
                        $total_price += $order->getTotalPrice();
                    }
                }
            }

            setlocale(LC_MONETARY, 'tr_TR');
            $format = number_format($total_price, 2, ',', '.');
            $this->view->totalorder = $format." ".$order_currency;
        }
    }
    public function totalProduct() {
        $products = Product::find('status=1');
        if ($products) {
            $this->view->totalproduct = count($products);
        }
    }
    public function totalUser() {
        $user = User::find('status=1');
        if ($user) {
            $this->view->totaluser = count($user);
        }
    }
    public function totalComment() {
        $comment = Comment::find('status=1');
        if ($comment) {
            $this->view->totalcomment = count($comment);
        }
    }
    /* toplam vizör analiz biter */

    /* bir haftalık raporlar başlar */
    public function weeklySales() {

        $table = Order::find(array(
            'conditions' => 'created_at BETWEEN ?1 AND ?2',
            'bind' => array(
                1 => strtotime(date("m/d/Y", strtotime("last week"))),
                2 => self::getnow()
            )));
        if ($table) {
            $this->view->weekly_sales = count($table);
        }
    }
    public function weeklyComment() {

        $table = Comment::find(array(
            'conditions' => 'created_at BETWEEN ?1 AND ?2',
            'bind' => array(
                1 => strtotime(date("m/d/Y", strtotime("last week"))),
                2 => self::getnow()
            )));
        if ($table) {
            $this->view->weekly_comment = count($table);
        }
    }
    public function weeklyUser() {

        $table = User::find(array(
            'conditions' => 'created_at BETWEEN ?1 AND ?2',
            'bind' => array(
                1 => strtotime(date("m/d/Y", strtotime("last week"))),
                2 => self::getnow()
            )));
        if ($table) {
            $this->view->weekly_user = count($table);
        }
    }
    public function weeklyRequest() {

        $table = Request::find(array(
            'conditions' => 'created_at BETWEEN ?1 AND ?2',
            'bind' => array(
                1 => strtotime(date("m/d/Y", strtotime("last week"))),
                2 => self::getnow()
            )));
        if ($table) {
            $this->view->weekly_request = count($table);
        }
    }
    public function weeklyEarnings() {

        $table = Order::find(array(
            'conditions' => 'created_at BETWEEN ?1 AND ?2',
            'bind' => array(
                1 => strtotime(date("m/d/Y", strtotime("last week"))),
                2 => self::getnow()
            )));
        if ($table) {
            $total_earnings = 0;
            $currency = "TL";
            foreach ($table as $item) {
                $total_earnings += $item->getTotalPrice();
                $currency = $item->getCurrency();
            }

            setlocale(LC_MONETARY, 'tr_TR');
            $format = number_format($total_earnings, 2, ',', '.');
            $this->view->weekly_earnings = $format." ".$currency;
        }
    }
    /* bir haftalık raporlar biter */

    public function getImage($id = false, $table = false) {
        $image = '';
        $images = Images::findFirst('status=1 and meta_key="' . $table . '" and content_id=' . $id . ' and showcase=1');
        if ($images) {
            return $images->getMetaValue();
        } else {
            $images = Images::findFirst('status=1 and meta_key="' . $table . '" and content_id=' . $id . '');
            if ($images) {
                return $images->getMetaValue();
            }
        }
    }

    public function weeklyChart() {

        $name = array('Kazanç', 'Yeni Sipariş', 'Yeni Üye');
        $type = array('bar', 'bar', 'area');
        $stacked = array(true, true, false);
        $data = array([80, 50, 65, 70, 50, 30,48], [20, 20, 25, 30, 30, 20,22], [50, 80, 60, 90, 50, 105,85]);

        for ($i = 0; $i < 3; $i++) {
            $arr[] = array(
                'name' => $name[$i],
                'type' => $type[$i],
                'stacked' => $stacked[$i],
                'data' => $data[$i]
            );
        }

        $json = json_encode($arr);
        $this->view->weekly_chart = $json;

    }

    public function checkmodul($sef = false) {
        if ($sef) {
            $moduls = Modul::findFirst('sef="'.$sef.'" and status=1');
            if (!$moduls) {
                $this->response->redirect('backend/');
            }
        }
    }

    public function priceTextCorrector($price)
    {
        if(isset($price) && !empty($price) && $price != null){
            $price = str_replace(array("_.", "_"), "", $price);
            return str_replace(",", ".", $price);
        }else{
            return "";
        }
    }

    public function generateLicenceKey() {
        $site_url = Settings::findFirst('name="site_url"');
        if ($site_url) {
            $domain = $site_url->getValue();
            $salt = 'EhxbY"6/`B.jCSP@';

            $ency = sha1(md5(base64_encode($domain.$salt)));
            return $ency;
        }
    }

    public function checkLicenceKey() {
        $site_url = Settings::findFirst('name="site_url"');
        $licence_key = Settings::findFirst('name="licence_number"');

        if ($site_url && $licence_key) {
            $domain = $site_url->getValue();
            $salt = 'EhxbY"6/`B.jCSP@';
            $key = $licence_key->getValue();

            $ency = sha1(md5(base64_encode($domain.$salt)));
            if ($ency == $key) {
                $start= Settings::findFirst('name="licence_startdate"');
                $end=Settings::findFirst('name="licence_enddate"');

               if ($start && $end){
                   $startdate=strtotime(date("d-m-Y", (int)$start->getValue()));
                   $enddate=strtotime(date("d-m-Y",(int) $end->getValue()));
                   $time=strtotime(date("d-m-Y",time()));
                   if ($startdate<=$time && $enddate>=$time){

                   }else{
                       $this->response->redirect("backend/error/index/date");
                   }
               }else{
                   $this->response->redirect("backend/error/index/date");
               }

            } else {
                $this->response->redirect("backend/error/index/licence");
            }
        }else{
            $this->response->redirect("backend/error/index/licence");
        }
    }

    protected function lastComments() {
        $comments = Comment::find(array('conditions' => 'status=2', 'limit' => 5));
        if (count($comments)>0) {
            $this->view->comments = $comments;
        }
    }

    protected function totalRefund() {
        $total_refund = Order::count('order_status= 14 or order_status=19');
        if ($total_refund >= 0) {
            $this->view->total_refund = $total_refund;
        }
    }

    protected function totalPNotification() {
        $pnotification = Pnotification::count();
        if ($pnotification >= 0) {
            $this->view->total_pnotification = $pnotification;
        }
    }

    protected function totalPoints() {
        $points = Points::find('status=1');
        $total = 0;
        if (count($points) > 0) {
            foreach ($points as $item) {
                $total += (int)$item->getPoint();
            }
        }

        $point = 0;
        $settings = Settings::findFirst('name="point"');
        if ($settings) {
            $parse = json_decode($settings->getValue());
            if ($parse) {
                $point = (int) $parse->point;
            }
        }

        $earning = ($total / $point);
        if ($earning) {
            $total_earning = number_format((float)$earning, 2, '.', ',');
            $this->view->point_earning = $total_earning."₺";
        }
    }

    protected function licenceEndDate() {
        $setting = Settings::findFirst("name='licence_enddate'");
        if ($setting){
            $tarih1 = strtotime($this->unixToDate(time()));
            $tarih2 = strtotime($this->unixToDate((int)$setting->getValue()));
            $gunfarki = ($tarih2-$tarih1)/86400 ;
            $this->view->licenceTarih = round($gunfarki);
            $this->view->tarih = $this->unixToDate((int)$setting->getValue());
        }
    }

    public  function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


}