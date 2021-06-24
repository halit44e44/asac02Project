<?php


namespace Yabasi\Backend\Controllers;


use Yabasi\Tags;
use Yabasi\User;

class TagsController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuthorityVolt();
        self::isAuthorityWrite("content");
        self::checkmodul('content');
        self::isAuth();
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'content';
        $this->view->subpage = 'tags';
    }

    public function indexAction() {

    }

    public function insertAction() {
        $this->isAuthority("content","write ");
        $this->view->type = 'insert';
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();

                    $name        = $this->request->getPost('name');
                    $topcontent  = $this->request->getPost('topcontent');
                    $subcontent  = $this->request->getPost('subcontent');
                    $seo_title   = $this->request->getPost('seo_title');
                    $slugurl     = $this->request->getPost('sef');
                    $description = $this->request->getPost('description');
                    $keyword     = $this->request->getPost('keyword');

                    if ($name) {
                        $tags = new Tags();
                        $tags->setName($name);
                        $tags->setSeoTitle($seo_title);
                        $sef= self::generateSef("insert","tags",$slugurl);
                        $tags->setSef($sef);
                        if ($keyword) {
                            $tags->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                        }
                        $tags->setDescription($description);
                        $tags->setTopInfo($topcontent);
                        $tags->setSubInfo($subcontent);
                        $tags->setCreatedAt(self::getnow());
                        $tags->setUpdatedAt(self::getnow());
                        $tags->setStatus(1);
                        if ($tags->save()) {
                            $this->log($this->cookies->get('user'),$tags->getId(),"tags","add");
                            echo json_encode(array('status' => 'ok', 'id' => $tags->getId()));
                        }
                    }

                }
            }
        }

    }

    public function updateAction($id = false) {
        self::isAuthority("content","edit");
        $this->view->type = 'update';

        if (is_numeric($id)) {
            $tags = Tags::findFirst($id);
            if ($tags) {
                $this->view->tags = $tags;
                $this->view->id = $id;
            } else {
                $this->response->redirect('backend/tags/');
            }
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $topcontent = $this->request->getPost('topcontent');
                $subcontent = $this->request->getPost('subcontent');
                $seo_title   = $this->request->getPost('seo_title');
                $slugurl     = $this->request->getPost('sef');
                $description = $this->request->getPost('description');
                $keyword     = $this->request->getPost('keyword');

                if (is_numeric($id)) {
                    $tags = Tags::findFirst($id);
                    if ($tags) {
                        $tags->setName($name);
                        $tags->setSeoTitle($seo_title);
                        $sef= self::generateSef("update","tags",$slugurl,$id);
                        $tags->setSef($sef);
                        if ($keyword) {
                            $tags->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                        }
                        $tags->setDescription($description);
                        $tags->setTopInfo($topcontent);
                        $tags->setSubInfo($subcontent);
                        $tags->setCreatedAt(self::getnow());
                        $tags->setUpdatedAt(self::getnow());
                        $tags->setStatus(1);
                        if ($tags->save()) {
                            $this->log($this->cookies->get('user'),$tags->getId(),"tags","update");
                            echo json_encode(array('status' => 'ok', 'id' => $tags->getId()));
                        } else {
                            foreach ($tags->getMessages() as $message) {
                                echo $message;
                            }
                        }
                    }
                }

            }
        }
    }
}