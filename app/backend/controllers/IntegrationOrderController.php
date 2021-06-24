<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Phalcon\Http\Response;
use Yabasi\Auth;
use Yabasi\IntegrationSettings;
use Yabasi\IntegrationOrder;
use Yabasi\IntegrationProduct;
use Yabasi\Images;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Settings;

class IntegrationOrderController extends ControllerBase {

    private function orderItemStatusDecrypter($place, $status) {
        if ($place === "n11") {
            $statusList = array(
                1 => "İşlem Bekliyor",
                2 =>"Ödendi",
                3 =>"Geçersiz",
                4 =>"İptal Edilmiş",
                5 =>"Kabul Edilmiş",
                6 =>"Kargoda",
                7 =>"Teslim Edilmiş",
                8 =>"Reddedilmiş",
                9 =>"İade Edildi",
                10 =>"Tamamlandı",
                11 =>"İade İptal Değişim Talep Edildi",
                12 =>"İade İptal Değişim Tamamlandı",
                13 =>"Kargoda İade",
                14 =>"Kargo Yapılması Gecikmiş",
                15 =>"Kabul Edilmiş Ama Zamanında Kargoya Verilmemiş",
                16 =>"Teslim Edilmiş İade",
                17 =>"Tamamlandıktan Sonra İade"
            );

            return $statusList[$status];
        }
    }

    private function OrderStatusDecrypter($place, $status) {
        if ($place === "n11") {
            $statusList = array(
                1 => "İşlem Bekliyor",
                2 =>"İşlemde",
                3 =>"İptal Edilmiş",
                4 =>"Geçersiz",
                5 =>"Tamamlandı"
            );

            return $statusList[$status];
        }
    }

    public function initialize() {
        self::getName();
        self::isAuth();
        self::isAuthorityVolt();
        self::getModul();
        self::isAuthorityWrite("integration");
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'integration';
        $this->view->subpage = 'integration_order';
        $this->view->orderStatus = [];
    }

    public function indexAction() {
        $this->view->pick('integration/order/index');
    }

    
    public function detailAction($id = false) {
        $this->view->pick('integration/order/orderDetail');

        //Company Logo
        $logo = Settings::findFirst('name="logo"');
        if ($logo) { $this->view->logo = 'media/product/'.$logo->getValue(); }

        //Company Address 
        $adres = Settings::findFirst('name="adres"');
        if ($adres) { $this->view->address = $adres->getValue(); }

        $order = IntegrationOrder::findFirst($id);

        if ($order === null) {
            $response = new Response("Üzgünüz, aradığınız sipariş bulunamadı.", 404, 'Bulunamadı');
            $response->send();
            exit();
        }

        $placeName = IntegrationSettings::findFirst($order->getPlace())->getName();
        $orderDetail = json_decode($order->getOrderDetail(), true);
        $productList = [];

        if($placeName === "n11"){  
            $this->view->orderNumber = $orderDetail["orderNumber"];
            $this->view->buyerName = $orderDetail["buyer"]["fullName"];
            $this->view->buyerTc = $orderDetail["buyer"]["tcId"];
            $this->view->shippingAddress = $orderDetail["shippingAddress"]["address"];
            $this->view->billingAddress = $orderDetail["billingAddress"]["address"];
            $this->view->totalPrice = $orderDetail["billingTemplate"]["sellerInvoiceAmount"];
            $this->view->orderDate = $orderDetail["createDate"];
            $this->view->status = $this->OrderStatusDecrypter($placeName, $orderDetail["status"]);
            $this->view->integrationPlace = $placeName;
    

            foreach ($orderDetail["itemList"] as $item) {
                $itemList = [];
                $productId = IntegrationProduct::findFirst(array("place_id" => $item["productId"]))->getSiteId();
                $productImage = Images::findFirst(array(
                    'conditions' => 'content_id = :cst_id: AND meta_key = "product" AND showcase = 1',
                    'bind'       => ['cst_id' => $productId],
                ));
                
                if ($productImage != null) {
                    $productImage = $productImage->getMetaKey();
                }else {
                    $productImage = "resimyok.jpg";
                }

                $itemList["image"] = $productImage;
                $itemList["name"] = $item["productName"];
                $itemList["amount"] = $item["sellerInvoiceAmount"];
                $itemList["status"] = $this->orderItemStatusDecrypter($placeName, $item["status"]);

                array_push($productList, $itemList);

                if (isset($item["shipmentInfo"]["shipmentCompany"]["name"])) {
                    $shipmentCompany = $item["shipmentInfo"]["shipmentCompany"]["name"];
                }

                if (isset($item["shipmentInfo"]["trackingNumber"])) {
                    $shipmentTrackingNumber = $item["shipmentInfo"]["trackingNumber"];
                }
            }


            //var_dump($productList);
            //$this->view->disable();
            $this->view->productList = $productList;
            $this->view->shipmentCompany = $shipmentCompany;
            $this->view->shipmentTrackingNumber = $shipmentTrackingNumber;
        }

    }
}