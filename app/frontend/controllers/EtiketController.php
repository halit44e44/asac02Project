<?php


namespace Yabasi\Frontend\Controllers;


use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Product;
use Yabasi\Tags;

class EtiketController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'tags';
    }

    public function indexAction() {

        $catsMarka="";
        $cats = Cats::find('top_id=0 and status=1');
        if (count($cats) > 0) {
            $this->view->cats = $cats;
        }

        $brands = Brand::find('status=1');
        if (count($brands) > 0) {
            $this->view->brands = $brands;
        }

        $sef = $this->dispatcher->getParam("sef");
        $sef = self::clean($sef);
        $tags = Tags::findFirst('name="'.$sef.'" and status=1');

        if ($tags) {
            $this->view->tags = $tags;
        } else {
            $this->response->redirect('');
        }

        $products = Product::find('status=1');
        if (count($products) != 0) {
            foreach ($products as $pro) {
                if ($pro->getBrandId()) {
                    $marka = Brand::findFirst($pro->getBrandId());
                    if ($marka) {
                        $catsMarka .= '<li><input type="radio" name="brand_id" value="' . $marka->getId() . '" id="m_ozl_' . $marka->getId() . '" class="m_fozellik"><label for="m_ozl_' . $marka->getId() . '">' . $marka->getName() . '</label></li>';
                    }
                }
            }
            $this->view->marka = $catsMarka;
        }
        $price=$this->kategoriPrice("0","tumurunler");
        $this->view->price = $price;

    }
}