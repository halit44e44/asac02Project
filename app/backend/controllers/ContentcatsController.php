<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Yabasi\Contentcats;
use Yabasi\Images;
use Yabasi\User;


// Kategori sistemi
class ContentcatsController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::isAuthorityWrite("contentcats");
        self::checkmodul('content');
        self::checkLicenceKey();
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'content';
        $this->view->subpage = 'contentcats';
        $this->view->catlist = $this->catlist();
    }

    public function indexAction($id = false) {
        self::isAuthority("contentcats","read");
        if (is_numeric($id)) {
            $subcat = self::db("contentcats")::count('top_id='.$id);
            if ($subcat > 0) {
                $this->view->top_id = $id;
                $this->view->breadcrumbs = self::getBreadCrumbs($id, "contentcats");
            }
        }
    }

    public function updateAction($id = false) {
        self::isAuthority("contentcats","edit");
        $this->view->type = 'update';

        if(is_numeric($id)){
            $this->view->contentcats = Contentcats::findFirst($id);
            $this->view->contentcat  = Contentcats::find('status=1 and top_id=0');
            $this->view->images   = Images::find('meta_key="contentcats" and content_id='.$id);
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {


                $this->view->disable();

                $name       = $this->request->getPost('name');
                $content    = $this->request->getPost('content');
                $top_id     = $this->request->getPost('top_id');
                $title      = $this->request->getPost('seo_title');
                $slugurl    = $this->request->getPost('sef');
                $desc       = $this->request->getPost('description');
                $id         = $this->request->getPost('id');
                $keyword    = $this->request->getPost('keyword');
                $seo_title  = $this->request->getPost('seo_title');

                $userId     = self::getAuthId($this->cookies->get('user'));
                $sef= self::generateSef("update","contentcats",$slugurl,$id);
                $insert = Contentcats::findFirst($id);
                if ($insert) {
                    $insert->setName($name);
                    $insert->setDescription($desc);
                    $insert->setContent($content);
                    $insert->setUserId($userId);
                    if ($keyword) {
                        $insert->setKeyword(self::parseKeywords($keyword));
                    }
                    $insert->setSeoTitle($seo_title);
                    $insert->setSef($sef);
                    if (!$top_id) {
                        $insert->setTopId(0);
                    } else {
                        $insert->setTopId($top_id);
                    }
                    $insert->setSeoTitle($title);
                    $insert->setUpdatedAt(self::getnow());
                    if ($insert->update()) {
                        $this->log($this->cookies->get('user'),$insert->getId(),"contentcats","update");
                        echo json_encode(array('status' => 'ok', 'id' => $insert->getId()));
                    } else {
                        foreach ($insert->getMessages() as $message) {
                            echo $message;
                        }
                    }
                }
            }
        }


    }

    public function insertAction() {
        self::isAuthority("contentcats","write");
        $this->view->type = 'insert';
        $this->view->contentcats = Contentcats::find('status=1 and top_id=0');
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();

                $name       = $this->request->getPost('name');
                $content    = $this->request->getPost('content');
                $top_id     = $this->request->getPost('top_id');
                $title      = $this->request->getPost('seo_title');
                $slugurl    = $this->request->getPost('sef');
                $desc       = $this->request->getPost('description');
                $sef        = self::generateSef("insert","contentcats",$slugurl);
                $userId     = self::getAuthId($this->cookies->get('user'));
                $keyword    = $this->request->getPost('keyword');

                $insert = new Contentcats();
                $insert->setUserId(self::getAuthId($userId));
                $insert->setTopId($top_id);
                $insert->setSef($sef);
                $insert->setSeoTitle($title);
                if ($keyword) {
                    $insert->setKeyword($this->parseKeywords($keyword));
                }
                $insert->setDescription($desc);
                $insert->setName($name);
                $insert->setContent($content);
                $insert->setCreatedAt(self::getnow());
                $insert->setUpdatedAt(self::getnow());
                $insert->setStatus("1");

                if ($insert->save()) {
                    $this->log($this->cookies->get('user'),$insert->getId(),"contentcats","add");
                    echo json_encode(array('status' => 'ok', 'id' => $insert->getId()));
                }
            }
        }
    }

    public function catlist() {
        $arr = [];
        $items = Contentcats::find('status=1');
        foreach ($items as $item) {
            if($item->getTopId() == 0){
                $childs = array_filter($this->hasChilds($item->getId()));

                if(!empty($childs)){
                    $arr[] = array("id" => $item->getId(), "title" => $item->getName(), "subs" => $childs);
                }else{
                    $arr[] = array("id" => $item->getId(), "title" => $item->getName());
                }
            }
        }

        return json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    private function hasChilds($id) {
        $array = array();
        if($id != 0){
            $items = Contentcats::find('top_id='.$id.' and status=1');

            if ($items) {
                foreach ($items as $item) {
                    $alt_varmi = $this->hasChilds($item->getId());

                    if(!empty($alt_varmi)){
                        $array[] = array("id" => $item->getId(), "title" => $item->getName(), "subs" => $alt_varmi);
                    }else{
                        $array[] = array("id" => $item->getId(), "title" => $item->getName());
                    }
                }
            }
        }

        return $array;
    }

}