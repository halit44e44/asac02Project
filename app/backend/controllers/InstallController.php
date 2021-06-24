<?php
declare(strict_types=1);
namespace Yabasi\Backend\Controllers;

//içerik sistemi
use mysqli;
use Phalcon\Url;
use Yabasi\Modul;
use Yabasi\Settings;
use Yabasi\User;

class installController extends ControllerBase {

    public function initialize() {
        $this->view->cevir = self::getTranslator();
        $this->view->page='install';
    }

    public function indexAction($id = false) {
            if($this->request->isPost()){
                $servername=$this->request->getPost('servername');
                $db_username=$this->request->getPost('db_username');
                $db_pass=$this->request->getPost('db_pass');
                $db_name=$this->request->getPost('db_name');
                $port=$this->request->getPost('port');
                $email=$this->request->getPost('email');
                $password=$this->request->getPost('password');

                $database=" 'database' => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => '$db_username',
        'password' => '$db_pass',
        'dbname'   => '$db_name',
        'charset'  => 'utf8',
    ],";
                $dosya = fopen('../app/config/config.php', 'w');
                fwrite($dosya, '<?php

defined(\'BASE_PATH\') || define(\'BASE_PATH\', getenv(\'BASE_PATH\') ?: realpath(dirname(__FILE__) . \'/../..\'));
defined(\'APP_PATH\') || define(\'APP_PATH\', BASE_PATH . \'/app\');

return new \Phalcon\Config([
    \'version\' => \'1.0\','.
                    $database
                    .

                    ' \'application\' => [
        \'appDir\'         => APP_PATH . \'/\',
        \'modelsDir\'      => APP_PATH . \'/models/\',
        \'migrationsDir\'  => APP_PATH . \'/migrations/\',
        \'cacheDir\'       => BASE_PATH . \'/cache/\',
        \'baseUri\'        => preg_replace([\'/public([\/\\\\\\\])index.php$/\', \'@index.php@i\'], \'\', $_SERVER["PHP_SELF"]),
    ],

    \'printNewLine\' => true
]);
');
                fclose($dosya);
                $dosyamodel = fopen('../app/models/ModelController.php' , 'w');
                fwrite($dosyamodel, "<?php
declare(strict_types=1);

namespace Yabasi;

class ModelController  {


    public function model() {
     return '$db_name';
    }
}");


                // Create connection
                $conn = new mysqli("127.0.0.1", $db_username, $db_pass);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Create database
                $sql = "CREATE DATABASE ".$db_name;
                if ($conn->query($sql) === TRUE) {
                    echo "Database created successfully";
                } else {
                    echo "Error creating database: " . $conn->error;
                }

                $conn->close();
                $conn = new mysqli("127.0.0.1", $db_username, $db_pass, $db_name);


                $query = '';
                $sqlScript = file('../sql/yabasi_shop.sql');
                foreach ($sqlScript as $line) {

                    $startWith = substr(trim($line), 0, 2);
                    $endWith = substr(trim($line), -1, 1);

                    if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                        continue;
                    }

                    $query = $query . $line;
                    if ($endWith == ';') {
                        mysqli_query($conn, $query) or die('<div class="error-response sql-import-response">Hata olustu: <b>' . $query . '</b></div>');
                        $query = '';
                    }
                }


                $name = $this->request->getPost('name');
                $licence= $this->request->getPost('licence');
                $phone = $this->request->getPost('phone');
                $id_no = $this->request->getPost('id_no');
                $birth_date = $this->request->getPost('birth_date');
                $gender = $this->request->getPost('gender');
                $this->settings("licence_number","$licence");
                $this->settings("licence_startdate",$this->getnow());
                $this->settings("licence_enddate",time()+60*60*24*365);
                $this->settings("site_url",$servername);
                $insert = new User();
                $insert->setName($name);
                $insert->setEmail($email);
                $insert->setPassword($this->security->hash($password));
                $insert->setPhone($phone);
                $insert->setIdNo($id_no);
                $insert->setBirthDate(strtotime($birth_date));
                $insert->setGender($gender);
                $insert->setGroupId("1");
                $insert->setCreatedAt(time());
                $insert->setUpdatedAt(time());
                if ($insert->save()) {
                    $this->log($insert->getId(),$insert->getId(),"user","add");
                    $this->response->redirect('backend/user');
                } else {
                    $this->view->disable();
                    foreach ($insert->getMessages() as $message) {
                        echo $message;
                    }

            }

                $toplu_mail_gönderimi = $this->request->getPost('toplu_mail_gönderimi');
                $instagram_facebook = $this->request->getPost('instagram_facebook');
                $google_merchant = $this->request->getPost('google_merchant');
                $ziyaretci_cıkıs_teklifi = $this->request->getPost('ziyaretci_cıkıs_teklifi');
                $b2b = $this->request->getPost('b2b');
                $shopcart_order = $this->request->getPost('shopcart_order');
                $xml = $this->request->getPost('xml');
                $urun_karsilastirma = $this->request->getPost('urun_karsilastirma');
                $e_fatura = $this->request->getPost('e_fatura');
                $urun_kisisellestirme = $this->request->getPost('urun_kisisellestirme');
                $alisverissiz_tahsilat = $this->request->getPost('alisverissiz_tahsilat');
                $n11 = $this->request->getPost('n11');
                $hepsiburada = $this->request->getPost('hepsiburada');
                $gittigidiyor = $this->request->getPost('shopcart_order');
                $amazon = $this->request->getPost('amazon');
                $trendyol = $this->request->getPost('trendyol');
                $muhasebe = $this->request->getPost('muhasebe');
                $seo = $this->request->getPost('seo');
                $ios = $this->request->getPost('ios');
                $android = $this->request->getPost('android');
                $konsept_tasarim = $this->request->getPost('konsept_tasarim');
                $sureli_popup = $this->request->getPost('sureli_popup');
                $popup_voucher = $this->request->getPost('popup_voucher');
                $dil = $this->request->getPost('dil');
                $coklu_para_birimi = $this->request->getPost('coklu_para_birimi');
                $api = $this->request->getPost('api');

                if(isset($toplu_mail_gönderimi)) {
                    $this->model("Toplu mail gönderimi","toplu-mail-gönderimi","1",250,"Müşterilerinize toplu mail gönderin");
                } else {
                    $this->model("Toplu mail gönderimi","toplu-mail-gönderimi","0",250,"Müşterilerinize toplu mail gönderin");
                }
                if(isset($instagram_facebook)) {
                    $this->model("InstaShop && Facebook Store","instagram-facebook","1",1000,"E-ticaret siteniz sizin için instagramdan satış yapsın.Tüm ürünleriniz facebook üzderinden satış imakanı.");
                } else {
                    $this->model("InstaShop && Facebook Store","instagram-facebook","0",1000,"E-ticaret siteniz sizin için instagramdan satış yapsın.Tüm ürünleriniz facebook üzderinden satış imakanı.");
                }
                if(isset($google_merchant)) {
                    $this->model("Google Merchant","googlemerchant","1",250,"Google alışveriş üzerinde entegrasyon.");
                } else {
                    $this->model("Google Merchant","googlemerchant","0",250,"Google alışveriş üzerinde entegrasyon.");
                }
                if(isset($ziyaretci_cıkıs_teklifi)) {
                    $this->model("Ziyaretçi çıkış teklifi","update_product","1",100,"Kullanıcılar çıkmak istediğinde özel indirim teklifi sunabilme.");
                } else {
                    $this->model("Ziyaretçi çıkış teklifi","ziyaretci-çıkıs-teklifi","0",100,"Kullanıcılar çıkmak istediğinde özel indirim teklifi sunabilme.");
                }
                if(isset($b2b)) {
                    $this->model("Bayi (B2B) altyapısı","b2b","1",6000,"Bayiler için özel satış ve sipariş modülü");
                } else {
                    $this->model("Bayi (B2B) altyapısı","b2b","0",6000,"Bayiler için özel satış ve sipariş modülü");
                }
                if(isset($shopcart_order)) {
                    $this->model("Sepet ve sipariş hatırlatma","shopcart-order","1",250,"Kullanıcılara sepetinde ürünleri hatırlatma.");
                } else {
                    $this->model("Sepet ve sipariş hatırlatma","shopcart-order","0",250,"Kullanıcılara sepetinde ürünleri hatırlatma.");
                }
                if(isset($xml)) {
                    $this->model("Döviz Kurları","xml","1",500,"İstediğiniz bir XML altyapısının entegrasyonu.");
                } else {
                    $this->model("Döviz Kurları","xml","0",500,"İstediğiniz bir XML altyapısının entegrasyonu.");
                }
                if(isset($urun_karsilastirma)) {
                    $this->model("Ürün karşılaştırma","urun-karsilastirma","1",250,"Kullanıcılar siteniz üzerinde yer alan ürünleri karşılatırabilir.");
                } else {
                    $this->model("Ürün karşılaştırma","urun-karsilastirma","0",250,"Kullanıcılar siteniz üzerinde yer alan ürünleri karşılatırabilir.");
                }
                if(isset($e_fatura)) {
                    $this->model("E-Fatura modülü","e-fatura","1",500,"E-fatura modülü ile faturalarınız sisteme otomatik düşsün.");
                } else {
                    $this->model("E-Fatura modülü","e-fatura","0",500,"E-fatura modülü ile faturalarınız sisteme otomatik düşsün.");
                }
                if(isset($urun_kisisellestirme)) {
                    $this->model("Ürün kişiselleştirme","urun-kisisellestirme","1",250,"Kişileşirilebilir ürün satış imkanı.");
                } else {
                    $this->model("Ürün kişiselleştirme","urun-kisisellestirme","0",250,"Kişileşirilebilir ürün satış imkanı.");

                }
                if(isset($alisverissiz_tahsilat)) {
                    $this->model("Alışverişsiz tahsilat","alisverissiz-tahsilat","1",1000,"Müşterilerinden alışveriş yapmadan tahsil yapma imkanı sağlar.");
                } else {
                    $this->model("Alışverişsiz tahsilat","alisverissiz-tahsilat","0",1000,"Müşterilerinden alışveriş yapmadan tahsil yapma imkanı sağlar.");
                }
                if(isset($n11)) {
                    $this->model("N11 Entegrasyonu","n11","1",750,"E-Ticaret paneli üzerinden N11 ile eş zamanlı ürün, sipariş ve stok takip imkanı.");
                } else {
                    $this->model("N11 Entegrasyonu","n11","0",750,"E-Ticaret paneli üzerinden N11 ile eş zamanlı ürün, sipariş ve stok takip imkanı.");
                }
                if(isset($hepsiburada)) {
                    $this->model("Hepsiburada Entegrasyonu","hepsiburada","1",750,"Hepsiburada ile eş zamanlı ürün, sipariş ve stok yönetimi.");
                } else {
                    $this->model("Hepsiburada EntegrasyonuE","hepsiburada","1",750,"Hepsiburada ile eş zamanlı ürün, sipariş ve stok yönetimi.");
                }
                if(isset($gittigidiyor)) {
                    $this->model("Gittigidiyor entegrasyonu","gittigidiyor","1",750,"Panel üzerinden ürün, sipariş ve stok takibi yapabilme.");
                } else {
                    $this->model("Gittigidiyor entegrasyonu","gittigidiyor","0",750,"Panel üzerinden ürün, sipariş ve stok takibi yapabilme.");
                }

                if(isset($amazon)) {
                    $this->model("Amazon entegrasyonu","amazon","1",2000,"Amazon ile eş zamanlı ürün, sipariş ve stok yönetimi.");
                } else {
                    $this->model("Amazon entegrasyonu","amazon","0",2000,"Amazon ile eş zamanlı ürün, sipariş ve stok yönetimi.");
                }
                if(isset($trendyol)) {
                    $this->model("Trendyol entegrasyonu","trendyol","1",1000,"Panel üzerinden ürün, sipariş ve stok takibi yapabilme.");
                } else {
                    $this->model("Trendyol entegrasyonu","trendyol","0",1000,"Panel üzerinden ürün, sipariş ve stok takibi yapabilme.");
                }
                if(isset($muhasebe)) {
                    $this->model("Muhabse programı entegrasyonları","muhasebe","1",6000,"Eş zamanlı çalışan arayazılım.");
                } else {
                    $this->model("Muhabse programı entegrasyonları","muhasebe","0",6000,"Eş zamanlı çalışan arayazılım.");
                }
                if(isset($seo)) {
                    $this->model("Rakip SEO analizi","seo","1",0,"Rakip firmalar için ayrıntılı seo rakip analiz raporu.");
                } else {
                    $this->model("Rakip SEO analizi","seo","0",0,"Rakip firmalar için ayrıntılı seo rakip analiz raporu.");
                }
                if(isset($ios)) {
                    $this->model("Özel IOS uygulama","ios","1",0,"Apple mobil cihazlar için özel uygulama.");
                } else {
                    $this->model("Özel IOS uygulama","ios","0",0,"Apple mobil cihazlar için özel uygulama.");    }
                if(isset($android)) {
                    $this->model("Özel Android uygulama","android","1",0,"Android mobil cihazlar için özel uygulama.");
                } else {
                    $this->model("Özel Android uygulama","android","0",0,"Android mobil cihazlar için özel uygulama.");
                }
                if(isset($konsept_tasarim)) {
                    $this->model("Konsept tasarım","konsept-tasarim","1",0,"Size özel hazırlanan tasarım hizmeti");
                } else {
                    $this->model("Konsept tasarım","konsept-tasarim","0",0,"Size özel hazırlanan tasarım hizmeti");
                }
                if(isset($sureli_popup)) {
                    $this->model("Süreli popup","sureli-popup","1",250,"Ayarladığınız süre içinde çalışan popup modülü.");
                } else {
                    $this->model("Süreli popup","sureli-popup","0",250,"Ayarladığınız süre içinde çalışan popup modülü.");
                }
                if(isset($popup_voucher)) {
                    $this->model("Süreli popup ile kampanya","popup-voucher","1",250,"Süreli poup ile özel kampanya oluşturma imkanı.");
                } else {
                    $this->model("Süreli popup ile kampanya","popup-voucher","0",250,"Süreli poup ile özel kampanya oluşturma imkanı.");
                }
                if(isset($dil)) {
                    $this->model("Çoklu dil desteği","dil","1",2500,"Çoklu dil destei modülü ile dünyaya açılın.");
                } else {
                    $this->model("Çoklu dil desteği","dil","0",2500,"Çoklu dil destei modülü ile dünyaya açılın.");}
                if(isset($coklu_para_birimi)) {
                    $this->model("Çoklu para birimi","coklu-para-birimi","1",2500,"Çoklu para birimi ile tüm dünyaya satış yapın");
                } else {
                    $this->model("Çoklu para birimi","coklu-para-birimi","0",2500,"Çoklu para birimi ile tüm dünyaya satış yapın");
                }
                if(isset($api)) {
                    $this->model("Gelişmiş api modülü","api","1",900,"Gelişmiş api modülü ile size özel yazılımlar oluşturma imkanı.");
                } else {
                    $this->model("Gelişmiş api modülü","api","0",900,"Gelişmiş api modülü ile size özel yazılımlar oluşturma imkanı.");
                }
                echo '<div class="success-response sql-import-response">SQL dosyasi basariyla islendi.</div>';
            }




    }

public function model($name,$sef,$status,$price,$content){
        $model=new Modul();
        $model->setName($name);
        $model->setSef($sef);
        $model->setPrice($price);
        $model->setContent($content);
        $model->setCreatedAt($this->getnow());
        $model->setUpdatedAt($this->getnow());
        $model->setStatus($status);
        $model->save();
    }
    public function settings($name=false,$value=false){
        if ($name && $value){
            $settings=Settings::findFirst("name="."'$name'");
            if ($settings){
                $settings->setName($name);
                $settings->setValue($value);
                $settings->setCreatedAt($this->getnow());
                $settings->setUpdatedAt($this->getnow());
                $settings->setStatus(1);
                $settings->save();
                }
            else {
                $setting=new Settings();
                $setting->setName($name);
                $setting->setValue($value);
                $setting->setCreatedAt($this->getnow());
                $setting->setUpdatedAt($this->getnow());
                $setting->setStatus(1);
                $setting->save();
            }
        }
    }

    public function kontrolAction() {

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $servername = $this->request->getPost('servername');
                $licence = $this->request->getPost('licence');

                $actual_link = "http://$_SERVER[HTTP_HOST]";

                if ($actual_link != $servername) {
                    echo 'wronghost';
                    exit();
                }

                $salt = 'EhxbY"6/`B.jCSP@';
                $ency = sha1(md5(base64_encode($actual_link.$salt)));

                if ($ency == $licence) {
                    echo 'true';
                    exit();
                }else{
                    echo 'false';
                    exit();
                }
            }
        }
    }
}