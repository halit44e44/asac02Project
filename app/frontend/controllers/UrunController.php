<?php


namespace Yabasi\Frontend\Controllers;

use Yabasi\Brand;
use Yabasi\Comment;
use Yabasi\Content;
use Yabasi\Contentcats;
use Yabasi\Product;
use Yabasi\Settings;
use Yabasi\Themecontent;
use Yabasi\Virtualpos;

class UrunController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'product';
    }

    public function indexAction() {


    }

    public function detayAction() {
        $sef = $this->dispatcher->getParam("sef");
        $taksit=Virtualpos::find("status=1");

        if ($taksit){
            $this->view->taksit=$taksit;
        }
        if ($sef) {

            $products = Product::findFirst('sef="'.$sef.'"');
            if ($products) {

                $this->view->pro_id = $products->getId();
                $this->view->pro = $products;

                /* markaların detayda gösterimi başlar */
                $markagosterim = Themecontent::findFirst('name="marka_detay_gosterim"');
                if ($markagosterim) {
                    $this->view->markagosterim = $markagosterim;
                }
                /* markaların detayda gösterimi biter */

                /* breadcrumb gösterimi başlar */
                $breadcrumb = Themecontent::findFirst('name="kategori_breadcrumb_kullanim"');
                if ($breadcrumb) {
                    $this->view->breadcrumb = $breadcrumb;
                }
                /* breadcrumb gösterimi biter */

                /* stok kodu gösterimi başlar */
                $stokgosterim = Themecontent::findFirst('name="stok_kod_gosterim"');
                if ($stokgosterim) {
                    $this->view->stokgosterim = $stokgosterim;
                }
                /* stok kodu gösterimi biter */


                $cat = $products->getCatsId();
                $catsPro = explode(',',$cat);
                if ($cat){
                    $this->view->cat = $catsPro;
                }

                if ($products->getFeatureId()) {
                    $feature = explode(',',$products->getFeatureId());
                    if ($feature){
                        $this->view->feature = $feature;
                    }
                }

                $brand=Brand::findFirst($products->getBrandId());
                if ($brand){
                    $this->view->brand=$brand;
                }

                $image = $this->getImage($products->getId(),'product');
                if ($image){

                    $this->view->image = $image ;
                    $this->view->images = $image ;
                }

                $comment = Comment::find(array('conditions' =>"pro_id=".$products->getId()." and status='1'" , 'limit' => 10, 'order' => 'created_at DESC'));
                if ($comment){
                    $this->view->comment=$comment;
                }

                $saleprice=$this->salePrice($products->getSalePrice());
                if ($saleprice){
                    $this->view->saleprice = $saleprice;
                }

                $setting  = Settings::findFirst('name="iade_ve_iptal"');
                if ($setting){
                    $this->view->setting=$setting;
                }

                $contentcat = Contentcats::findFirst('sef="sozlesmeler"');
                if ($contentcat) {
                    $content = Content::findFirst('content_cat_id='.$contentcat->getId().' and sef="iade-ve-iptal-kosullari"');
                    if ($content) {
                        $this->view->iadeveiptal = $content->getContent();
                    }
                }

                $auth = @$_COOKIE['auth'];
                if (isset($auth)){
                    $this->view->user = $this->getAuthId($auth);
                }

                $point1 = Comment::find("pro_id=".$products->getId().' and point=1')->count();
                $point2 = Comment::find("pro_id=".$products->getId().' and point=2')->count();
                $point3 = Comment::find("pro_id=".$products->getId().' and point=3')->count();
                $point4 = Comment::find("pro_id=".$products->getId().' and point=4')->count();
                $point5 = Comment::find("pro_id=".$products->getId().' and point=5')->count();

                $sum = Comment::sum(
                    ["column" => "point",
                        'conditions' => "pro_id=".$products->getId(),
                    ]
                );
                if (isset($sum)){
                    if ($comment->count()>0){
                        $this->view->sum= $sum/$comment->count();
                        $yuzde1=round(100*$point1/$sum);
                        $yuzde2=round(100*$point2*2/$sum);
                        $yuzde3=round(100*$point3*3/$sum);
                        $yuzde4=round(100*$point4*4/$sum);
                        $yuzde5=round(100*$point5*5/$sum);
                        $this->view->yuzde1= $yuzde1;
                        $this->view->yuzde2= $yuzde2;
                        $this->view->yuzde3= $yuzde3;
                        $this->view->yuzde4= $yuzde4;
                        $this->view->yuzde5= $yuzde5;
                    }
                    else{
                        $this->view->sum= 0;
                    }

                }else{
                    $this->view->sum= 0;
                }

                $this->view->cargodate = $this->cargoDate();
                $this->view->point1= $point1;
                $this->view->point2= $point2;
                $this->view->point3= $point3;
                $this->view->point4= $point4;
                $this->view->point5= $point5;
            } else {
                $this->response->redirect('');
            }
        }
    }



}
