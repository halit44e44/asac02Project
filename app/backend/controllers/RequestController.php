<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Yabasi\Auth;
use Yabasi\Bank;
use Yabasi\Images;
use Yabasi\Modules;
use Yabasi\Request;
use Yabasi\User;
use Yabasi\Usergroup;

class RequestController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkLicenceKey();
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'product';
        $this->view->subpage = 'request';
    }
    public function indexAction($table=false) {
        if($table=="seen"){
            $request=Request::find("seen=1");
            if ($request){
                foreach ($request as $requests){
                    $requests->setSeen("0");
                    $requests->setUpdatedAt(self::getnow());
                    $requests->update();
                }
            }
        }
    }
}