<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Yabasi\Auth;
use Yabasi\Bank;
use Yabasi\Images;
use Yabasi\Modules;
use Yabasi\User;
use Yabasi\Usergroup;

class ErrorController extends ControllerBase {

    public function initialize() {

        $this->view->cevir   = self::getTranslator();
        $this->view->cevir = self::getTranslator();
        $this->view->page='error';

    }
    public function indexAction($param = false) {
        if ($param) {
            $text = 'Böyle bir sayfa bulunamadı!';
            if ($param == 'licence') {
                $text = 'Lisans numaranız hatalıdır. Lütfen oyos ile irtibata geçiniz';
            } else if ($param == 'date') {
                $text = 'Kullanım süreniz bitmiştir. Lisans yenilemek için oyos ile irtibata geçiniz.';
            }
        }

        $this->view->text = $text;

    }




}