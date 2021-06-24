<?php


namespace Yabasi\Frontend\Controllers;


use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Product;

class FirsatlarController extends ControllerBase
{

    public function initialize()
    {

        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'campaign';

    }

    public function indexAction()
    {

        $catsMarka="";
        $cats = Cats::find('top_id=0 and status=1');
        if (count($cats) > 0) {
            $this->view->cats = $cats;
        }

        $brands = Brand::find('status=1');
        if (count($brands) > 0) {
            $this->view->brands = $brands;
        }
        $arr=array();
        $products = Product::find('status=1 and daily_chance=2');
        if (count($products) != 0) {
            foreach ($products as $pro) {
                if ($pro->getBrandId()) {
                    $marka = Brand::findFirst($pro->getBrandId());
                    if ($marka) {
                        if (!in_array($marka->getId(),$arr)){
                            $catsMarka .= '<li><input type="radio" name="brand_id" value="' . $marka->getId() . '" id="m_ozl_' . $marka->getId() . '" class="m_fozellik"><label for="m_ozl_' . $marka->getId() . '">' . $marka->getName() . '</label></li>';
                        }
                        $arr[].=$marka->getId();
                    }
                }
            }
            $total_result = $products->count();
            $perpage = 12;
            $total_page = ceil($total_result / $perpage);
            $this->view->total_page = $total_page;
        }

        $this->view->marka = $catsMarka;
        $price=$this->kategoriPrice("0","fırsat");
        $this->view->price = $price;

    }
}