<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;


use PHPExcel_IOFactory;

use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Order;
use Yabasi\Product;


class IndexController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuthorityVolt();
        self::isAuth();
        self::checkmodul('vizor');
        self::checkLicenceKey();
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->getModul();
        $this->view->page='index';
        $this->view->subpage='index';
    }

    public function indexAction() {

        self::totalEarnings();
        self::totalProduct();
        self::totalUser();
        self::totalComment();

        self::weeklySales();
        self::weeklyComment();
        self::weeklyUser();
        self::weeklyRequest();
        self::weeklyEarnings();
       // self::weeklyRefund();

        self::weeklyChart();
        self::lastComments();
        self::totalRefund();
        self::totalPNotification();
        self::totalPoints();
        self::licenceEndDate();

        /* order tablosu için veri gonderiyoruz */
        $orders = Order::find(array('limit' => 5, 'conditions' => 'meta_key="order"', 'order' => 'id desc'));
        if ($orders) {
            $this->view->orders = $orders;
        }
    }

    public function testAction() {
        require '../vendor/autoload.php';
        $inputFileName = 'C:\Users\Bulut\Downloads\oyos_eticaret_urun_ekleme_kalibi.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        foreach ($sheetData as $key => $value) {
            if ($value['A']=="ÜRÜN ADI"){

            }
            else{
                $name= $value["A"];
                $cats= $value["B"];
                $brand= $value["C"];
                $shortContent= $value["D"];
                $content= $value["E"];
                $purchasePrice=$value["F"];
                $salePrice=$value["H"];
                $shipingFee=$value["I"];
                $warranty=$value["J"];
                $barcode=$value["K"];
                $stockCode=$value["L"];
                $Unit=$value["M"];
                $unitType=$value['N'];
                if ($unitType=="Adet"){
                    $unitType="1";
                }if ($unitType=="Cm"){
                    $unitType="2";
                }if ($unitType=="Düzine"){
                    $unitType="3";
                }if ($unitType=="Gram"){
                    $unitType="4";
                }if ($unitType=="Kg"){
                    $unitType="5";
                }if ($unitType=="Metre"){
                    $unitType="8";
                }if ($unitType=="m2"){
                    $unitType="9";
                }if ($unitType=="Çift"){
                    $unitType="10";
                }

                $cat=Cats::findFirst("name="."'$cats'");
                $brands=Brand::findFirst("name="."'$brand'");
                if ($cats){
                    $cats=$cat->getId();
                }if ($brands){
                    $brand=$brands->getId();
                }

                    $yabasiProduct=new Product();
                    $yabasiProduct->setTopId(0);
                    $yabasiProduct->setCatsId($cats);
                    $yabasiProduct->setBrandId($brand);
                    $yabasiProduct->setUserId(0);
                    $yabasiProduct->setSupplierId(0);
                    $yabasiProduct->setName($name);
                    $yabasiProduct->setContent($content);
                    $yabasiProduct->setShortContent($shortContent);
                    $yabasiProduct->setSeoTitle($name);
                    $yabasiProduct->setSef($this->slugify($name));
                    $yabasiProduct->setPurchasePrice($list->getFiyat().".00");
                    $yabasiProduct->setPurchaseRate(1);
                    $yabasiProduct->setMarketPrice($list->getFiyat().".00");
                    $yabasiProduct->setMarketRate(1);
                    $yabasiProduct->setSalePrice($list->getFiyat().".00");
                    $yabasiProduct->setSaleRate(1);
                    $yabasiProduct->setVatDefinition(1);
                    $yabasiProduct->setVatRate($list->getKdv());
                    $yabasiProduct->setShippingFee(0);
                    $yabasiProduct->setDiscountType(2);
                    $yabasiProduct->setDiscountRate($list->getIndirim());
                    $yabasiProduct->setTransferDiscount(0);
                    $yabasiProduct->setBarcode(0);
                    $yabasiProduct->setStockCode("URUNKODU-".$list->getId());
                    $yabasiProduct->setStockCode($list->getUrunKodu());
                    $yabasiProduct->setUnitType(1);
                    $yabasiProduct->setCargoWeight(0);
                    $yabasiProduct->setWarranty(0);
                    $yabasiProduct->setNewChance(2);
                    $yabasiProduct->setDailyChance(2);
                    $yabasiProduct->setUnmissableChance(2);
                    $yabasiProduct->setCreatedAt(strtotime($list->getTarih()));
                    $yabasiProduct->setUpdatedAt(time());
                    $yabasiProduct->setStatus(1);
                    if ($yabasiProduct->save()){
                        echo "ok";
                    }else{
                        foreach ($yabasiProduct->getMessages() as $message){
                            echo $message;
                        }
                    }


            }
        }
    }

    public function keyAction() {

        $domain = "http://citirak.com/demo";
        $salt   = 'EhxbY"6/`B.jCSP@';
        echo sha1(md5(base64_encode($domain.$salt)));

        $this->view->disable();

    }


}


