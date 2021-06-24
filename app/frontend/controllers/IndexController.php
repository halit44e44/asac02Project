<?php
declare(strict_types=1);

namespace Yabasi\Frontend\Controllers;

use NumberFormatter;
use Phalcon\Mvc\View\Engine\Volt;
use Yabasi\Cats;
use Yabasi\Content;
use Yabasi\ContentCats;
use Yabasi\Filter;
use Yabasi\Menu;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Themecontent;
use Yabasi\Variant;
use Yabasi\Virtualpos;

class IndexController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::getactivetheme();
        self::getMetas();
        $this->sepetStok();
        $this->view->page = 'index';
    }

    public function indexAction() {


        self::getManset(); // manşet
        self::yeniFirsatlar(); // yeni fırsatlar
        self::gununFirsatlari(); // günün fırsatlar
        self::modul1();
        self::modul3();
        self::modul4();
        self::modul5(); // son eklenen ürünler
        self::populer();
        self::getMainCats();
        self::language();
        self::totalproduct();
    }

    public function langAction($lang = false) {
        if ($this->request->isAjax()) {
            if ($this->request->isGet()) {
                $this->view->disable();
                $languages = array('turkish', 'english', 'arabic', 'spanish');
                if (in_array($lang, $languages)) {
                    setcookie('lang', $lang, time()+15*86400);
                    echo 'ok';
                }

            }
        }
    }
}

