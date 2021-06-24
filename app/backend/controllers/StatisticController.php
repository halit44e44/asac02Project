<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

//istatistikler
use Yabasi\Order;
use Yabasi\Product;
use Yabasi\Statistic;
use Yabasi\Statisticpro;
use Yabasi\User;

class StatisticController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkmodul('statistic');
        self::checkLicenceKey();
        $this->view->cevir      = self::getTranslator();
        $this->view->user_id    = self::getAuthId();
        $this->view->site_url   = self::site_url();
        $this->view->page       = 'statistic';
    }
    public function indexAction() {

    }


    public function orderAction() {
        $this->view->subpage='order';
    }

    public function productAction($id=false) {
        if (is_numeric($id)){
            $this->view->id = $id;
        }
        $this->view->subpage='product';
        $this->view->navpage = 'product';
    }

    public function productsAction($page = false) {
        if ($page) {
            $this->view->subpage='product';
            if ($page == 'user') {
                $statisticpro = Statisticpro::find();
                if ($statisticpro){
                    $this->view->statisticpro = $statisticpro;
                }
                $this->view->navpage = 'user';
                $this->view->pick('statistic/product/user');
            } else if ($page == 'giro') {
                $this->view->navpage = 'giro';
                $this->view->pick('statistic/product/giro');
            } else if ($page == 'order') {
                $product = Product::find();
                if ($product){
                    $this->view->pro = $product;
                }
                $this->view->navpage = 'order';
                $this->view->pick('statistic/product/order');
            }
        }
    }

    public function visitorAction() {
        $this->view->subpage='visitor';
    }

    public function userAction() {
        $this->view->subpage='user';
    }
    public function cityAction($id) {
        $this->view->disable();
        $order=Order::find("meta_key='order' and city="."'$id'" );
        $total = Order::sum(
            [   'conditions'=>"meta_key='order' and city="."'$id'",
                'column' => 'total_price',
            ]);
        if (!$total){
            $total=0;
        }
        echo "Toplam sipraiş ".$order->count()."\n"."Toplam tutar ".$total;


    }
}