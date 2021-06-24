<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

// varantasyon sistemi
use Yabasi\Images;
use Yabasi\User;
use Yabasi\Variant;

class VariantController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkLicenceKey();
        self::isAuthorityWrite("variant");
        self::checkmodul('product');
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'product';
        $this->view->subpage = 'variant';
        $this->view->catlist = $this->catlist();
    }

    public function indexAction($id = false) {
        self::isAuthority("variant","read");
        if (is_numeric($id)) {
            $subcat = self::db("variant")::count('top_id='.$id);
            if ($subcat > 0) {
                $this->view->top_id = $id;
                $this->view->breadcrumbs = self::getBreadCrumbs($id, "variant");
            }
        }
    }

    public function updateAction($id = false) {
        self::isAuthority("variant","edit");
        $this->view->type = 'update';

        if(is_numeric($id)) {
            $variant = Variant::findFirst($id);
            if ($variant) {
                $this->view->variant = $variant;
                $this->view->variants = Variant::find('top_id = 0 and status=1');
                $this->view->images  = Images::find('meta_key="variant" and content_id='.$id);
            }

            $this->view->cats = Variant::find('status=1');

        }
            if ($this->request->isPost()) {
                if($this->request->isAjax()) {
                    $this->view->disable();

                    $content_id = $this->request->getPost('id');
                    $name = $this->request->getPost('name');
                    $top_id = $this->request->getPost('top_id');

                    if(is_numeric($content_id)){
                        $update = Variant::findFirst($content_id);
                        if($update){
                            $update->setName($name);
                            $update->setTopId($top_id);
                            $update->setUpdatedAt(self::getnow());
                            if($update->update()){
                                echo json_encode(array('status' => 'ok', 'id' => $update->getId()));
                            }
                        }
                    }
                    }
                }
            }

    public function insertAction() {
        self::isAuthority("variant","write");
        $this->view->type = 'insert';
        $this->view->variants = Variant::find('status=1 and top_id=0');
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();

                    $name = $this->request->getPost('name');
                    $top_id = $this->request->getPost('top_id');

                    $insert = new Variant();
                    $insert->setName($name);
                    $insert->setTopId($top_id);
                    $insert->setUpdatedAt(self::getnow());
                    $insert->setCreatedAt(self::getnow());
                    if ($insert->save()){
                        echo json_encode(array('status' => 'ok', 'id' => $insert->getId()));
                    }
                }
            }
        }

    }

    public function uploadAction() {}

    public function catlist() {
        $arr = [];
        $items = Variant::find('status=1');
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
            $items = Variant::find('top_id='.$id.' and status=1');

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