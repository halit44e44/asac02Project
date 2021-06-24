<?php
declare(strict_types=1);
namespace Yabasi\Backend\Controllers;

//içerik sistemi
use Yabasi\Feature;
use Yabasi\Images;
use Yabasi\User;

class FeatureController extends ControllerBase {
    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::isAuthorityWrite("feature");
        self::checkmodul('product');
        self::checkLicenceKey();
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page='product';
        $this->view->subpage = 'feature';
        $this->view->catlist = $this->catlist();
    }

    public function indexAction($id = false) {
        self::isAuthority("feature","read");
        if (is_numeric($id)) {
            $subcat = self::db("feature")::count('top_id='.$id);
            if ($subcat > 0) {
                $this->view->top_id = $id;
                $this->view->breadcrumbs = self::getBreadCrumbs($id, "feature");
            }
        }

    }

    public function updateAction($id = false) {
        self::isAuthority("feature","edit");
        $this->view->type = 'update';
        $this->view->features = Feature::find('top_id=0 and status=1');

        if(is_numeric($id)){
            $this->view->feature = Feature::findFirst($id);
            $this->view->images  = Images::find('meta_key="feature" and content_id='.$id);
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $top_id = $this->request->getPost('top_id');
                $id = $this->request->getPost('id');

                $update = Feature::findFirst($id);
                if ($update) {
                    $update->setName($name);
                    $update->setTopId($top_id);
                    $update->setUpdatedAt(self::getnow());
                    if ($update->save()) {
                        echo json_encode(array('status' => 'ok', 'id' => $update->getId()));
                    }
                }
            }
        }
    }

    public function insertAction() {
        self::isAuthority("feature","write");
        $this->view->type = 'insert';
        $this->view->features = Feature::find('top_id=0 and status=1');
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $top_id = $this->request->getPost('top_id');

                $feature = new Feature();
                $feature->setName($name);
                $feature->setTopId($top_id);
                $feature->setUpdatedAt($this->getnow());
                $feature->setCreatedAt($this->getnow());
                if ($feature->save()){
                    echo json_encode(array('status' => 'ok', 'id' => $feature->getId()));
                }
            }
        }
    }

    public function catlist() {
        $arr = [];
        $items = Feature::find('status=1');
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
            $items = Feature::find('top_id='.$id.' and status=1');

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