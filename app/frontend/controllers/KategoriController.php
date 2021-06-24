<?php


namespace Yabasi\Frontend\Controllers;


use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Filter;
use Yabasi\Product;

class KategoriController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::getLanguage();
        self::getactivetheme();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::language();
        self::getMetas();
        $this->view->page = 'cats';
    }

    public function indexAction() {

        $sef = $this->dispatcher->getParam("sef");

        if ($sef) {
            $cats = Cats::findFirst('sef="'.$sef.'"');
            if ($cats) {
                $cats_count = Cats::count('sef="'.$sef.'"');
                $catsId = $cats->getId();
                $this->view->cat_id = $catsId;

                $total_result = $cats_count;
                $perpage = 12;
                $total_page = ceil($total_result / $perpage);
                $this->view->total_page = $total_page;

                $catsMarka="";
                $arr="";
                $catMarka= explode(",",self::getCats($catsId));

                foreach ($catMarka as $catMarka){
                    $products = Product::find('status=1');
                    if (count($products) != 0) {
                        foreach ($products as $pro) {
                            $catsPro = explode(',',$pro->getCatsId());
                            if (in_array($catMarka, $catsPro)) {
                                if ($pro->getBrandId()){
                                    $marka=Brand::findFirst($pro->getBrandId());
                                    if ($marka){
                                        $arr2= explode(",",$arr);
                                        if (in_array($marka->getId(),$arr2)){

                                        }else{
                                            $catsMarka.='<li><input type="radio" name="brand_id" value="'.$marka->getId().'" id="m_ozl_'.$marka->getId().'" class="m_fozellik"><label for="m_ozl_'.$marka->getId().'">'.$marka->getName().'</label></li>';
                                        }
                                        $arr.=$marka->getId().",";
                                    }
                                }
                            }
                        }
                    }
                }
                $this->view->marka=$catsMarka;
                $this->view->price=$this->kategoriPrice($catsId);
                if ($cats_count != 0) {
                    $this->view->cats = $cats;

                    // alt kategoriler
                    $subcats = Cats::find('top_id='.$cats->getId());
                    if (count($subcats) != 0) {
                        $this->view->sub = $subcats;
                    }

                    // üst kategori
                    $topcat = Cats::findFirst('id='.$cats->getTopId());
                    if ($topcat) {
                        $this->view->topcat = $topcat;
                    }

                    // ilgili ürünleri gönderelim
                    $cat_id = $cats->getId();

                    $pros = Product::find('cats_id='.$cat_id);
                    if ($pros) {
                        $this->view->pros = $pros;
                    }

                    //tüm markaları gönderiyoruz
                    $brand = Brand::find('status=1');
                    if ($brand) {
                        $this->view->brands = $brand;
                    }

                } else {
                    $this->response->redirect('/');
                }
            } else {
                $this->response->redirect('');
            }
        } else {
            $this->response->redirect('');
        }

    }
}