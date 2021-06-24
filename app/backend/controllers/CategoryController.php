<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Yabasi\Cats;
use Yabasi\Images;
use Yabasi\Menu;
use Yabasi\Product;
use Yabasi\User;

// Kategori sistemi
class CategoryController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        $this->isAuthorityVolt();
        self::checkLicenceKey();
        self::checkmodul('product');
        self::isAuthorityWrite("category");
        $this->view->cevir   = self::getTranslator();
        $this->view->page    = 'product';
        $this->view->subpage = 'category';
        $this->view->site_url = self::site_url();
        $this->view->user_id = self::getAuthId();
        $this->view->catlist = $this->catlist();
    }

    public function indexAction($id = false) {
        self::isAuthority("category","read");
        if (is_numeric($id)) {
            $this->view->top_id = $id;
            $this->view->breadcrumbs = self::getBreadCrumbs($id, "cats");
        }

    }

    public function updateAction($id = false) {
        self::isAuthority("category","edit");
        $this->view->type = 'update';

        if (is_numeric($id)) {
            $category = Cats::findFirst($id);
            if ($category) {
                $this->view->category = $category;
                $this->view->cats     = Cats::find('top_id = 0 and status=1');
                $this->view->keywords = self::parseKeywords($category->getKeyword());
                $this->view->images   = Images::find('meta_key="category" and content_id='.$id);
            }
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $id = $this->request->getPost('id');
                $short_content = $this->request->getPost('short_content');
                $content = $this->request->getPost('content');

                $name = $this->request->getPost('name');
                $top_id = $this->request->getPost('top_id');
                $seo_title = $this->request->getPost('seo_title');
                $slugurl = $this->request->getPost('sef');
                $keyword = $this->request->getPost('keyword');
                $description = $this->request->getPost('description');
                $topcontent  = $this->request->getPost('topcontent');
                $subcontent  = $this->request->getPost('subcontent');


                if (is_numeric($id)) {
                    $update = Cats::findFirst($id);
                    if($update) {
                        $update->setName($name);
                        if ($top_id) {
                            $update->setTopId($top_id);
                        }
                        $update->setSeoTitle($seo_title);
                        $sef= self::generateSef("update","cats",$slugurl,$id);
                        $update->setSef($sef);
                        if ($keyword) {
                            $update->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                        }
                        $update->setDescription($description);
                        $update->setContent($content);
                        $update->setSubInfo($subcontent);
                        $update->setTopInfo($topcontent);
                        $update->setShortContent($short_content);
                        $update->setUpdatedAt(self::getnow());
                        if ($update->update()) {
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
    }

    public function insertAction() {
        self::isAuthority("category","write");
        $this->view->type = 'insert';
        $this->view->cats = Cats::find('top_id = 0 and status=1');
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $top_id = $this->request->getPost('top_id');
                $slugurl = $this->request->getPost('slugurl');
                $keyword = $this->request->getPost('keyword');
                $description = $this->request->getPost('description');
                $content = $this->request->getPost('content');
                $short_content = $this->request->getPost('short_content');
                $seo_title = $this->request->getPost('seo_title');
                $topcontent  = $this->request->getPost('topcontent');
                $subcontent  = $this->request->getPost('subcontent');

                $cat = new Cats();
                $cat->setName($name);
                $cat->setTopId($top_id);
                $cat->setSeoTitle($seo_title);
                $sef= self::generateSef("insert","cats",$slugurl);
                $cat->setSef($sef);
                if ($keyword) {
                    $cat->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                }
                $cat->setDescription($description);
                $cat->setContent($content);
                $cat->setSubInfo($subcontent);
                $cat->setTopInfo($topcontent);
                $cat->setShortContent($short_content);
                $cat->setUpdatedAt($this->getnow());
                $cat->setCreatedAt($this->getnow());
                if ($cat->save()){
                    echo json_encode(array('status' => 'ok', 'id' => $cat->getId()));
                }

            }
        }
    }

    public function catlist() {
        $categories = [];
        $cat = Cats::find('status=1');
        foreach ($cat as $tcats) {
            if($tcats->getTopId() == 0){
                $childs = array_filter($this->hasChilds($tcats->getId()));

                if(!empty($childs)){
                    $categories[] = array("id" => $tcats->getId(), "title" => $tcats->getName(), "subs" => $childs);
                }else{
                    $categories[] = array("id" => $tcats->getId(), "title" => $tcats->getName());
                }
            }
        }

        return json_encode($categories, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    private function hasChilds($id) {
        $array = array();
        if($id != 0){
            $subCats = Cats::find('top_id='.$id);

            if ($subCats) {
                foreach ($subCats as $key) {
                    $alt_varmi = $this->hasChilds($key->getId());

                    if(!empty($alt_varmi)){
                        $array[] = array("id" => $key->getId(), "title" => $key->getName(), "subs" => $alt_varmi);
                    }else{
                        $array[] = array("id" => $key->getId(), "title" => $key->getName());
                    }
                }
            }
        }

        return $array;
    }
    public function kontrolAction($id)
    {
        $kontrol="false";
        $this->view->disable();
        $collection = Product::find(array(
            'cats_id like ("%'.$id.'%")'
        ));
        $menu=Menu::find("cats_id=".$id);
        $cats=Cats::find('top_id='.$id);
        foreach ($collection as $post){
            $implode=explode(',',$post->getCatsId());
            foreach ($implode as $value){
                if ($value==$id){
                    $kontrol= "true";
                }
            }
        }
        if ($kontrol=="false"){
            if ($cats->count()>0){
                $kontrol= "true";

            }
            if ($menu->count()>0){
                $kontrol= "true";

            }
        }
        echo $kontrol;
    }
    public function catsAction(){
        $this->view->disable();
        $return="<select id='category'>";
        $cats=Cats::find();
        foreach ($cats as $cat){
            $name=$cat->getName();
            $id=$cat->getId();
            $return.="<option value='$id'>$name</option>";
        }
        $return.="</select>";
        echo $return;
    }
}