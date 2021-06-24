<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use http\Env\Request;
use Yabasi\Cats;
use Yabasi\Mail;
use Yabasi\Product;
use Yabasi\Brand;
use Yabasi\Supplier;
use Yabasi\User;

class ProductbulkController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::checkLicenceKey();
        self::checkmodul('update_product');
        $this->view->cevir = self::getTranslator();
        $this->view->site_url = self::site_url();
        $this->view->page = 'product';
        $this->view->subpage = 'productbulk';
        $this->view->setVar("catList", $this->getcatsList());
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

    private function floatAddZero($value1, $value2) {
        $value = strval(floatval($value1) * floatval($value2));

        if (!strpos($value, ".")) {
            return $value.".00";
        }else {
            return $value;
        }
    }

    public function indexAction() {
        self::isAuthority("productbulk", "read");
    }

    public function categoryupdateAction(){

        $this->view->type = 'update';
        $this->view->brands = Brand::find('status=1');
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {
                    $this->view->disable();

                    $cat_id = $this->request->getPost('cat_id');
                    $brand = $this->request->getPost('brand');
                    $price_start = $this->request->getPost('price_start');
                    $price_end = $this->request->getPost('price_end');
                    $currency = $this->request->getPost('currency');
                    $status = $this->request->getPost('status');
                    $quantity = $this->request->getPost('quantity');
                    $operations = $this->request->getPost('operations');
                    $vat_rate = $this->request->getPost('kdv');
                    $guncelle = $this->request->getPost('guncelle');
                    $cargo_status = $this->request->getPost('cargo_status');
                    $product_status = $this->request->getPost('product_status');
                    $price_kind = $this->request->getPost('price_kind');
                    $price_operations = $this->request->getPost('price_operations');
                    $price_operations_value = $this->request->getPost('price_operations_value');

                    $update = Product::query();
                    $sql_number = 0;

                    if (!empty($cat_id)) {
                        $update = $update->where('FIND_IN_SET('.$cat_id.', cats_id)');
                        $sql_number++;
                    }

                    if (!empty($brand)) {
                        if ($sql_number > 0) {
                            $update = $update->andWhere('FIND_IN_SET('.$brand.', brand_id)');
                        }else{
                            $update = $update->where('FIND_IN_SET('.$brand.', brand_id)');
                        }
                    }


                    //Bu kısım sorun çıkartıyor
                    if (!empty($price_end) && $price_end > 0) {
                        if ($sql_number > 0) {
                            $update = $update->andWhere('sale_price >= '.$price_start.' AND sale_price <= '.$price_end.' AND sale_rate LIKE '.$currency);
                        }else{
                            $update = $update->where('sale_price >= '.$price_start.' AND sale_price <= '.$price_end.' AND sale_rate LIKE '.$currency);
                        }
                    }

                    if (!empty($status)) {
                        if ($sql_number > 0) {
                            $update = $update->andWhere('FIND_IN_SET('.$status.', status)');
                        }else{
                            $update = $update->where('FIND_IN_SET('.$status.', status)');
                        }
                    }

                    $update = $update->execute();

                    if ($update){
                        switch ($guncelle) {
                            case 'quantity':
                                if ($operations === "1") { //Arttır
                                    foreach ($update as $key) {
                                        $key->unit = intval($key->unit) + intval($quantity);
                                        $request=\Yabasi\Request::findFirst("product_id=".$key->id);
                                        if ($request){
                                            require APP_PATH.'/library/Mail.php';
                                            $test = Mail::product($request->getProductId());
                                        }
                                        if (!$key->update()) {
                                            echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün stoğu arttırılırken hata yaşandı."));
                                            exit();

                                        }
                                    }
                                }elseif ($operations === "2") { //Azalt
                                    foreach ($update as $key) {
                                        $key->unit = intval($key->unit) - intval($quantity);

                                        if (!$key->update()) {
                                            echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün stoğu azaltılırken hata yaşandı."));
                                            exit();
                                        }
                                    }
                                }elseif ($operations === "3") { //Eşittir

                                    foreach ($update as $key) {
                                        $key->unit = $quantity;
                                        if ($key->unit!=0){
                                            $request=\Yabasi\Request::findFirst("product_id=".$key->id);
                                            if ($request){
                                                require APP_PATH.'/library/Mail.php';
                                                $test = Mail::product($request->getProductId());
                                            }
                                        }
                                        var_dump($key->unit);
                                        if (!$key->update()) {
                                            echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün stoğu eşitlenirken hata yaşandı."));
                                            exit();
                                        }
                                    }
                                }
                                break;

                            case 'kdv':
                                foreach ($update as $key) {
                                    $key->vat_rate = $vat_rate;

                                    if (!$key->update()) {
                                        echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün stoğu eşitlenirken hata yaşandı."));
                                        exit();
                                    }
                                }
                                break;

                            case 'cargo':
                                if ($cargo_status === "disable") {
                                    foreach ($update as $key) {
                                        $key->shipping_fee = "";

                                        if (!$key->update()) {
                                            echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün kargo durumu değiştirilirken hata yaşandı."));
                                            exit();
                                        }
                                    }
                                }
                                break;

                            case 'product':
                                if ($product_status === "enable") {
                                    foreach ($update as $key) {
                                        $key->status = 1;

                                        if (!$key->update()) {
                                            echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün durumu aktif hale getirilirken hata yaşandı."));
                                            exit();
                                        }
                                    }
                                }else {
                                    foreach ($update as $key) {
                                        $key->status = 0;

                                        if (!$key->update()) {
                                            echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün durumu pasif hale getirilirken hata yaşandı."));
                                            exit();
                                        }
                                    }
                                }
                                break;

                            case 'price':
                                if ($price_kind === "1") {

                                    if ($price_operations === "1") { //Çarp
                                        foreach ($update as $key) {
                                            $key->sale_price = $this->floatAddZero($key->sale_price, $price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı çarparken hata yaşandı."));
                                                exit();
                                            }
                                        }

                                    }elseif ($price_operations === "2") { //Eşit
                                        foreach ($update as $key) {
                                            $key->sale_price = floatval($price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı eşitlenirken hata yaşandı."));
                                                exit();
                                            }
                                        }

                                    }elseif ($price_operations === "3") { //Arttır

                                        foreach ($update as $key) {
                                            $key->sale_price = floatval($key->sale_price) + floatval($price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı arttırılırken hata yaşandı."));
                                                exit();
                                            }
                                        }

                                    }elseif ($price_operations === "4") { //Azalt

                                        foreach ($update as $key) {
                                            $key->sale_price = floatval($key->sale_price) - floatval($price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı eksiltirken hata yaşandı."));
                                                exit();
                                            }
                                        }
                                    }
                                }else {

                                    if ($price_operations === "1") { //Çarp
                                        foreach ($update as $key) {
                                            $key->purchase_price = $this->floatAddZero($key->purchase_price, $price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı çarparken hata yaşandı."));
                                                exit();
                                            }
                                        }

                                    }elseif ($price_operations === "2") { //Eşit

                                        foreach ($update as $key) {
                                            $key->purchase_price = floatval($price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı eşitlenirken hata yaşandı."));
                                                exit();
                                            }
                                        }

                                    }elseif ($price_operations === "3") { //Arttır

                                        foreach ($update as $key) {
                                            $key->purchase_price = floatval($key->purchase_price) + floatval($price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı arttırılırken hata yaşandı."));
                                                exit();
                                            }
                                        }
                                    }elseif ($price_operations === "4") { //Azalt

                                        foreach ($update as $key) {
                                            $key->purchase_price = floatval($key->purchase_price) - floatval($price_operations_value);

                                            if (!$key->update()) {
                                                echo json_encode(array('status' => "error", 'id' => $key->id, 'message' => "Ürün satış fiyatı eksiltirken hata yaşandı."));
                                                exit();
                                            }
                                        }
                                    }
                                }

                                break;
                        }

                    }

                    echo json_encode(array('status' => 'ok', 'message' => 'İstenen değişiklikler yapıldı.'));
                }
            }
        }

    }

    public function productupdateAction()
    {
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        $brands = Brand::find('status=1');

        if ($brands->count() != 0) {
            $this->view->brands = $brands;
        }

        $suppliers = Supplier::find('status=1');

        if ($suppliers->count() != 0) {
            $this->view->suppliers = $suppliers;
        }

        $this->view->products_list = Product::find('status=1');
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {
                    $this->view->disable();
                    $id = $this->request->getPost('id');
                    $name = $this->request->getPost('name');
                    $stock_code = $this->request->getPost('stock_code');
                    $stock = $this->request->getPost('stock');
                    $vat_rate = $this->request->getPost('vat_rate');
                    $rate = $this->request->getPost('rate');
                    $transfer_discount = $this->request->getPost('transfer_discount');
                    $cargo_weight = $this->request->getPost('cargo_weight');
                    $purchase_price = $this->request->getPost('purchase_price');

                    $product = Product::findFirst($id);
                    if ($stock>0 && $product->getUnit()==0){
                        require APP_PATH.'/library/Mail.php';
                        $test = Mail::product($id);
                    }
                    $product->setName($name);
                    $product->setStockCode($stock_code);
                    $product->setUnit($stock);
                    $product->setVatRate($vat_rate);
                    $product->setSaleRate($rate);
                    $product->setTransferDiscount($transfer_discount);
                    $product->setCargoWeight($cargo_weight);
                    $product->setPurchasePrice($purchase_price);

                    try {
                        if ($product->update()){
                            echo json_encode(array('status' => 'ok', 'id' => $product->getId()));
                        }else{
                            echo json_encode(array('status' => 'error', 'message' => $product->getMessages()));
                        }

                    } catch (\Exception $e) {
                        echo json_encode(array('status' => 'error', 'message' => "HATA!"));
                    }
                }

            }
        }
    }
}