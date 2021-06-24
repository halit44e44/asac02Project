<?php

declare(strict_types=1);
namespace Yabasi\Backend\Controllers;

use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Product;
use Yabasi\User;
use Yabasi\Usergroup;
use Yabasi\Vouchers;

class VouchersController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkLicenceKey();
        self::isAuthorityVolt();
        self::isAuthorityWrite("vouchers");
        self::checkmodul('vouchers');
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'campaign';
        $this->view->subpage = 'vouchers';
    }

    public function indexAction() {
        self::isAuthority("vouchers","read");
    }

    public function updateAction($id = false) {

        self::isAuthority("vouchers","edit");
        $this->view->type = 'update';

        $this->view->userGroups = Usergroup::find('status=1');
        $this->view->user = User::find('status=1');
        $this->view->brand = Brand::find('status=1');
        $this->view->product = Product::find('status=1');
        $this->view->cats = Cats::find('top_id=0 and status=1');

        if (is_numeric($id)) {
            $vouchers = Vouchers::findFirst($id);
            if ($vouchers) {
                $this->view->vouchers = $vouchers;
                $meta_value=json_decode($vouchers->getMetaValue(),true);
                $this->view->meta_value=$meta_value;
                $this->view->date=date('m/d/Y',$meta_value["start_date"] ) ;
                $this->view->enddate=date('m/d/Y',$meta_value["end_date"] ) ;
            }
        }

        if ($this->request->isAjax()) {
            if ($this->request->isPost()) {

                $this->view->disable();

                $id = $this->request->getPost('id');
                $name = $this->request->getPost('name');
                $voucher_code = $this->request->getPost('voucher_code');
                $maximum_usage = $this->request->getPost('maximum_usage');
                $limit_of_per_person = $this->request->getPost('limit_of_per_person');
                $start_date = $this->request->getPost('start_date');
                $end_date = $this->request->getPost('end_date');
                $discount_type = $this->request->getPost('discount_type');
                $voucher = $this->request->getPost('voucher');
                $brand = $this->request->getPost('brands');
                $user = $this->request->getPost('user');
                $cats = $this->request->getPost('cats');
                $discount = $this->request->getPost('discount');
                $usergroups = $this->request->getPost('usergroups');
                $product = $this->request->getPost('product');

                $arr = array(
                    'discount_type' => $discount_type,
                    'discount' => $discount,
                    "voucher_type" => $voucher,
                    'maximum_usage' => $maximum_usage,
                    'limit_of_per_person' => $limit_of_per_person,
                    'start_date' => strtotime($start_date),
                    'end_date' => strtotime($end_date),
                );

                if ($voucher === "1") {
                    $arr['voucher_value'] = "0";
                } else if ($voucher === "2") {
                    foreach ($product as $subject) {
                        if ($subject==0){
                            $dizi[] ="0";
                            break;
                        }else{
                            $dizi[] = $subject;
                        }
                    }
                    $arr['voucher_value'] = $dizi;
                } else if ($voucher === "3") {
                    if (isset($cats)) {
                        foreach ($cats as $subject) {
                            if ($subject==0){
                                $dizi[] ="0";
                                break;
                            }else{
                                $dizi[] = $subject;
                            }
                        }
                        $arr['voucher_value'] = $dizi;
                    }
                } else if ($voucher === "4") {

                    foreach ($brand as $subject) {
                        if ($subject==0){
                            $dizi[] ="0";
                            break;
                        }else{
                            $dizi[] = $subject;
                        }
                    }
                    $arr['voucher_value'] = $dizi;
                } else if ($voucher === "5") {
                    foreach ($user as $subject) {
                        if ($subject==0){
                            $dizi[] ="0";
                            break;
                        }else{
                            $dizi[] = $subject;
                        }
                    }
                    $arr['voucher_value'] = $dizi;
                } else if ($voucher === "6") {
                    foreach ($usergroups as $subject) {
                        if ($subject==0){
                            $dizi[] ="0";
                            break;
                        }else{
                            $dizi[] = $subject;
                        }

                    }
                    $arr['voucher_value'] = $dizi;
                }
                else {
                    echo "hata oluştu";
                }

                if (is_numeric($id)) {
                    $vouchers = Vouchers::findFirst($id);
                    if ($vouchers) {
                        $vouchers->setName($name);
                        $vouchers->setCode($voucher_code);
                        $vouchers->setUpdatedAt($this->getnow());
                        $vouchers->setMetaValue(json_encode($arr));

                        if ($vouchers->update()) {
                            echo json_encode(array('status' => 'ok'));
                        } else {
                            $this->view->disable();
                            foreach ($vouchers->getMessages() as $message) {
                                echo $message;
                            }
                        }
                    }
                }
            }
        }
    }

    public function insertAction() {
        self::isAuthority("vouchers","write");

        $this->view->userGroups = Usergroup::find('status=1');
        $this->view->user = User::find('status=1');
        $this->view->brand = Brand::find('status=1');
        $this->view->product = Product::find('status=1');
        $this->view->cats = Cats::find('top_id=0 and status=1');
        $this->view->date = $date = date("m/d/Y");
        $this->view->end_date = $date = date("m/d/Y", strtotime('+7 days'));
        $this->view->type = 'update';
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();

                    $name           = $this->request->getPost('name');
                    $voucher_code   = $this->request->getPost('voucher_code');
                    $maximum_usage  = $this->request->getPost('maximum_usage');
                    $limit_of_per_person = $this->request->getPost('limit_of_per_person');
                    $start_date     = $this->request->getPost('start_date');
                    $end_date       = $this->request->getPost('end_date');
                    $discount_type  = $this->request->getPost('discount_type');
                    $voucher        = $this->request->getPost('voucher');
                    $brand          = $this->request->getPost('brand');
                    $user           = $this->request->getPost('user');
                    $cats           = $this->request->getPost('cats');
                    $discount       = $this->request->getPost('discount');
                    $usergroups     = $this->request->getPost('usergroups');
                    $product        = $this->request->getPost('product');

                    $arr = array(
                        'discount_type' => $discount_type,
                        'discount' => $discount,
                        "voucher_type" => $voucher,
                        'maximum_usage' => $maximum_usage,
                        'limit_of_per_person' => $limit_of_per_person,
                        'start_date' => strtotime($start_date),
                        'end_date' => strtotime($end_date),
                    );

                    if ($voucher === "1") {
                        $arr['voucher_value'] = "0";
                    } else if ($voucher === "2") {
                        foreach ($product as $subject) {
                            if ($subject==0){
                                $dizi[] ="0";
                                break;
                            }else{
                                $dizi[] = $subject;
                            }
                        }
                        $arr['voucher_value'] = $dizi;
                    } else if ($voucher === "3") {
                        if (isset($cats)) {
                            foreach ($cats as $subject) {
                                if ($subject==0){
                                    $dizi[] ="0";
                                    break;
                                }else{
                                    $dizi[] = $subject;
                                }
                            }
                            $arr['voucher_value'] = $dizi;
                        }
                    } else if ($voucher === "4") {

                        foreach ($brand as $subject) {
                            if ($subject==0){
                                $dizi[] ="0";
                                break;
                            }else{
                                $dizi[] = $subject;
                            }
                        }
                        $arr['voucher_value'] = $dizi;
                    } else if ($voucher === "5") {
                        foreach ($user as $subject) {
                            if ($subject==0){
                                $dizi[] ="0";
                                break;
                            }else{
                                $dizi[] = $subject;
                            }
                        }
                        $arr['voucher_value'] = $dizi;
                    } else if ($voucher === "6") {
                        foreach ($usergroups as $subject) {
                            if ($subject==0){
                                $dizi[] ="0";
                                break;
                            }else{
                                $dizi[] = $subject;
                            }
                        }
                        $arr['voucher_value'] = $dizi;
                    } else {
                        echo "hata oluştu";
                    }

                    $insert = new Vouchers();
                    $insert->setName($name);
                    $insert->setCode($voucher_code);
                    $insert->setCreatedAt($this->getnow());
                    $insert->setUpdatedAt($this->getnow());
                    $insert->setStatus("1");
                    $insert->setMetaValue(json_encode($arr));

                    if ($insert->save()) {
                        echo json_encode(array('status' => 'ok'));
                    }
                }
            }
        }

    }
}
