<?php


namespace Yabasi\Frontend\Controllers;


use Yabasi\Content;
use Yabasi\Contentcats;

class SayfaController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'content';
    }

    public function indexAction() {

        $sef = $this->dispatcher->getParam("sef");
        if ($sef) {
            $this->view->sef = $sef;
        } else {
            $this->response->redirect('');
        }

        /* tüm kategoriler*/
        $cats = Contentcats::find('id!=1 and status=1');
        if (count($cats) > 0) {
            $this->view->cats = $cats;
        }

        if ($sef) {
            $content = Content::findFirst('sef="'.$sef.'"');
            if ($content) {
                $this->view->sayfa = $content;
                $this->view->content_id = $content->getId();
            }
        }
    }

}