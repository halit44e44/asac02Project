<?php


namespace Yabasi\Api\Controllers;


use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Images;
use Yabasi\Order;
use Yabasi\Product;
use Yabasi\Supplier;
use Yabasi\Tags;

class V4Controller extends ControllerBase {

    public function initialize() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    }

    public function indexAction() {
        echo json_encode(array('code' => 200, 'message' => 'Auth is required!'));
    }

    public function productAction() {

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $camp = $this->request->getPost('camp');
                $cat_id = $this->request->getPost('cat_id');
                $limit = $this->request->getPost('limit');
                $firsat = $this->request->getPost('firsat');
                $sef = $this->request->getPost('sef');
                $min = $this->request->getPost('min');
                if($min==0){
                    $min=0.1;
                }
                $max = $this->request->getPost('max');
                $brand = $this->request->getPost('brand_id');
                $order="";

                $conditions = "status=1 ";
                if ($brand){
                    $conditions.=" and brand_id=".$brand;
                }

                if ($min && $max){
                    $conditions.=" and CAST(sale_price AS UNSIGNED) BETWEEN ".$min. ' and '. $max." ";
                }

                if ($firsat=="firsat"){
                    $conditions .= " and (daily_chance=2 or new_chance=2 or unmissable_chance=2)";
                }

                if ($sef) {
                    $tag_ids = '';
                    $tags = Tags::find('name="'.$sef.'" and status=1');
                    if (count($tags) > 0) {
                        foreach ($tags as $item) {
                            if ($item->getProId()) {
                                $tag_ids .= $item->getProId().",";
                            }
                        }

                        $tag_ids = rtrim($tag_ids, ',');
                        $conditions .= 'and id IN ('.$tag_ids.')';
                    }
                }



                if ($camp) {
                    if ($camp == 'coksatanlar') {
                        $order = "rand()";
                    } else if ($camp == 'enyeniler') {
                        $order = "'id desc'";
                    } else if ($camp == 'endusukfiyat') {
                        $order = "CAST(sale_price AS UNSIGNED) asc";
                    } else if ($camp == 'enyuksekfiyat') {
                        $order = "CAST(sale_price AS UNSIGNED) desc";
                    }else if ($camp == 'enyuksekfiyat') {
                        $order = "CAST(sale_price AS UNSIGNED) desc";
                    }
                } else {
                    $order = "id desc";
                }


                $check = Product::find(array('conditions' => $conditions, 'limit' => $limit, 'order' => $order));
                foreach ($check as $item) {
                    $sale_rate = $this->getSaleRate($item->getSaleRate());
                    $total_price = $this->totalprice($item->getId());
                    if ($item->getDiscountRate()==0){
                        $discount_text="null";
                    } else {
                        if ($item->getDiscountType() == 2) {
                            $discount_text = '%'.$item->getDiscountRate();
                        } else if ($item->getDiscountType() == 1){
                            $fiyat=$item->getSalePrice();
                            $yuzde=(100*$item->getDiscountRate())/$fiyat;
                            $yuzde=ceil($yuzde);
                            $discount_text ="%". $yuzde ;
                        } else {
                            $discount_text="null";
                        }
                    }

                    if ($cat_id==0){
                        $arr[] = array(
                            'id' => $item->getId(),
                            'cats_id' => $item->getCatsId(),
                            'brand_id' => (int) $item->getBrandId(),
                            'supplier_id' => (int) $item->getSupplierId(),
                            'user_id' => $item->getUserId(),
                            'variant' => $item->getVariants(),
                            'feature_id' => $item->getFeatureId(),
                            'description' => $item->getDescription(),
                            'name' => $item->getName(),
                            'content' => $item->getContent(),
                            'short_content' => $item->getShortContent(),
                            'seo_title' => $item->getSeoTitle(),
                            'keyword' => $item->getKeyword(),
                            'sef' => $item->getSef(),
                            'image' => $this->image('product', $item->getId()),
                            'sale_price' => $item->getSalePrice(),
                            'rate' => $sale_rate,
                            'total_price' => $total_price,
                            'vat_definition' => $item->getVatDefinition(),
                            'vat_rate' => $item->getVatRate(),
                            'shipping_fee' => $item->getShippingFee(),
                            'discount_type' => $item->getDiscountType(),
                            'discount_rate' => $item->getDiscountRate(),
                            'discount_text' => $discount_text,
                            'transfer_discount' => $item->getTransferDiscount(),
                            'barcode' => $item->getBarcode(),
                            'stock_code' => $item->getStockCode(),
                            'unit' => $item->getUnit(),
                            'unit_type' => $item->getUnitType(),
                            'cargo_weight' => $item->getCargoWeight(),
                            'offer' => $item->getOffer(),
                            'gift' => $item->getGift(),
                            'warranty' => $item->getWarranty(),
                            'new_chance' => (int) $item->getNewChance(),
                            'daily_chance' => (int) $item->getDailyChance(),
                            'unmissable_chance' => (int) $item->getUnmissableChance(),
                            'created_at' => $item->getCreatedAt(),
                            'updated_at' => $item->getUpdatedAt(),
                            'status' => $item->getStatus()
                        );
                    }
                    else{
                        $arr2=[] ;
                        $catMarka= explode(",",self::getCats($cat_id));
                        foreach ($catMarka as $catMarka){
                            $catsPro = explode(',',$item->getCatsId());
                            foreach ($catsPro as $value) {
                                if ($catMarka==$value){
                                    if (!in_array($item->getId(),$arr2)){
                                        $arr[] = array(
                                            'id' => $item->getId(),
                                            'cats_id' => $item->getCatsId(),
                                            'brand_id' => (int) $item->getBrandId(),
                                            'supplier_id' => (int) $item->getSupplierId(),
                                            'user_id' => $item->getUserId(),
                                            'variant' => $item->getVariants(),
                                            'feature_id' => $item->getFeatureId(),
                                            'description' => $item->getDescription(),
                                            'name' => $item->getName(),
                                            'content' => $item->getContent(),
                                            'short_content' => $item->getShortContent(),
                                            'seo_title' => $item->getSeoTitle(),
                                            'keyword' => $item->getKeyword(),
                                            'sef' => $item->getSef(),
                                            'image' => $this->image('product', $item->getId()),
                                            'sale_price' => $item->getSalePrice(),
                                            'rate' => $sale_rate,
                                            'total_price' => $total_price,
                                            'vat_definition' => $item->getVatDefinition(),
                                            'vat_rate' => $item->getVatRate(),
                                            'shipping_fee' => $item->getShippingFee(),
                                            'discount_type' => $item->getDiscountType(),
                                            'discount_rate' => $item->getDiscountRate(),
                                            'discount_text' => $discount_text,
                                            'transfer_discount' => $item->getTransferDiscount(),
                                            'barcode' => $item->getBarcode(),
                                            'stock_code' => $item->getStockCode(),
                                            'unit' => $item->getUnit(),
                                            'unit_type' => $item->getUnitType(),
                                            'cargo_weight' => $item->getCargoWeight(),
                                            'offer' => $item->getOffer(),
                                            'gift' => $item->getGift(),
                                            'warranty' => $item->getWarranty(),
                                            'new_chance' => (int) $item->getNewChance(),
                                            'daily_chance' => (int) $item->getDailyChance(),
                                            'unmissable_chance' => (int) $item->getUnmissableChance(),
                                            'created_at' => $item->getCreatedAt(),
                                            'updated_at' => $item->getUpdatedAt(),
                                            'status' => $item->getStatus()
                                        );
                                    }
                                    $arr2=[$item->getId()] ;
                                }
                            }
                        }
                    }


                }
                if (!empty($arr)) {
                    echo json_encode($arr);
                } else {
                    //echo json_encode(array('code' => 9, 'message' => 'inconclusive!'));
                    exit();
                }


            }}
    }
    public function denemeAction($camp,$cat_id,$limit,$brand,$min,$max){
        $order="";
        $conditions = "CAST(sale_price AS UNSIGNED) BETWEEN ".$min. ' and '. $max." and status=1 and brand_id=".$brand;
        if ($camp) {
            if ($camp == 'coksatanlar') {
                $order = "rand()";
            } else if ($camp == 'enyeniler') {
                $order = "'id desc'";
            } else if ($camp == 'endusukfiyat') {
                $order = "CAST(sale_price AS UNSIGNED) DESC";
            } else if ($camp == 'enyuksekfiyat') {
                $order = "CAST(sale_price AS UNSIGNED) asc";
            }
        } else {
            $order = "id desc";

        }
        $check = Product::find(array('conditions' => $conditions, 'limit' => $limit, 'order' => $order));
        foreach ($check as $item) {
            $sale_rate = $this->getSaleRate($item->getSaleRate());
            $total_price = $this->totalprice($item->getId());
            if ($item->getDiscountType() == 2) {
                $discount_text = '%'.$item->getDiscountRate();
            } else {
                $discount_text = $item->getDiscountRate() .' '. $sale_rate;
            }
            $catMarka= explode(",",self::getCats($cat_id));
            foreach ($catMarka as $catMarka){
                $catsPro = explode(',',$item->getCatsId());
                foreach ($catsPro as $value) {
                    if ($catMarka==$value){
                        $arr[]=array();
                        if (!in_array($item->getId(),$arr)){ $arr[] = array(
                            'id' => $item->getId(),
                            'cats_id' => $item->getCatsId(),
                            'brand_id' => (int) $item->getBrandId(),
                            'supplier_id' => (int) $item->getSupplierId(),
                            'user_id' => $item->getUserId(),
                            'variant' => $item->getVariants(),
                            'feature_id' => $item->getFeatureId(),
                            'description' => $item->getDescription(),
                            'name' => $item->getName(),
                            'content' => $item->getContent(),
                            'short_content' => $item->getShortContent(),
                            'seo_title' => $item->getSeoTitle(),
                            'keyword' => $item->getKeyword(),
                            'sef' => $item->getSef(),
                            'image' => $image = $this->getImage($item->getId(), 'product'),
                            'sale_price' => $item->getSalePrice(),
                            'rate' => $sale_rate,
                            'total_price' => $total_price,
                            'vat_definition' => $item->getVatDefinition(),
                            'vat_rate' => $item->getVatRate(),
                            'shipping_fee' => $item->getShippingFee(),
                            'discount_type' => $item->getDiscountType(),
                            'discount_rate' => $item->getDiscountRate(),
                            'discount_text' => $discount_text,
                            'transfer_discount' => $item->getTransferDiscount(),
                            'barcode' => $item->getBarcode(),
                            'stock_code' => $item->getStockCode(),
                            'unit' => $item->getUnit(),
                            'unit_type' => $item->getUnitType(),
                            'cargo_weight' => $item->getCargoWeight(),
                            'offer' => $item->getOffer(),
                            'gift' => $item->getGift(),
                            'warranty' => $item->getWarranty(),
                            'new_chance' => (int) $item->getNewChance(),
                            'daily_chance' => (int) $item->getDailyChance(),
                            'unmissable_chance' => (int) $item->getUnmissableChance(),
                            'created_at' => $item->getCreatedAt(),
                            'updated_at' => $item->getUpdatedAt(),
                            'status' => $item->getStatus()
                        );}

                   }
                }
            }

        }
        if (!empty($arr)) {
            echo json_encode($arr);
        } else {
            //echo json_encode(array('code' => 9, 'message' => 'inconclusive!'));
            exit();
        }


    }

    public function brandAction() {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $brand_id   = $this->request->getPost('brand_id');
                $limit      = $this->request->getPost('limit');
                $position   = $this->request->getPost('position');

                if (is_numeric($brand_id) && $position) {

                    if ($position) {
                        if ($position == 'coksatanlar') {
                            $order = "rand()";
                        } else if ($position == 'enyeniler') {
                            $order = "'id desc'";
                        } else if ($position == 'endusukfiyat') {
                            $order = "CAST(sale_price AS UNSIGNED) asc";
                        } else if ($position == 'enyuksekfiyat') {
                            $order = "CAST(sale_price AS UNSIGNED) desc";
                        }
                    }

                    $pro = Product::find(array('conditions' => 'brand_id='.$brand_id, 'order' => $order));
                    if (count($pro)) {

                        foreach ($pro as $item) {

                            $sale_rate = $this->getSaleRate($item->getSaleRate());
                            $total_price = $this->totalprice($item->getId());
                            if ($item->getDiscountRate()==0){
                                $discount_text="null";
                            } else {
                                if ($item->getDiscountType() == 2) {
                                    $discount_text = '%'.$item->getDiscountRate();
                                } else if ($item->getDiscountType() == 1){
                                    $fiyat=$item->getSalePrice();
                                    $yuzde=(100*$item->getDiscountRate())/$fiyat;
                                    $yuzde=ceil($yuzde);
                                    $discount_text ="%". $yuzde ;
                                } else {
                                    $discount_text="null";
                                }
                            }


                            $arr[] = array(
                                'id' => $item->getId(),
                                'cats_id' => $item->getCatsId(),
                                'brand_id' => (int) $item->getBrandId(),
                                'supplier_id' => (int) $item->getSupplierId(),
                                'user_id' => $item->getUserId(),
                                'variant' => $item->getVariants(),
                                'feature_id' => $item->getFeatureId(),
                                'description' => $item->getDescription(),
                                'name' => $item->getName(),
                                'content' => $item->getContent(),
                                'short_content' => $item->getShortContent(),
                                'seo_title' => $item->getSeoTitle(),
                                'keyword' => $item->getKeyword(),
                                'sef' => $item->getSef(),
                                'image' =>  $this->image('product', $item->getId()),
                                'sale_price' => $item->getSalePrice(),
                                'rate' => $sale_rate,
                                'total_price' => $total_price,
                                'vat_definition' => $item->getVatDefinition(),
                                'vat_rate' => $item->getVatRate(),
                                'shipping_fee' => $item->getShippingFee(),
                                'discount_type' => $item->getDiscountType(),
                                'discount_rate' => $item->getDiscountRate(),
                                'discount_text' => $discount_text,
                                'transfer_discount' => $item->getTransferDiscount(),
                                'barcode' => $item->getBarcode(),
                                'stock_code' => $item->getStockCode(),
                                'unit' => $item->getUnit(),
                                'unit_type' => $item->getUnitType(),
                                'cargo_weight' => $item->getCargoWeight(),
                                'offer' => $item->getOffer(),
                                'gift' => $item->getGift(),
                                'warranty' => $item->getWarranty(),
                                'new_chance' => (int) $item->getNewChance(),
                                'daily_chance' => (int) $item->getDailyChance(),
                                'unmissable_chance' => (int) $item->getUnmissableChance(),
                                'created_at' => $item->getCreatedAt(),
                                'updated_at' => $item->getUpdatedAt(),
                                'status' => $item->getStatus()
                            );
                        }
                    }

                    if (!empty($arr)) {
                        echo json_encode($arr);
                    } else {
                        //echo json_encode(array('code' => 9, 'message' => 'inconclusive!'));
                        exit();
                    }
                }

            }
        }
    }



    public function image($table = false, $id = false) {
        if (is_numeric($id)) {
            $image = '';
            $path  = '';
            $images = Images::findFirst('status=1 and meta_key="' . $table . '" and content_id=' . $id);
            if ($images) {
                $image = $images->getMetaValue();
                $path = $table;
            } else {
                $images = Images::findFirst('status=1 and meta_key="' . $table . '" and content_id=' . $id . '');
                if ($images) {
                    $image = $images->getMetaValue();
                    $path = $table;
                } else {
                    $image =  'resimyok.png';
                    $path  = '';
                }
            }

            return $path.'/'.$image;
        }
    }

    public function getImage($id = false, $table = false) {
        $image = '';
        $images = Images::findFirst('status=1 and meta_key="' . $table . '" and content_id=' . $id . ' and showcase=1');
        if ($images) {
            return $images->getMetaValue();
        } else {
            $images = Images::findFirst('status=1 and meta_key="' . $table . '" and content_id=' . $id . '');
            if ($images) {
                return $images->getMetaValue();
            }
        }
    }

    private function getSaleRate(string $getSaleRate) {
        $sale_rate = 'TL';
        if ($getSaleRate == 2) {
            $sale_rate = 'USD';
        } else if ($getSaleRate == 3) {
            $sale_rate = 'EURO';
        }
        return $sale_rate;
    }

    private function totalprice($id = false) {
        if (is_numeric($id)) {
            $pro = Product::findFirst($id);
            if ($pro) {
                $sale_price     = $pro->getSalePrice();
                $discount_type  = $pro->getDiscountType();
                $discount_rate  = $pro->getDiscountRate();
                $total_price    = $pro->getSalePrice();;

                if ($discount_type == 1) {
                    // fiyat
                    $clean_rate   = number_format($discount_rate, 2);
                    $total_price = $this->decimalAdd($sale_price, $clean_rate, 2);
                    $format       = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $total_price  = $format->format($total_price);
                    $clean_symbol = preg_replace( '/[^0-9,"."]/', '', $total_price );
                    $total_price  = $clean_symbol;
                } else if ($discount_type == 2) {
                    // yüzde
                    $total_price = ($sale_price * $discount_rate) / 100;
                    $total_price = $sale_price - $total_price;
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $total_price = $format->format($total_price);
                    $clean_symbol = preg_replace( '/[^0-9,"."]/', '', $total_price );
                    $total_price  = $clean_symbol;
                }
                return $total_price;
            }
        }
    }

    private function decimalAdd($a,$b,$numDecimals=2) {
        $intSum         = (int)str_replace(".","",$a) - (int)str_replace(".","",$b);
        $paddedIntSum   = str_pad(abs($intSum),$numDecimals,0,STR_PAD_LEFT);
        $result         = ($intSum<0?"-":"").($intSum<100&&$intSum>-100?"0":"").substr_replace($paddedIntSum,".",-$numDecimals,0);
        return $result;
    }

}