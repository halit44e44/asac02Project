<?php


namespace Yabasi\Frontend\Controllers;


use Yabasi\Brand;
use Yabasi\Product;

class MarkaController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'brand';
    }

    public function indexAction() {
        $sef = $this->dispatcher->getParam("sef");
        if ($sef) {
            $brand = Brand::findFirst('sef="'.$sef.'"');
            $product=Product::find("brand_id=".$brand->getId());
            if ($product->count()!=0){
                $total_result = $product->count();
                $perpage = 12;
                $total_page = ceil($total_result / $perpage);
                $this->view->total_page = $total_page;
            }

            if ($brand) {
                $this->view->content = $brand;
                $this->view->brand_id = $brand->getId();
                //tüm markaları gönderiyoruz
                $brand = Brand::find('status=1');
                if ($brand) {
                    $this->view->brands = $brand;

                }

            }
        }else{
            $brand = Brand::find('status=1');
            if ($brand) {
                $this->view->brands = $brand;
            }
        }
    }

}