<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Yabasi\Brand;
use Yabasi\Images;
use Yabasi\User;

// marka yönetim sistemi
class  BrandController extends ControllerBase {
    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkLicenceKey();
        $this->isAuthorityVolt();
        self::checkmodul('product');
        self::isAuthorityWrite("brand");
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'product';
        $this->view->subpage = 'brand';
    }
    public function indexAction() {
        self::isAuthority("brand","read");
    }

    public function updateAction($id = false) {
        self::isAuthority("brand","edit");
        $this->view->type = 'update';

        if(is_numeric($id)){
            $brand = Brand::findFirst($id);
            if ($brand) {
                $this->view->brand  = $brand;
                $this->view->images = Images::find('meta_key="brand" and content_id='.$id);
            }
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $content_id  = $this->request->getPost('id');
                $name        = $this->request->getPost('name');
                $content     = $this->request->getPost('content');
                $seo_title   = $this->request->getPost('seo_title');
                $slugurl     = $this->request->getPost('slugurl');
                $keyword     = $this->request->getPost('keyword');
                $description = $this->request->getPost('description');
                $sef         = self::generateSef("update","brand",$slugurl,$content_id);
                $topcontent  = $this->request->getPost('topcontent');
                $subcontent  = $this->request->getPost('subcontent');

                if (is_numeric($content_id)) {
                    $update = Brand::findFirst($content_id);
                    if ($update) {
                        $update->setName($name);
                        $update->setContent($content);
                        $update->setTopInfo($topcontent);
                        $update->setSubInfo($subcontent);
                        $update->setSeoTitle($seo_title);
                        $update->setSef($sef);
                        if ($keyword) {
                            $update->setKeyword(self::parseKeywords($keyword));
                        }
                        $update->setDescription($description);
                        if ($update->update()) {
                            echo json_encode(array('status' => 'ok', 'id' => $update->getId()));
                        }
                    }
                }
            }
        }

    }

    public function insertAction() {
        self::isAuthority("brand","write");
        $this->view->type = 'insert';
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $content = $this->request->getPost('content');
                $seo_title = $this->request->getPost('seo_title');
                $slugurl = $this->request->getPost('slugurl');
                $keyword = $this->request->getPost('keyword');
                $description = $this->request->getPost('description');
                $sef= self::generateSef("insert","brand",$slugurl);
                $topcontent  = $this->request->getPost('topcontent');
                $subcontent  = $this->request->getPost('subcontent');

                $insert = new Brand();
                $insert->setSef($sef);
                $insert->setUserId(self::getAuthId($_COOKIE['auth']));
                $insert->setName($name);
                $insert->setContent($content);
                $insert->setTopInfo($topcontent);
                $insert->setSubInfo($subcontent);
                $insert->setSeoTitle($seo_title);
                $insert->setKeyword($keyword);
                $insert->setSef($sef);
                $insert->setDescription($description);
                $insert->setCreatedAt(self::getnow());
                $insert->setUpdatedAt(self::getnow());
                $insert->setStatus(1);

                if ($insert->save()){
                    echo json_encode(array('status' => 'ok', 'id' => $insert->getId()));
                }
            }
        }
    }

}