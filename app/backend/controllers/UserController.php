<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

// kullanıcı yönetimi
use DateTime;
use mysql_xdevapi\Table;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Yabasi\Address;
use Yabasi\City;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Images;
use Yabasi\Neighborhood;
use Yabasi\Notification;
use Yabasi\Order;
use Yabasi\Points;
use Yabasi\Town;
use Yabasi\User;
use Yabasi\Usergroup;

class UserController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkLicenceKey();
        self::isAuthorityWrite("user");
        self::checkmodul('user');
        $this->view->cevir    = self::getTranslator();
        $this->view->user_id  = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page     = 'user';
        $this->view->subpage  = 'user';
    }
    public function indexAction($table=false) {
        self::isAuthority("user","read");
        $this->view->userGroups = self::db("userGroup")::find();
        if($table=="seen"){
            $user=User::find("seen=1");
            if ($user){
                foreach ($user as $users){
                    $users->setSeen("0");
                    $users->setUpdatedAt(self::getnow());
                    $users->update();
                }
            }
        }
    }
    public function updateAction($id = false) {
       self::isAuthority("user","edit");
        $this->view->type = 'update';


        if(is_numeric($id)){
            $this->view->user = User::findFirst($id);
            $this->view->userGroups = Usergroup::find('status=1');
        }
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isAjax()) {
                if ($this->request->isPost()) {

                    $this->view->disable();

                    $tab = $this->request->getPost('tab');

                    if ($tab == 'personal') {

                        $name       = $this->request->getPost('name');
                        $email      = $this->request->getPost('email');
                        $phone      = $this->request->getPost('phone');
                        $id_no      = $this->request->getPost('id_no');
                        $gender     = $this->request->getPost('gender');
                        $birth_date = $this->request->getPost('birth_date');
                        $group_id   = $this->request->getPost('group_id');
                        $id         = $this->request->getPost('id');


                        if (is_numeric($id)) {
                            $edit = User::findFirst($id);
                            if ($edit) {
                                if ($name) {
                                    $edit->setName($name);
                                }
                                if ($email) {
                                    $edit->setEmail($email);
                                }
                                if ($phone) {
                                    $edit->setPhone($phone);
                                }
                                if ($id_no) {
                                    $edit->setIdNo($id_no);
                                }
                                if ($gender) {
                                    $edit->setGender($gender);
                                }
                                if ($birth_date) {
                                    $edit->setBirthDate(strtotime($birth_date));
                                }
                                if ($group_id) {
                                    $edit->setGroupId($group_id);
                                }
                                $edit->update();
                                echo 'ok';
                            } else {
                                echo 'error';
                            }
                        } else {
                            echo 'error';
                        }
                    } else if($tab == 'password') {

                        if ($this->request->isAjax()) {
                            if ($this->request->isPost()) {
                                $password = $this->request->getPost('password');
                                $password1 = $this->request->getPost('password1');
                                $password2 = $this->request->getPost('password2');
                                $user_id   = $this->request->getPost('id');

                                if ($password1 != $password2) {
                                    echo 'notsame';
                                    exit;
                                }

                                if (is_numeric($user_id)) {
                                    $update = User::findFirst($user_id);
                                    if ($update) {
                                        $update->setPassword($this->security->hash($password1));
                                        $update->update();
                                        echo 'ok';
                                    }
                                }

                            }
                        }
                    } else if($tab == 'address') {

                        $user_id = $this->request->getPost('user_id');
                        $address_id = $this->request->getPost('address_id');
                        $name = $this->request->getPost('name');
                        $user_info = $this->request->getPost('user_info');
                        $phone = $this->request->getPost('phone');
                        $country_id = $this->request->getPost('country_id');
                        $city_id = $this->request->getPost('city_id');
                        $town_id = $this->request->getPost('town_id');
                        $district_id = $this->request->getPost('district_id');
                        $neighborhood_id = $this->request->getPost('neighborhood_id');
                        $zip_code = $this->request->getPost('zip_code');
                        $address = $this->request->getPost('address');

                        if (is_numeric($address_id)) {
                            $update = Address::findFirst($address_id);
                            if ($update) {
                                if ($name) {
                                    $update->setName($name);
                                }
                                if ($user_info) {
                                    $update->setUserInfo($user_info);
                                }
                                if ($phone) {
                                    $update->setPhone($phone);
                                }
                                if ($country_id) {
                                    $update->setCountryId($country_id);
                                }
                                if ($city_id) {
                                    $update->setCityId($city_id);
                                }
                                if ($town_id) {
                                    $update->setTownId($town_id);
                                }
                                if ($district_id) {
                                    $update->setDistId($district_id);
                                }
                                if ($neighborhood_id) {
                                    $update->setNeiId($neighborhood_id);
                                }
                                if ($zip_code) {
                                    $update->setZipCode($zip_code);
                                }
                                if ($address) {
                                    $update->setAddress($address);
                                }
                                $update->update();
                                echo 'ok';
                            }
                        }
                    } else if($tab == 'notification') {

                        if ($this->request->isAjax()) {
                            if ($this->request->isPost()) {

                                $email_news = $this->request->getPost('email_news');
                                $email_order = $this->request->getPost('email_order');
                                $sms_news = $this->request->getPost('sms_news');
                                $sms_order = $this->request->getPost('sms_order');
                                $user_id = $this->request->getPost('user_id');

                                if (is_numeric($user_id)) {

                                    $emailNewsVal = 0;
                                    $emailOrderval = 0;
                                    $smsNewsVal = 0;
                                    $smsOrderVal = 0;

                                    if ($email_news == 'on') {
                                        $emailNewsVal = 1;
                                    }

                                    if ($email_order == 'on') {
                                        $emailOrderval = 1;
                                    }

                                    if ($sms_news == 'on') {
                                        $smsNewsVal = 1;
                                    }

                                    if ($sms_order == 'on') {
                                        $smsOrderVal = 1;
                                    }

                                    $update = Notification::findFirst('user_id='.$user_id);
                                    if ($update) {

                                        $update->setEmailNews($emailNewsVal);
                                        $update->setEmailOrder($emailOrderval);
                                        $update->setSmsNews($smsNewsVal);
                                        $update->setSmsOrder($smsOrderVal);
                                        $update->setUpdatedAt(self::getnow());
                                        $update->update();
                                    } else {

                                        $insert = new Notification();
                                        $insert->setUserId($user_id);
                                        $insert->setEmailNews($emailNewsVal);
                                        $insert->setEmailOrder($emailOrderval);
                                        $insert->setSmsNews($smsNewsVal);
                                        $insert->setSmsOrder($smsOrderVal);
                                        $insert->setCreatedAt(self::getnow());
                                        $insert->setUpdatedAt(self::getnow());
                                        $insert->save();
                                    }
                                    echo 'ok';
                                }

                            }
                        }
                    }
                }
            }
        }


    }

    public function insertAction() {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();

                    $email       = $this->request->getPost('email');
                    $password    = $this->request->getPost('password');
                    $name        = $this->request->getPost('name');
                    $phone       = $this->request->getPost('phone');
                    $id_no       = $this->request->getPost('id_no');
                    $birth_date  = $this->request->getPost('birth_date');
                    $gender      = $this->request->getPost('gender');
                    $group_id    = $this->request->getPost('group_id');

                    $random      = new \Phalcon\Security\Random();
                    $code        = $random->hex(13);

                    $check = User::findFirst('email="'.$email.'"');
                    if ($check) {
                        echo json_encode(array('status' => 'thereis'));
                        exit();
                    }

                    $insert = new User();
                    $insert->setName($name);
                    $insert->setEmail($email);
                    $insert->setPassword($this->security->hash($password));
                    $insert->setPhone($phone);
                    $insert->setIdNo($id_no);
                    $insert->setBirthDate(strtotime($birth_date));
                    $insert->setGender($gender);
                    $insert->setGroupId($group_id);
                    $insert->setCode($code);
                    $insert->setCreatedAt(self::getnow());
                    $insert->setUpdatedAt(self::getnow());
                    if ($insert->save()) {
                        $this->log($this->cookies->get('user'),$insert->getId(),"user","add");
                        echo json_encode(array('status' => 'ok'));
                    } else {
                        echo json_encode(array('status' => 'error'));
                        foreach ($insert->getMessages() as $message) {
                            echo $message;
                        }
                    }
                }
            }
        }
        self::isAuthority("user","write");
        $this->view->type = 'insert';
        $this->view->userGroups = Usergroup::find('status=1');




    }

    public function profileAction($param = false, $id = false) {

        $this->view->type = 'update';
        self::isAuthority("user","edit");
        if (is_numeric($id)) {
            $user = User::findFirst($id);
            if ($user) {
                $this->view->user = $user;

                $this->view->birth_date = self::unixToDate($user->getBirthDate());
                $this->view->usergroup = Usergroup::find('status=1');
                $this->view->address = Address::find('user_id='.$id);

                /* toplam paunı */
                $points = Points::find('user_id='.$id);
                if ($points) {
                    $total_point = 0;
                    foreach ($points as $item) {
                        $total_point = $total_point + $item->getPoint();
                    }
                    $this->view->total_point= $total_point;
                }

                $group_name = '';
                $user_groups = Usergroup::findFirst($user->getGroupId());
                if ($user_groups) {
                    $group_name = $user_groups->getName();
                    $this->view->user_group = $group_name;
                }

                $user_city_name = '';
                $user_address = Address::findFirst('user_id='.$user->getId());
                if ($user_address) {
                    $user_city = City::findFirst($user_address->getCityId());
                    if ($user_city) {
                        $this->view->user_city = $user_city->getCityName();
                        $this->view->town = Town::find("CityID=".$user_address->getCityId());
                    }
                }

                $order = Order::find(' meta_key="order" and user_id='.$user->getId());
                if ($order) {
                    $this->view->total_order = count($order);
                    $this->view->orders = $order;
                }

                $image_name = 'media/nouser.jpg';
                $images = Images::findFirst('status=1 and meta_key="user" and content_id=' . $user->getId() . '');
                if ($images) {
                    $image_name = 'media/user/'.$images->getMetaValue();
                }

                $this->view->user_image = $image_name;

                $this->view->country = Country::find();
                $this->view->city = City::find();
                $this->view->district = District::find();

                $this->view->neighborhood = Neighborhood::find();




                $this->view->notify = Notification::findFirst('user_id='.$id);

            } else {
                $this->response->redirect('backend/user/');
            }
        } else {
            $this->response->redirect('backend/user/');
        }


        if ($param == 'personal') {
            $this->view->pick('user/personal');
        } else if ($param == 'password') {
            $this->view->pick('user/password');
        } else if ($param == 'notification') {
            $this->view->pick('user/notification');
        } else if ($param == 'address') {
            $this->view->pick('user/address');
        }

    }

    public function logoutAction() {
        self::logout();
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


}