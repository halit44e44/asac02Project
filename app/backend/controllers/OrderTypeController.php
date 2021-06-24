<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;


use Yabasi\Ordertype;

class OrdertypeController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuthorityVolt();
        self::isAuthorityWrite("Ordertype");
        self::isAuth();
        self::checkLicenceKey();
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'Ordertype';
    }

    public function indexAction() {
        self::isAuthority("Ordertype", "read");
        $this->view->Ordertype = Ordertype::find();
    }
}