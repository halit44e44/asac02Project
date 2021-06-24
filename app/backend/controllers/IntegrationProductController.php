<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Phalcon\Http\Response;
use Yabasi\Auth;
use Yabasi\IntegrationSettings;
use Yabasi\IntegrationCategory;
use Yabasi\IntegrationProduct;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Images;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Settings;
use Yabasi\Cats;

class IntegrationProductController extends ControllerBase {

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
        $this->view->subpage = 'integration_product';
    }

    public function indexAction() {
        $this->view->pick('integration/product/index');
    }

    
    public function addAction($place, $id) {
        $this->view->pick('integration/product/addProduct');
        $integrationCategoryList = [];
        $productVariantData = [];

        $product = Product::findFirst($id);

        //Entegrasyon için kategori, doldurulması gereken alanları buluyoruz
        $productCategory = explode(",", $product->getCatsId());
        foreach ($productCategory as $key) {
            $placeCategory = IntegrationCategory::findFirst('site_id = '.$key.' AND place = '.$place.' AND custom_fields != "{}"');

            if ($placeCategory) {
                array_push($integrationCategoryList, array(
                    "site_category_name" => Cats::findFirst($key)->getName(),
                    "place_category_id" => $placeCategory->getPlaceId(),
                    "custom_fields" => json_decode($placeCategory->getCustomFields(), true)
                ));
            }
        }
        ///////////

        //Variant bilgilerini bulma
        $productVariant = Productvariant::find('pro_id ='.$id);
        foreach ($productVariant as $key) {
            $productVariantData[$key->getId()] = array(
                "site_variant_id" => $key->getId(),
                "variant_name" => $key->getVariantName(),
                "stock" => $key->getStock(),
                "sale_price" => $key->getSalePrice()
            );
        }
        ///////////

        $this->view->productVariant = $productVariantData;
        $this->view->productName = $product->getName();
        $this->view->integrationCategoryList = $integrationCategoryList;

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $formData = $this->request->getPost();
                $fieldsList = [];
                $fieldsList['place_category_id'] = $formData['place_category_id'];
                unset($formData['place_category_id']);

                //Ürün daha önce ekli olup olmadığı kontrolü
                $productData = IntegrationProduct::find('site_id = '.$id.' AND place = '.$place.' AND place_category= '.$fieldsList['place_category_id']); 
                if ($productData) {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => "Bu ürün zaten ekli."
                    ));
                    
                    exit();
                }
                ///////////

                foreach ($formData as $key => $val) {
                    $key = explode("#!", $key);
                    $val = explode("#!", $val);
    
                    $fieldsList[]["list"][$key[0]][] = array(
                        "id" => $val[0],
                        "field" => $key[1],
                        "name" => $val[1]
                    );
                }

                $Addproduct = new IntegrationProduct();
                $Addproduct->setPlace($place);
                $Addproduct->setSiteId($id);
                $Addproduct->setPlaceId("");
                $Addproduct->setPlaceCategory($fieldsList['place_category_id']);
                $Addproduct->setCustomFields(json_encode($fieldsList, JSON_UNESCAPED_UNICODE));
                $Addproduct->setPrice("");

                if ($Addproduct->save()){
                    echo json_encode(array('status' => 'ok', 'id' => $Addproduct->getId()));
                }else{
                    echo json_encode(array('status' => 'error', 'message' => $Addproduct->getMessages()));
                }
            }
        }
    }
}