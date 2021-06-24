<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Phalcon\Security\Random;
use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Feature;
use Yabasi\Mail;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Relation;
use Yabasi\Supplier;
use Yabasi\Tags;
use Yabasi\User;
use Yabasi\Variant;
use Yabasi\Images;

// ürün yönetim sistmei
class ProductController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::isAuth();
        self::getModul();
        self::isAuthorityVolt();
        self::isAuthorityWrite("product");
        self::checkmodul('product');
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page='product';
        $this->view->subpage='product';
        $this->view->setVar("catList",$this->getcatsList());
        $this->view->setVar("currency_list", ['TL', 'USD', 'EURO']);
    }

    private function getcatsList() {
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

    public function indexAction() {
        $brands = Brand::find('status=1');
        if ($brands->count() != 0) {
            $this->view->brands = $brands;
        }

        $suppliers = Supplier::find('status=1');
        if ($suppliers->count() != 0) {
            $this->view->suppliers = $suppliers;
        }
    }

    public function updateAction($id = false) {

        self::isAuthority("product","edit");
        $this->view->type = 'update';

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $top_id = $this->request->getPost('top_id');
                $cat_id = $this->request->getPost('cat_id');
                $brand_id = $this->request->getPost('brand_id');
                $supplier_id = $this->request->getPost('supplier_id');
                $feature_id = $this->request->getPost("feature_id");
                $variant_id = $this->request->getPost("variant_id");
                $gift = $this->request->getPost("gift_id");
                $recommended_products = $this->request->getPost("recommended_products");
                $name = $this->request->getPost('name');
                $stock_code = $this->request->getPost('stock_code');
                $barcode_code = $this->request->getPost('barcode_code');
                $warranty = $this->request->getPost('warranty_period');
                $stock = $this->request->getPost('stock_quantity');
                $stock_type = $this->request->getPost('stock_type');
                $cargo_weight = $this->request->getPost('cargo_weight');
                $purchase_price = $this->request->getPost('purchase_price');
                $purchase_rate = $this->request->getPost('purchase_price_exchange_rate');
                $market_price = $this->request->getPost('market_price');
                $market_rate = $this->request->getPost('market_price_exchange_rate');
                $sale_price = $this->request->getPost('sale_price');
                $sale_rate = $this->request->getPost('sale_price_exchange_rate');
                $vat_definition = $this->request->getPost('vat_definition');
                $vat_rate = $this->request->getPost('vat_rate');
                $shipping_fee = $this->request->getPost('shipping_fee');
                $discount_type = $this->request->getPost('discount_type');
                $discount_rate = $this->request->getPost('discount_rate');
                $transfer_discount = $this->request->getPost('transfer_discount');
                $short_content = $this->request->getPost('short_content');
                $content = $this->request->getPost('content');
                $seo_title = $this->request->getPost('seo_title');
                $slugurl = $this->request->getPost('slugurl');
                $keyword = $this->request->getPost('keyword');
                $search_keywords = $this->request->getPost('search_keywords');
                $description = $this->request->getPost('description');

                $product = Product::findFirst($id);
                if ($top_id) {
                    $tops = implode(",", $top_id);
                    $product->setTopId($tops);
                }if ($stock>0 && $product->getUnit()==0){
                    require APP_PATH.'/library/Mail.php';
                    $test = Mail::product($id);
                }
                $product->setCatsId($cat_id);
                $product->setBrandId($brand_id);
                $product->setSupplierId($supplier_id);
                $product->setUserId($this->view->user_id);
                if ($variant_id) {
                    $varids = implode(",", $variant_id);
                    $product->setVariantId($varids);
                }
                $product->setFeatureId($feature_id);
                $product->setName($name);
                $product->setContent($content);
                $product->setShortContent($short_content);
                $product->setSeoTitle($seo_title);
                $product->setSef($this->slugify($slugurl));

                if ($keyword) {
                    $product->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                }

                if ($search_keywords) {
                    $product->setSearchKeywords(implode(', ', array_column(json_decode($search_keywords), 'value')));
                }

                $product->setDescription($description);
                $product->setPurchasePrice($purchase_price);
                $product->setPurchaseRate($purchase_rate);
                $product->setMarketPrice($market_price);
                $product->setMarketRate($market_rate);
                $product->setSalePrice($sale_price);
                $product->setSaleRate($sale_rate);
                $product->setVatDefinition($vat_definition);
                $product->setVatRate($vat_rate);
                if ($shipping_fee) {
                    $product->setShippingFee($shipping_fee);
                }
                $product->setDiscountType($discount_type);
                $product->setDiscountRate($discount_rate);
                $product->setTransferDiscount($transfer_discount);
                $product->setBarcode($barcode_code);
                $product->setStockCode($stock_code);
                $product->setCargoWeight($cargo_weight);
                $product->setOffer($recommended_products);
                $product->setUnit($stock);
                $product->setUnitType($stock_type);
                $product->setGift($gift);
                $product->setWarranty($warranty);

                $product->setRecommendedProducts($recommended_products);
                $product->setUpdatedAt($this->getnow());
                $product->setCreatedAt($this->getnow());
                $product->setStatus(1);

                /* ilişkili ürünler */
                if ($top_id) {
                    $count = count($top_id);
                    $this->relations($count, $top_id, $product->getId());
                }

                try {

                    if ($product->update()){
                        echo json_encode(array('status' => 'ok', 'id' => $product->getId()));
                    }else{
                        echo json_encode(array('status' => 'error', 'message' => $product->getMessages()));
                    }
                    die();

                } catch (\Exception $e) {
                    var_dump($e);
                }

            }
        }

        if (is_numeric($id)) {
            $product = Product::findFirst($id);
            if ($product) {

                $this->view->products = Product::findFirst($id);
                $this->view->products_list = Product::find('status=1');
                $this->view->features = Feature::find('status=1 and top_id=0');
                $this->view->variant = Variant::find('status=1 and top_id=0');
                $this->view->brands = Brand::find('status=1');
                $this->view->supplierList = Supplier::find('status=1');

                $pro = Product::find('status=1');
                if ($pro) {
                    $this->view->pro = $pro;
                }

                $this->view->images = Images::find('content_id = '. $id .' and meta_key = "product" ORDER BY "row" ASC');
                $this->view->preview_image = Images::find('content_id = '. $id .' and meta_key = "product"  ORDER BY "id" ASC')->getFirst();

                if($this->view->preview_image){
                    $this->view->preview_image = Images::find('content_id = '. $id .' and meta_key = "product" ORDER BY "id" ASC')->getFirst()->getMetaValue();
                }else{
                    $this->view->preview_image = null;
                }


                /* varyantları gonderiyoruz */

                $this->view->variants = $this->variant($id);
                $pvarmi = Productvariant::find('pro_id='.$id);
                if ($pvarmi) {
                    $arr = array();
                    foreach ($pvarmi as $item) {
                        //$result = array_map(function($v){ return (int) trim($v, "'"); }, explode(",", $item->getVariantId()));
                        $str = explode(",", $item->getVariantId());
                        var_dump($str);
                        foreach ($str as $ids) {
                            array_push($arr, $ids);
                        }
                    }
                    $this->view->arrvariant = $arr;
                }

                /* sayfa keywordsları gonderiyoruz */
                $tags = Tags::find('pro_id='.$id);
                $taglist = '';
                if (count($tags) > 0) {
                    foreach ($tags as $item) {
                        $taglist .= $item->getName().", ";
                    }
                    $taglist = rtrim($taglist, ", ");
                    $this->view->taglist = $taglist;
                }


            } else {
                $this->response->redirect('backend/product');
            }
        } else {
            $this->response->redirect('backend/product');
        }

    }

    public function relations($count = false, $top_id = false, $pro_id = false) {
        if ($top_id && is_numeric($pro_id)) {
            for ($i = 0; $i < $count; $i++) {
                $this->insertRelations($top_id[$i], $pro_id);
            }

            for ($i = 0; $i < $count; $i++) {
                if ($i == 1) {
                    $this->insertRelations($top_id[0], $top_id[1]);
                } else if ($i == 2) {
                    $this->insertRelations($top_id[0], $top_id[2]);
                    $this->insertRelations($top_id[1], $top_id[2]);
                } else if ($i == 3) {
                    $this->insertRelations($top_id[0], $top_id[3]);
                    $this->insertRelations($top_id[1], $top_id[3]);
                    $this->insertRelations($top_id[2], $top_id[3]);
                } else if ($i == 4) {
                    $this->insertRelations($top_id[0], $top_id[4]);
                    $this->insertRelations($top_id[1], $top_id[4]);
                    $this->insertRelations($top_id[2], $top_id[4]);
                    $this->insertRelations($top_id[3], $top_id[4]);
                } else if ($i == 5) {
                    $this->insertRelations($top_id[0], $top_id[5]);
                    $this->insertRelations($top_id[1], $top_id[5]);
                    $this->insertRelations($top_id[2], $top_id[5]);
                    $this->insertRelations($top_id[3], $top_id[5]);
                    $this->insertRelations($top_id[4], $top_id[5]);
                } else if ($i == 6) {
                    $this->insertRelations($top_id[0], $top_id[6]);
                    $this->insertRelations($top_id[1], $top_id[6]);
                    $this->insertRelations($top_id[2], $top_id[6]);
                    $this->insertRelations($top_id[3], $top_id[6]);
                    $this->insertRelations($top_id[4], $top_id[6]);
                    $this->insertRelations($top_id[5], $top_id[6]);
                } else if ($i == 7) {
                    $this->insertRelations($top_id[0], $top_id[7]);
                    $this->insertRelations($top_id[1], $top_id[7]);
                    $this->insertRelations($top_id[2], $top_id[7]);
                    $this->insertRelations($top_id[3], $top_id[7]);
                    $this->insertRelations($top_id[4], $top_id[7]);
                    $this->insertRelations($top_id[5], $top_id[7]);
                    $this->insertRelations($top_id[6], $top_id[7]);
                } else if ($i == 8) {
                    $this->insertRelations($top_id[0], $top_id[8]);
                    $this->insertRelations($top_id[1], $top_id[8]);
                    $this->insertRelations($top_id[2], $top_id[8]);
                    $this->insertRelations($top_id[3], $top_id[8]);
                    $this->insertRelations($top_id[4], $top_id[8]);
                    $this->insertRelations($top_id[5], $top_id[8]);
                    $this->insertRelations($top_id[6], $top_id[8]);
                    $this->insertRelations($top_id[7], $top_id[8]);
                }

            }
        }
    }

    public function insertRelations($top_id, $pro_id) {
        $items = Relation::findFirst('top_id='.$top_id.' and pro_id='.$pro_id);
        if (!$items) {
            $insert = new Relation();
            $insert->setProId($pro_id);
            $insert->setTopId($top_id);
            $insert->setCreatedAt(self::getnow());
            $insert->setUpdatedAt(self::getnow());
            $insert->setStatus(1);
            $insert->save();

            $insert = new Relation();
            $insert->setProId($top_id);
            $insert->setTopId($pro_id);
            $insert->setCreatedAt(self::getnow());
            $insert->setUpdatedAt(self::getnow());
            $insert->setStatus(1);
            $insert->save();
        }


        $items = Relation::findFirst('top_id='.$pro_id.' and pro_id='.$top_id);
        if (!$items) {
            $insert = new Relation();
            $insert->setProId($pro_id);
            $insert->setTopId($top_id);
            $insert->setCreatedAt(self::getnow());
            $insert->setUpdatedAt(self::getnow());
            $insert->setStatus(1);
            $insert->save();

            $insert = new Relation();
            $insert->setProId($top_id);
            $insert->setTopId($pro_id);
            $insert->setCreatedAt(self::getnow());
            $insert->setUpdatedAt(self::getnow());
            $insert->setStatus(1);
            $insert->save();
        }
    }

    public function variant($id = false) {

        if (is_numeric($id)) {
            $provar = Productvariant::find('pro_id='.$id);

            if (count($provar) > 0) {

                $returned = '';
                $i = 0;
                foreach ($provar as $item) {
                    $i++;
                    $returned .= '
                        <tr id="row_' . $item->getId() . '" data-vars="'.$item->getVariantId().'">
                            <input type="hidden" name="variant_id[]" value="' . $item->getVariantId() . '" />
                            <input type="hidden" name="name[]" value="' . $item->getVariantName() . '" />
                            <td width="200" class="pt-6 text-left">' . $item->getVariantName() . '</td> 
                            <td class="text-center"><input type="number" name="stock[]" value="' . $item->getStock() . '" min="0" value="0" class="form-control form-control-solid variant_name"></td> 
                            <td class="text-center"><input type="number" name="weight[]" value="' . $item->getWeight() . '" min="0" value="0" class="form-control form-control-solid variant_weight"></td> 
                            <td class="text-center"><input type="text" name="purchase_price[]" value="' . $item->getPurchasePrice() . '" class="form-control form-control-solid variant_pprice"></td> 
                            <td class="text-center"><input type="text" name="sale_price[]" value="' . $item->getSalePrice() . '" class="form-control form-control-solid variant_sprice"></td> 
                            <td class="pt-6">
                                <a data-id="'.$item->getId().'" data-index="'.$i.'" onclick="removeVar(this);" class="font-weight-boldest cursor-pointer"><i class="icon-xl fas fa-times text-danger"></i></a>
                            </td>
                        </tr>';
                }
                return $returned;
            }
        }

    }

    public function variantAction() {

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $id = $this->request->getPost('id');
                $stocky = $this->request->getPost('stock');
                $weight = $this->request->getPost('weight');
                $purchase_price = $this->request->getPost('purchase_price');
                $sale_price = $this->request->getPost('sale_price');
                $name = $this->request->getPost('name');
                $variant_id = $this->request->getPost('variant_id');

                if (is_numeric($id)) {

                    $total_stock = 0;

                    for ($i = 0; $i < count(array_filter($sale_price)); $i++) {

                        $total_stock += $stocky[$i];

                        $clean_sprice = self::priceTextCorrector($sale_price[$i]);
                        $clean_pprice = self::priceTextCorrector($purchase_price[$i]);

                        $is_there = Productvariant::findFirst('variant_id="'.$variant_id[$i].'" and pro_id='.$id);
                        if (!$is_there) {
                            $insert = new Productvariant();
                            $insert->setProId($id);
                            $insert->setVariantId($variant_id[$i]);
                            $insert->setVariantName($name[$i]);
                            $insert->setStock($stocky[$i]);
                            $insert->setWeight($weight[$i]);
                            $insert->setPurchasePrice($clean_pprice);
                            $insert->setSalePrice($clean_sprice);
                            $insert->setCreatedAt(self::getnow());
                            $insert->setUpdatedAt(self::getnow());
                            $insert->save();
                        } else {
                            $update = Productvariant::findFirst('variant_id="'.$variant_id[$i].'"');
                            if ($update) {
                                $update->setProId($id);
                                $update->setVariantId($variant_id[$i]);
                                $update->setVariantName($name[$i]);
                                $update->setStock($stocky[$i]);
                                $update->setWeight($weight[$i]);
                                $update->setPurchasePrice($clean_pprice);
                                $update->setSalePrice($clean_sprice);
                                $update->setCreatedAt(self::getnow());
                                $update->setUpdatedAt(self::getnow());
                                $update->save();
                            }
                        }

                        $stock = Productvariant::find('pro_id='.$id);
                        $total = 0;
                        if ($stock) {
                            foreach ($stock as $item) {
                                $total += (int) $item->getStock();
                            }
                            $update = Product::findFirst($item->getProId());
                            if ($update) {
                                $update->setUnit($total);
                                $update->update();
                            }
                        }

                    }

                    if (is_numeric($id)) {
                        $update = Product::findFirst($id);
                        if ($update) {
                            $update->setUnit($total_stock);
                            $update->setUpdatedAt(self::getnow());
                            $update->update();
                        }
                        echo 'ok';
                    }

                }

                exit();

                if ($stock && $sale_price) {
                    $count =  count(array_filter($stock));
                    $total_stock = 0;
                    for ($i = 0; $i < $count; $i++) {
                        $total_stock += $stock[$i];
                        $arr[] = array(
                            'name' => $name[$i],
                            'id' => $variant_id[$i],
                            'stock' => $stock[$i],
                            'weight' => $weight[$i],
                            'purchase_price' => $purchase_price[$i],
                            'sale_price' => $sale_price[$i],
                            'currency' => $currency[$i]
                        );
                    }
                }

                if (!empty($arr)) {
                    $json = json_encode($arr);
                    if (is_numeric($id)) {
                        $update = Product::findFirst($id);
                        if ($update) {
                            $update->setUnit($total_stock);
                            $update->setVariants($json);
                            $update->setUpdatedAt(self::getnow());
                            $update->update();
                        }
                        echo 'ok';
                    }
                } else {
                    $update = Product::findFirst($id);
                    if ($update) {
                        $update->setUnit(0);
                        $update->setVariants('');
                        $update->setVariantId('');
                        $update->setUpdatedAt(self::getnow());
                        $update->update();
                        echo 'ok';
                    }
                }



            }
        }
    }

    public function insertAction() {
        self::isAuthority("product","write");
        $this->view->type = 'insert';
        $this->view->variant      = Variant::find('status=1 and top_id=0');
        $this->view->products     = Product::find('status=1');
        $this->view->features     = Feature::find('status=1 and top_id=0');
        $this->view->brands       = Brand::find('status=1');
        $this->view->supplierList = Supplier::find('status=1');
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $top_id = $this->request->getPost('top_id');
                $cat_id = $this->request->getPost('cat_id');
                $brand_id = $this->request->getPost('brand_id');
                $supplier_id = $this->request->getPost('supplier_id');
                $feature_id = $this->request->getPost("feature_id");
                $variant_id = $this->request->getPost("variant_id");
                $gift = $this->request->getPost("gift_id");
                $recommended_products = $this->request->getPost("recommended_products");
                $name = $this->request->getPost('name');
                $stock_code = $this->request->getPost('stock_code');
                $barcode_code = $this->request->getPost('barcode_code');
                $warranty = $this->request->getPost('warranty_period');
                $stock = $this->request->getPost('stock_quantity');
                $stock_type = $this->request->getPost('stock_type');
                $cargo_weight = $this->request->getPost('cargo_weight');
                $purchase_price = $this->request->getPost('purchase_price');
                $purchase_rate = $this->request->getPost('purchase_price_exchange_rate');
                $market_price = $this->request->getPost('market_price');
                $market_rate = $this->request->getPost('market_price_exchange_rate');
                $sale_price = $this->request->getPost('sale_price');
                $sale_rate = $this->request->getPost('sale_price_exchange_rate');
                $vat_definition = $this->request->getPost('vat_definition');
                $vat_rate = $this->request->getPost('vat_rate');
                $shipping_fee = $this->request->getPost('shipping_fee');
                $discount_type = 1;
                $discount_rate = $this->request->getPost('discount_rate');
                $transfer_discount = $this->request->getPost('transfer_discount');
                $short_content = $this->request->getPost('short_content');
                $content = $this->request->getPost('content');
                $seo_title = $this->request->getPost('seo_title');
                $slugurl = $this->request->getPost('slugurl');
                $keyword = $this->request->getPost('keyword');
                $search_keywords = $this->request->getPost('search_keywords');
                $page_keywords = $this->request->getPost('page_keywords');
                $description = $this->request->getPost('description');

                $product = new Product();
                if ($top_id) {
                    $tops = implode(",", $top_id);
                    $product->setTopId($tops);
                }
                $product->setCatsId($cat_id);
                $product->setBrandId($brand_id);
                $product->setSupplierId($supplier_id);
                $product->setUserId($this->view->user_id);
                $product->setFeatureId($feature_id);
                if ($variant_id) {
                    $varids = implode(",", $variant_id);
                    $product->setVariantId($varids);
                }
                $product->setName($name);
                $product->setContent($content);
                $product->setShortContent($short_content);
                $product->setSeoTitle($seo_title);
                $product->setSef($this->slugify($slugurl));

                if ($keyword) {
                    $product->setKeyword(implode(', ', array_column(json_decode($keyword), 'value')));
                }

                if ($search_keywords) {
                    $product->setSearchKeywords(implode(', ', array_column(json_decode($search_keywords), 'value')));
                }

                $product->setDescription($description);
                $product->setPurchasePrice($purchase_price);
                $product->setPurchaseRate($purchase_rate);
                $product->setMarketPrice($market_price);
                $product->setMarketRate($market_rate);
                $product->setSalePrice($sale_price);
                $product->setSaleRate($sale_rate);
                $product->setVatDefinition($vat_definition);
                $product->setVatRate($vat_rate);
                $product->setShippingFee($shipping_fee);
                $product->setDiscountType($discount_type);
                $product->setDiscountRate($discount_rate);
                $product->setTransferDiscount($transfer_discount);
                $product->setBarcode($barcode_code);
                $product->setStockCode($stock_code);
                $product->setCargoWeight($cargo_weight);
                $product->setOffer($recommended_products);
                $product->setUnit($stock);
                $product->setUnitType($stock_type);
                $product->setGift($gift);
                $product->setWarranty($warranty);
                $product->setRecommendedProducts($recommended_products);
                $product->setUpdatedAt($this->getnow());
                $product->setCreatedAt($this->getnow());
                $product->setStatus(1);

                if ($product->save()){

                    /* sef url kaydettik */
                    $edit = Product::findFirst($product->getId());
                    $sef= self::generateSef("update","product",$this->slugify($slugurl),$product->getId());
                    $edit->setSef($sef);
                    $edit->update();

                    /* ilişkili ürünler */
                    if ($top_id) {
                        $count = count($top_id);
                        $this->relations($count, $top_id, $product->getId());
                    }

                    /* tags */
                    if ($page_keywords) {
                        $keyword = implode(', ', array_column(json_decode($page_keywords), 'value'));
                        $keyword = explode(',', $keyword);

                        foreach ($keyword as $item) {
                            $chek = Tags::findFirst('name="'.$item.'" and pro_id='.$product->getId());
                            if (!$chek) {
                                $insert = new Tags();
                                $insert->setProId($product->getId());
                                $insert->setName($item);
                                $insert->setCreatedAt(self::getnow());
                                $insert->setUpdatedAt(self::getnow());
                                $insert->setStatus(1);
                                $insert->save();
                            }
                        }
                    }

                    echo json_encode(array('status' => 'ok', 'id' => $product->getId()));
                }else{
                    foreach ($product->getMessages() as $item) {
                        echo $item;
                    }
                }

            }
        }
    }
    public function variantNameAction($id){
        $this->view->disable();
        $varinat=Variant::findFirst($id);
        echo $varinat->getName();

    }

    public function checkvarAction() {
        $this->view->disable();
        if ($this->request->isAjax()) {
            if ($this->request->isPost()) {
                $id = $this->request->getPost('id');
                if ($id) {
                    $item = Productvariant::findFirst('variant_id="'.$id.'"');
                    if ($item) {
                        echo 'var';
                    } else {
                        echo 'yok';
                    }
                }
            }
        }
    }

    public function deletevarAction() {
        $this->view->disable();
        if ($this->request->isAjax()) {
            if ($this->request->isPost()) {
                $id = $this->request->getPost('id');
                if (is_numeric($id)) {
                    $item = Productvariant::findFirst($id);
                    if ($item) {
                        $item->delete();
                        $stock = Productvariant::find('pro_id='.$item->getProId());
                        $total = 0;
                        if ($stock) {
                            foreach ($stock as $item) {
                                $total += (int) $item->getStock();
                            }
                            $update = Product::findFirst($item->getProId());
                            if ($update) {
                                $update->setUnit($total);
                                $update->update();
                            }
                        }
                        echo 'ok';
                    }
                }
            }
        }
    }

}
