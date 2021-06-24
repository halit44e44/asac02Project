<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Phalcon\Url;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx\Theme;
use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\City;
use Yabasi\Content;
use Yabasi\Contentcats;
use Yabasi\Country;
use Yabasi\Currency;
use Yabasi\District;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

require '../vendor/autoload.php';

use Yabasi\Images;
use Yabasi\Neighborhood;
use Yabasi\Product;
use Yabasi\Settings;
use Yabasi\Themecontent;
use Yabasi\Themes;
use Yabasi\Town;
use Yabasi\User;
use Yabasi\Virtualpos;


//ayarlar
class SettingController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkLicenceKey();
        self::isAuthorityVolt();
        self::isAuthorityWrite("setting");
        self::checkmodul('setting');
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'setting';
    }

    public function indexAction() {
        self::isAuthority("setting", "read");
        $this->view->type = 'update';

        $this->view->countries = Country::find();
        $this->view->cities = City::find();
        $this->view->town = Town::find();
        $this->view->districts = District::find();
        $this->view->neighborhood = Neighborhood::find();

        $this->view->site_url = Settings::findFirst('name="site_url"');
        $this->view->licence_number = Settings::findFirst('name="licence_number"');

        $this->view->sirket_adi = Settings::findFirst('name="sirket_adi"');
        $this->view->sirket_resmi_adi = Settings::findFirst('name="sirket_resmi_adi"');
        $this->view->firma_yetkilisi = Settings::findFirst('name="firma_yetkilisi"');
        $this->view->sirket_email_adresi = Settings::findFirst('name="sirket_email_adresi"');
        $this->view->telefon_numarasi = Settings::findFirst('name="telefon_numarasi"');
        $this->view->fax_numarasi = Settings::findFirst('name="fax_numarasi"');

        $this->view->vergi_numarasi = Settings::findFirst('name="vergi_numarasi"');
        $this->view->vergi_dairesi = Settings::findFirst('name="vergi_dairesi"');
        $this->view->sicil_numarasi = Settings::findFirst('name="sicil_numarasi"');
        $this->view->kep_adresi = Settings::findFirst('name="kep_adresi"');
        $this->view->mersis_numarasi = Settings::findFirst('name="mersis_numarasi"');

        $this->view->ulke = Settings::findFirst('name="ulke"');
        $this->view->il = Settings::findFirst('name="il"');
        $this->view->ilce = Settings::findFirst('name="ilce"');
        $this->view->belde = Settings::findFirst('name="belde"');
        $this->view->mahalle = Settings::findFirst('name="mahalle"');
        $this->view->adres = Settings::findFirst('name="adres"');

        $this->view->smtp_sunucu = Settings::findFirst('name="smtp_sunucu"');
        $this->view->smtp_port = Settings::findFirst('name="smtp_port"');
        $this->view->smtp_gonderim_tipi = Settings::findFirst('name="smtp_gonderim_tipi"');
        $this->view->smtp_kullaniciadi = Settings::findFirst('name="smtp_kullaniciadi"');
        $this->view->smtp_sifre = Settings::findFirst('name="smtp_sifre"');

    }

    public function updateAction()
    {
        self::isAuthority("setting", "read");
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $param = $this->request->getPost('param');

                    if ($param == 'licence') {

                        $this->updateSettings('site_url', $this->request->getPost("site_url"));
                        $this->updateSettings('licence_number', $this->request->getPost("licence_number"));
                        return 'ok';

                    } else if ($param == 'sirket_bilgileri') {

                        $this->updateSettings('sirket_adi', $this->request->getPost("sirket_adi"));
                        $this->updateSettings('sirket_resmi_adi', $this->request->getPost("sirket_resmi_adi"));
                        $this->updateSettings('firma_yetkilisi', $this->request->getPost("firma_yetkilisi"));
                        $this->updateSettings('sirket_email_adresi', $this->request->getPost("sirket_email_adresi"));
                        $this->updateSettings('telefon_numarasi', $this->request->getPost("telefon_numarasi"));
                        $this->updateSettings('fax_numarasi', $this->request->getPost("fax_numarasi"));
                        return 'ok';

                    } else if ($param == 'vergi_bilgileri') {

                        $this->updateSettings('vergi_numarasi', $this->request->getPost('vergi_numarasi'));
                        $this->updateSettings('vergi_dairesi', $this->request->getPost('vergi_dairesi'));
                        $this->updateSettings('sicil_numarasi', $this->request->getPost('sicil_numarasi'));
                        $this->updateSettings('kep_adresi', $this->request->getPost('kep_adresi'));
                        $this->updateSettings('mersis_numarasi', $this->request->getPost('mersis_numarasi'));
                        return 'ok';

                    } else if ($param == 'adres_bilgileri') {

                        $this->updateSettings('ulke', $this->request->getPost('ulke'));
                        $this->updateSettings('il', $this->request->getPost('il'));
                        $this->updateSettings('ilce', $this->request->getPost('ilce'));
                        $this->updateSettings('belde', $this->request->getPost('belde'));
                        $this->updateSettings('mahalle', $this->request->getPost('mahalle'));
                        $this->updateSettings('adres', $this->request->getPost('adres'));
                        return 'ok';

                    } else if ($param == 'smtp') {
                        $this->updateSettings('smtp_sunucu', $this->request->getPost('smtp_sunucu'));
                        $this->updateSettings('smtp_port', $this->request->getPost('smtp_port'));
                        $this->updateSettings('smtp_gonderim_tipi', $this->request->getPost('smtp_gonderim_tipi'));
                        $this->updateSettings('smtp_kullaniciadi', $this->request->getPost('smtp_kullaniciadi'));
                        $this->updateSettings('smtp_sifre', $this->request->getPost('smtp_sifre'));
                        return 'ok';

                    } else if ($param == 'seo_home') {
                        $anasayfa_title = $this->request->getPost('anasayfa_title');
                        $anasayfa_keyword = $this->request->getPost('anasayfa_keyword');
                        $anasayfa_description = $this->request->getPost('anasayfa_description');

                        if ($anasayfa_keyword) {
                            $anasayfa_keyword = implode(', ', array_column(json_decode($anasayfa_keyword), 'value'));
                        }


                        $arr = array(
                            'title' => $anasayfa_title,
                            'keyword' => $anasayfa_keyword,
                            'description' => $anasayfa_description
                        );
                        $json = json_encode($arr);
                        $this->updateSettings('seo_home', $json);
                        echo 'ok';

                    } else if ($param == 'seo_cats') {
                        $kategori_title = $this->request->getPost('kategori_title');
                        $kategori_keyword = $this->request->getPost('kategori_keyword');
                        $kategori_description = $this->request->getPost('kategori_description');

                        if ($kategori_keyword) {
                            $kategori_keyword = implode(', ', array_column(json_decode($kategori_keyword), 'value'));
                        }


                        $arr = array(
                            'title' => $kategori_title,
                            'keyword' => $kategori_keyword,
                            'description' => $kategori_description
                        );
                        $json = json_encode($arr);
                        $this->updateSettings('seo_cats', $json);
                        echo 'ok';

                    } else if ($param == 'seo_brand') {
                        $marka_title = $this->request->getPost('marka_title');
                        $marka_keyword = $this->request->getPost('marka_keyword');
                        $marka_description = $this->request->getPost('marka_description');

                        if ($marka_keyword) {
                            $marka_keyword = implode(', ', array_column(json_decode($marka_keyword), 'value'));
                        }


                        $arr = array(
                            'title' => $marka_title,
                            'keyword' => $marka_keyword,
                            'description' => $marka_description
                        );
                        $json = json_encode($arr);
                        $this->updateSettings('seo_brand', $json);
                        echo 'ok';

                    } else if ($param == 'seo_content') {
                        $icerik_title = $this->request->getPost('icerik_title');
                        $icerik_keyword = $this->request->getPost('icerik_keyword');
                        $icerik_description = $this->request->getPost('icerik_description');

                        if ($icerik_keyword) {
                            $icerik_keyword = implode(', ', array_column(json_decode($icerik_keyword), 'value'));
                        }


                        $arr = array(
                            'title' => $icerik_title,
                            'keyword' => $icerik_keyword,
                            'description' => $icerik_description
                        );
                        $json = json_encode($arr);
                        $this->updateSettings('seo_content', $json);
                        echo 'ok';

                    } else if ($param == 'seo_contentcat') {
                        $icerikkat_title = $this->request->getPost('icerikkat_title');
                        $icerikkat_keyword = $this->request->getPost('icerikkat_keyword');
                        $icerikkat_description = $this->request->getPost('icerikkat_description');

                        if ($icerikkat_keyword) {
                            $icerikkat_keyword = implode(', ', array_column(json_decode($icerikkat_keyword), 'value'));
                        }


                        $arr = array(
                            'title' => $icerikkat_title,
                            'keyword' => $icerikkat_keyword,
                            'description' => $icerikkat_description
                        );
                        $json = json_encode($arr);
                        $this->updateSettings('seo_contentcat', $json);
                        echo 'ok';

                    } else if ($param == 'sitemap') {

                        $this->updateSettings('meta_tags', $this->request->getPost('meta_tags'));
                        $this->updateSettings('meta_google_analytics', $this->request->getPost('meta_google_analytics'));
                        $this->updateSettings('meta_google_order', $this->request->getPost('meta_google_order'));
                        $this->updateSettings('meta_cart_tracking_code', $this->request->getPost('meta_cart_tracking_code'));
                        $this->updateSettings('meta_product_tracking_code', $this->request->getPost('meta_product_tracking_code'));
                        $this->updateSettings('meta_home_tracking_code', $this->request->getPost('meta_home_tracking_code'));

                        return 'ok';

                    } else if ($param == 'point') {

                        $point = $this->request->getPost('point');
                        $comment_point = $this->request->getPost('comment_point');
                        if (!$comment_point) {
                            $comment_point = 0;
                        }
                        $register_point = $this->request->getPost('register_point');
                        if (!$register_point) {
                            $register_point = 0;
                        }
                        $advice_point = $this->request->getPost('advice_point');
                        if (!$advice_point) {
                            $advice_point = 0;
                        }
                        $shopping_point = $this->request->getPost('shopping_point');
                        if (!$shopping_point) {
                            $shopping_point = 0;
                        }

                        $arr = array(
                            'point' => (int)$point,
                            'comment_point' => (int)$comment_point,
                            'register_point' => (int)$register_point,
                            'advice_point' => (int)$advice_point,
                            'shopping_point' => (int)$shopping_point,
                        );

                        $pointValue = json_encode($arr);
                        $this->updateSettings('point', $pointValue);
                        return 'ok';

                    } else {
                        return 'error';
                    }

                }
            }
        }

    }


    public function paymentAction($id = false)
    {

        self::isAuthority("setting", "read");
        $this->view->subpage = 'paymentlist';
        $this->view->page = 'setting';
        $this->view->type = 'update';

        if (is_numeric($id)) {
            $virtualupdate = Virtualpos::findFirst($id);
            $this->view->virtual = $virtualupdate;
            $meta_value = json_decode($virtualupdate->getMetaValue(), true);
            $this->view->meta_value = $meta_value;
            $rate = json_decode($virtualupdate->getRate(), true);
            $this->view->rate = $rate;
            $this->view->id = $id;
        }
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{ if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $arr = array();
                $id = $this->request->getPost('id');
                $name = $this->request->getPost('name');
                $shop = $this->request->getPost('shop_no');
                $api_user = $this->request->getPost('api_user');
                $password = $this->request->getPost('password');
                $terminal_no = $this->request->getPost('terminal_no');
                $treed_secure = $this->request->getPost('3d_secure');
                $treed_secure_key = $this->request->getPost('treed_secure_key');
                $license = $this->request->getPost('license');
                $bonus = $this->request->getPost('bonus');
                $min_installment = $this->request->getPost('min_installment');
                $last = $this->request->getPost('last');
                $first = $this->request->getPost('first');
                $installment = $this->request->getPost('installment');
                $min_sum = $this->request->getPost('min_sum');

                for ($i = 1; $i < 37; $i++) {

                    $arr[$i] = $this->request->getPost("$i");
                }

                $arr2 = array(
                    'shop_no' => $shop,
                    'api_user' => $api_user,
                    'password' => $password,
                    'terminal_no' => $terminal_no,
                    "3d_secure" => $treed_secure,
                    '3d_secure_key' => $treed_secure_key,
                    'license' => $license,
                    'bonus' => $bonus,
                    'min_installment' => $min_installment,
                    'last' => $last,
                    'first' => $first,
                    'installment' => $installment,
                    'min_sum' => $min_sum,
                );

                if ($id) {
                    $virtualupdate = Virtualpos::findFirst($id);
                } else {
                    $virtualupdate = new Virtualpos();
                }

                $virtualupdate->setName($name);
                $virtualupdate->setMetaValue(json_encode($arr2));
                $virtualupdate->setRate(json_encode($arr));
                $virtualupdate->setCreatedAt($this->getnow());
                $virtualupdate->setUpdatedAt($this->getnow());

                if ($id) {
                    if ($virtualupdate->update()) {
                        echo json_encode(array('status' => true));
                    }
                } else {
                    if ($virtualupdate->save()) {
                        echo json_encode(array('status' => true));
                    } else {
                        echo json_encode(array('status' => false));
                    }
                }


            }
        }}

    }

    public function paymentlistAction()
    {
        self::isAuthority("setting", "read");
        $this->view->subpage = 'paymentlist';
        $this->view->type = 'update';

    }

    public function paymenttypeAction() {
        self::isAuthority("setting", "read");
        $this->view->subpage = 'paymenttype';
        $this->view->type = 'update';
    }

    public function seoAction() {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            $sitemap_links = '';
            $directory =  BASE_PATH.'\public\sitemap\/';
            $scanned_directory = array_diff(scandir($directory), array('..', '.'));
            if ($scanned_directory) {
                foreach ($scanned_directory as $item) {
                    $sitemap_links .= '<p class="bg-light text-dark py-2 px-4"><a target="_blank" href="sitemap/'.$item.'">sitemap/'.$item.'</a></p>';
                }
                $this->view->sitemap_links = $sitemap_links;
            }

            $this->view->type = 'update';
            self::isAuthority("setting", "read");
            $this->view->subpage = 'seo';

            $meta_tag = Settings::findFirst('name="meta_tags"');
            if ($meta_tag) {
                $this->view->meta_tag = $meta_tag->getValue();
            }

            $google_analytics = Settings::findFirst('name="meta_google_analytics"');
            if ($google_analytics) {
                $this->view->google_analytics = $google_analytics->getValue();
            }

            $google_order = Settings::findFirst('name="meta_google_order"');
            if ($google_order) {
                $this->view->google_order = $google_order->getValue();
            }

            $cart_tracking_code = Settings::findFirst('name="meta_cart_tracking_code"');
            if ($cart_tracking_code) {
                $this->view->cart_tracking_code = $cart_tracking_code->getValue();
            }

            $home_tracking_code = Settings::findFirst('name="meta_home_tracking_code"');
            if ($home_tracking_code) {
                $this->view->home_tracking_code = $home_tracking_code->getValue();
            }

            $product_tracking_code = Settings::findFirst('name="meta_product_tracking_code"');
            if ($product_tracking_code) {
                $this->view->product_tracking_code = $product_tracking_code->getValue();
            }

            $seo_home = Settings::findFirst('name="seo_home"');
            if ($seo_home) {
                $this->view->seo_home = json_decode($seo_home->getValue(), true);
            }

            $seo_cats = Settings::findFirst('name="seo_cats"');
            if ($seo_cats) {
                $this->view->seo_cats = json_decode($seo_cats->getValue(), true);
            }

            $seo_brand = Settings::findFirst('name="seo_brand"');
            if ($seo_brand) {
                $this->view->seo_brand = json_decode($seo_brand->getValue(), true);
            }

            $seo_content = Settings::findFirst('name="seo_content"');
            if ($seo_content) {
                $this->view->seo_content = json_decode($seo_content->getValue(), true);
            }

            $seo_contentcat = Settings::findFirst('name="seo_contentcat"');
            if ($seo_contentcat) {
                $this->view->seo_contentcat = json_decode($seo_contentcat->getValue(), true);
            }
        }


    }

    public function currencyAction()
    {
        self::isAuthority("setting", "read");

        $this->view->subpage = 'currency';
        $this->view->type = 'insert';

        $currency = Settings::findFirst('name="currency"');
        if ($currency) {
            $this->view->setting = $currency;
            $this->view->currency = json_decode($currency->getValue(), true);
        }
    }

    public function pointAction() {
        self::isAuthority("setting", "read");
        $this->view->type = 'update';
        $this->view->subpage = 'point';

        $points = Settings::findFirst('name="point"');
        if ($points) {
            $json = $points->getValue();
            $json = json_decode($json);
            $this->view->point = $json->point;
            $this->view->comment_point = $json->comment_point;
            $this->view->register_point = $json->register_point;
            $this->view->advice_point = $json->advice_point;
            $this->view->shopping_point = $json->shopping_point;
        }
    }

    public function pointlogsAction() {
        self::isAuthority("setting", "read");
        $this->view->type = 'update';
        $this->view->subpage = 'pointlogs';
    }

    public function updateSettings($key = false, $value)
    {
        self::isAuthority("setting", "read");
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($key) {
                $update = Settings::findFirst('name="' . $key . '"');
                if ($update) {
                    $update->setValue($value);
                    $update->setUpdatedAt(self::getnow());
                    $update->update();
                } else {
                    $insert = new Settings();
                    $insert->setName($key);
                    $insert->setValue($value);
                    $insert->setCreatedAt(self::getnow());
                    $insert->setUpdatedAt(self::getnow());
                    $insert->setStatus(1);
                    $insert->save();
                }
            }
        }

    }

    public function sitemapsAction() {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            $sitemap_dizin =  BASE_PATH.'\public\sitemap\/';

            $sitemapProduct = new Sitemap($sitemap_dizin.'sitemap-product.xml');
            $sitemapCats = new Sitemap($sitemap_dizin.'sitemap-cats.xml');
            $sitemapBrand = new Sitemap($sitemap_dizin.'sitemap-brand.xml');
            $sitemapContent = new Sitemap($sitemap_dizin.'sitemap-content.xml');
            $sitemapContentCata = new Sitemap($sitemap_dizin.'sitemap-contentcats.xml');

            $product = Product::find();
            $url = Settings::findFirst('name="site_url"')->getValue();

            foreach ($product as $product) {
                $sef = $product->getSef();
                $sitemapProduct->addItem("$url/$sef", time(), Sitemap::DAILY, 0.3);
            }
            $sitemapProduct->write();
            $cats = Cats::find();
            foreach ($cats as $cats) {
                $sef = $cats->getSef();
                $sitemapCats->addItem("$url/$sef", time(), Sitemap::DAILY, 0.3);
            }
            $sitemapCats->write();
            $brand = Brand::find();
            foreach ($brand as $brand) {
                $sef = $brand->getSef();
                $sitemapBrand->addItem("$url/$sef", time(), Sitemap::DAILY, 0.3);
            }
            $sitemapBrand->write();
            $contentcats = Contentcats::find();
            foreach ($contentcats as $contentcats) {
                $sef = $contentcats->getSef();
                $sitemapContentCata->addItem("$url/$sef", time(), Sitemap::DAILY, 0.3);
            }
            $sitemapContentCata->write();
            $content = Content::find();
            foreach ($content as $content) {
                $sef = $content->getSef();
                $sitemapContent->addItem("$url/$sef", time(), Sitemap::DAILY, 0.3);
            }
            $sitemapContent->write();

            echo json_encode(array('status' => "ok"));
        }



    }

    public function getcurrencyAction($id = false)
    {

        $this->view->disable();
        $this->view->type = 'update';
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{ if (is_numeric($id)) {

            $returned = '';

            $currency = Currency::findFirst($id);
            if ($currency) {
                $buy = $currency->getForexBuying();
                $sel = $currency->getForexSelling();
                $name = $currency->getName();

                $returned = '
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Alış:</label>
                       <input class="form-control buy" type="text" value="' . $buy . '" name="buy">
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Satış:</label>
                        <input class="form-control sell" type="text" value="' . $sel . '" name="sell">
                    </div>
                </div>';
            }
            echo $returned;
        }

            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {
                    $buying = $this->request->getPost('buy');
                    $selling = $this->request->getPost('sell');
                    $id = $this->request->getPost('id');

                    $currency = Currency::findFirst($id);
                    if ($currency) {
                        $currency->setForexSelling($selling);
                        $currency->setForexBuying($buying);
                        $currency->setUpdatedAt(self::getnow());
                        if ($currency->save()) {
                            echo "ok";
                        }
                    }
                }
            }}

    }


    public function themesAction()
    {

        self::isAuthority("setting", "read");
        $this->view->subpage = 'themes';

        $this->view->themes = Themes::find();
    }

    public function changethemeAction() {

        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $id = $this->request->getPost('id');

                    if (is_numeric($id)) {

                        $theme = Themes::findFirst($id);

                        if ($theme) {
                            $this->changeTheme();
                            $theme->setStatus(1);
                            if ($theme->update()) {
                                echo 'ok';
                            }
                        }
                    }
                }
            }
        }

    }

    public function changeTheme()
    {
        $update = Themes::find();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($update) {
                foreach ($update as $item) {
                    $item->setStatus(0);
                    $item->update();
                }
            }
        }

    }
    public function othersettingsAction(){
        $user=User::findFirst($this->getAuthId());
        self::isAuthority("setting", "read");
        $this->view->subpage = 'othersetting';
        $this->view->page = 'setting';
        $this->view->type = 'update';
        $cargo=Settings::findFirst("name='cargo'");
        $currency=Settings::findFirst("name='main_currency'");
        $tc=Settings::findFirst("name='tc_no'");
        $order=Settings::findFirst("name='order_iade'");
        $voucher=$order=Settings::findFirst("name='voucher_date'");
        if ($cargo){
            $this->view->cargo=$cargo;
        }
        if ($tc){
            $this->view->tc=$tc;
        }
        if ($currency){
            $this->view->currency=$currency;
        }
        if ($order){
            $this->view->order=$order;
        }
        if ($voucher){
            $this->view->voucher=$voucher;
        }

        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isAjax()){
                if ($this->request->isPost()){

                    $this->view->disable();
                    $cargoPrice=$this->request->getPost("cargo");
                    if ($cargoPrice==null){
                        $cargoPrice="";
                    }
                    if ($cargo){

                        $cargo->setValue($cargoPrice);

                    }else{
                        $cargo =new Settings();
                        $cargo->setValue($this->request->getPost("cargo"));
                        $cargo->setName("cargo");
                        $cargo->setCreatedAt($this->getnow());
                        $cargo->setUpdatedAt($this->getnow());
                        $cargo->setStatus(1);
                    }
                    if ($tc){
                        $tc->setValue($this->request->getPost("tc"));

                    }else{
                        $tc =new Settings();
                        $tc->setValue($this->request->getPost("tc"));
                        $tc->setName("tc_no");
                        $tc->setCreatedAt($this->getnow());
                        $tc->setUpdatedAt($this->getnow());
                        $tc->setStatus(1);
                    }
                    if ($currency) {
                        $currency->setValue($this->request->getPost("currency"));
                    } else{
                        $currency =new Settings();
                        $currency->setValue($this->request->getPost("currency"));
                        $currency->setName("main_currency");
                        $currency->setCreatedAt($this->getnow());
                        $currency->setUpdatedAt($this->getnow());
                        $currency->setStatus(1);
                    }
                    if ($order) {
                        $order->setValue($this->request->getPost("order"));
                    }   else{
                        $order =new Settings();
                        $order->setValue($this->request->getPost("order"));
                        $order->setName("order_iade");
                        $order->setCreatedAt($this->getnow());
                        $order->setUpdatedAt($this->getnow());
                        $order->setStatus(1);
                    }
                    if ($voucher) {
                        $voucher->setValue($this->request->getPost("order"));
                    }   else{
                        $voucher =new Settings();
                        $voucher->setValue($this->request->getPost("voucher"));
                        $voucher->setName("voucher_date");
                        $voucher->setCreatedAt($this->getnow());
                        $voucher->setUpdatedAt($this->getnow());
                        $voucher->setStatus(1);
                    }

                    if ($currency->save() && $tc->save() && $cargo->save() && $order->save() && $voucher->save()){
                        echo "ok";
                    }
                }
            }
        }



    }
}