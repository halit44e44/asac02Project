<?php
declare(strict_types=1);
namespace Yabasi\Backend\Controllers;

//içerik sistemi
use Yabasi\Cats;
use Yabasi\Content;
use Yabasi\Contentcats;
use Yabasi\Images;
use Yabasi\User;

class ContentController extends ControllerBase {
    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::isAuthorityWrite("content");
        self::checkmodul('content');
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'content';
        $this->view->subpage = 'content';
    }
    public function indexAction() {
        self::isAuthority("content","read");
        $this->view->contentcats = Contentcats::find('status=1 and top_id=0');
    }

    public function updateAction($id = false) {
        self::isAuthority("content","edit");
        $this->view->type = 'update';

        if(is_numeric($id)){
            $this->view->content     = Content::findFirst($id);
            $this->view->contentcats = Contentcats::find('status=1 and top_id=0');
            $this->view->images      = Images::find('meta_key="content" and content_id='.$id);
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $id             = $this->request->getPost('id');
                $name           = $this->request->getPost('name');
                $content_cat_id = $this->request->getPost('content_cat_id');
                $redirect_url   = $this->request->getPost('redirect_url');
                $short_content  = $this->request->getPost('short_content');
                $content        = $this->request->getPost('content');
                $seo_title      = $this->request->getPost('seo_title');
                $slugurl        = $this->request->getPost('sef');
                $keyword        = $this->request->getPost('keyword');
                $description    = $this->request->getPost('description');
                $map            = $this->request->getPost('map');
                $userId         = self::getAuthId($this->cookies->get('user'));

                $sef            = self::generateSef("update","content",$slugurl,$id);

                $update = Content::findFirst($id);
                if ($update) {
                    $update->setName($name);
                    $update->setContentCatId($content_cat_id);
                    $update->setRedirectUrl($redirect_url);
                    $update->setShortContent($short_content);
                    $update->setContent($content);
                    $update->setSeoTitle($seo_title);
                    $update->setSef($sef);
                    $update->setMap($map);
                    if ($keyword) {
                        $update->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                    }
                    $update->setDescription($description);
                    $update->setUserId($userId);
                    $update->setUpdatedAt(self::getnow());

                    if ($update->save()) {
                        $this->log($this->cookies->get('user'),$update->getId(),"contentcats","add");
                        echo json_encode(array('status' => 'ok', 'id' => $update->getId()));
                    } else {
                        foreach ($update->getMessages() as $message) {
                            echo $message;
                        }
                    }
                }

            }
        }

    }

    public function insertAction() {
        $this->isAuthority("content","write ");
        $this->view->type = 'insert';
        $this->view->contentcats = Contentcats::find('status=1 and top_id=0');
        $this->view->cats =Cats::find();
        $this->view->contentcats = Contentcats::find('status=1 and top_id=0');
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name           = $this->request->getPost('name');
                $content_cat_id = $this->request->getPost('content_cat_id');
                $redirect_url   = $this->request->getPost('redirect_url');
                $short_content  = $this->request->getPost('short_content');
                $content        = $this->request->getPost('content');
                $seo_title      = $this->request->getPost('seo_title');
                $slugurl        = $this->request->getPost('sef');
                $description    = $this->request->getPost('description');
                $keyword        = $this->request->getPost('keyword');
                $map            = $this->request->getPost('map');
                $userId         = self::getAuthId($this->cookies->get('user'));

                $sef            = self::generateSef("insert","content",$slugurl);

                $insert = new Content();
                $insert->setUserId($userId);
                $insert->setName($name);
                $insert->setContentCatId($content_cat_id);
                $insert->setRedirectUrl($redirect_url);
                $insert->setShortContent($short_content);
                $insert->setContent($content);
                $insert->setSeoTitle($seo_title);
                $insert->setSef($sef);
                $insert->setMap($map);

                if ($keyword) {
                    $insert->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                }

                $insert->setDescription($description);
                $insert->setCreatedAt(self::getnow());
                $insert->setUpdatedAt(self::getnow());

                if ($insert->save()) {
                    $this->log($this->cookies->get('user'),$insert->getId(),"content","add");
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