<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Yabasi\Auth;
use Yabasi\IntegrationSettings;
use Yabasi\IntegrationOrder;
//use Phalcon\Dispatcher;



use Phalcon\Text;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
class IntegrationController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::isAuth();
        self::isAuthorityVolt();
        self::getModul();
        self::isAuthorityWrite("integration");
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'integration';
        $this->view->subpage = 'integration';
    }        

    public function indexAction() {
    }

    public function orderAction($id) {
        $UrlData = $this->dispatcher->getParams();

        if(isset($UrlData[1])){
            return $this->dispatcher->forward(
                [
                    'controller' => 'IntegrationOrder',
                    'action'     => $UrlData[0],
                    'params' => ["id" => $UrlData[1]],
                ]
            );
        }else {
            return $this->dispatcher->forward(
                [
                    'controller' => 'IntegrationOrder',
                    'action'     => $UrlData[0],
                ]
            );
        }
    }  

    public function productAction($place, $id = "") {
        $UrlData = $this->dispatcher->getParams();

        if(isset($UrlData[1])){ //url "product/detail/1" gibi ise
            return $this->dispatcher->forward(
                [
                    'controller' => 'IntegrationProduct',
                    'action'     => $UrlData[0],
                    'params' => ["place" => $UrlData[1], "id" => $UrlData[2]],
                ]
            );
        }else { //url "product" gibi ise
            return $this->dispatcher->forward(
                [
                    'controller' => 'IntegrationProduct',
                    'action'     => $UrlData[0],
                ]
            );
        }
    }  




}