<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Phalcon\Forms\Manager;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Yabasi\Bank;
use Yabasi\Order;
use Yabasi\PaymentNotification;
use Yabasi\User;


class PaymentNotificationController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkLicenceKey();
        self::isAuthorityVolt();
        self::isAuthorityWrite("notification");
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'order';
        $this->view->subpage = 'notification';
    }

    public function indexAction($id = false)
    {
        self::isAuthority("notification", "read");
    }

    public function updateAction()
    {
        self::isAuthority("notification", "edit");
    }

    public function insertAction()
    {
        self::isAuthority("notification", "write");
    }

}