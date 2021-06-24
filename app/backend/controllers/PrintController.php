<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Dompdf\Dompdf;
use http\Env\Request;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yabasi\Address;
use Yabasi\Bank;
use Yabasi\Brand;
use Yabasi\Cargo;
use Yabasi\Cats;
use Yabasi\City;
use Yabasi\Comment;
use Yabasi\Content;
use Yabasi\Contentcats;
use Yabasi\Country;
use Yabasi\District;
use Yabasi\Feature;
use Yabasi\Order;
use Yabasi\Paymenttype;
use Yabasi\Pnotification;
use Yabasi\Product;
use Yabasi\Quarter;
use Yabasi\Refund;
use yabasi\sampleSpreadsheet;
use Yabasi\Settings;
use Yabasi\Supplier;
use Yabasi\Town;
use Yabasi\User;
use Yabasi\Usergroup;
use Yabasi\Variant;
use Yabasi\Vouchers;

require '../vendor/autoload.php';

class PrintController extends ControllerBase {

    public function initialize() {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    }

    public function indexAction($table = false) {
        $this->view->disable();
        if ($table) {
            $this->printExcel($table);
        }
    }

    public function printExcel($table = false) {

        $this->view->disable();

        if (!$table) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }

        $tables = array(
            'address',
            'request',
            'product',
            'settings',
            'bank',
            'content',
            'contentcats',
            'district',
            'cargo',
            'cats',
            'user',
            'usergroup',
            'quarter',
            'brand',
            'pnotification',
            'feature',
            'city',
            'town',
            'country',
            'variant',
            'comment',
            'vouchers',
            'supplier',

        );

        if (in_array($table, $tables)) {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            /* başlıkların with ayarlarnaması */
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->getColumnDimension('L')->setWidth(10);

            $sheet->getRowDimension(1)->setRowHeight(20);

            $sheet->getStyle('A1:L1')->getFont()->setBold(true);
            $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:L1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:L1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('e1ecf4');
            $sheet->getStyle('A1:L1')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('a0abb3'));


            if ($table == 'cats') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'EKLEYEN KULLANICI')
                    ->setCellValue('C1', 'ANA KATEGORİ')
                    ->setCellValue('D1', 'BAŞLIK')
                    ->setCellValue('E1', 'İÇERİK')
                    ->setCellValue('F1', 'SEO BAŞLIĞI')
                    ->setCellValue('G1', 'SEF URL')
                    ->setCellValue('H1', 'ANAHTAR KELİMELER')
                    ->setCellValue('I1', 'META AÇIKLAMA')
                    ->setCellValue('J1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('K1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('L1', 'DURUM');


                $cats = Cats::find();
                if (count($cats) != 0) {
                    $i = 1;
                    foreach ($cats as $cat) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($cat->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('L' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('L' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($cat->getUserId() != 0) {
                            $user = User::findFirst($cat->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($cat->getTopId() != 0) {
                            $mainCat = Cats::findFirst($cat->getTopId());
                            if ($mainCat) {
                                $anaKategori = $mainCat->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $cat->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $anaKategori);
                        $sheet->setCellValue('D' . $i, $cat->getName());
                        $sheet->setCellValue('E' . $i, $cat->getContent());
                        $sheet->setCellValue('F' . $i, $cat->getSeoTitle());
                        $sheet->setCellValue('G' . $i, $cat->getSef());
                        if ($cat->getKeyword()) {
                            $sheet->setCellValue('F' . $i, self::parseKeywords($cat->getKeyword()));
                        }
                        $sheet->setCellValue('I' . $i, $cat->getDescription());
                        $sheet->setCellValue('J' . $i, self::unixToDate($cat->getCreatedAt()));
                        $sheet->setCellValue('K' . $i, self::unixToDate($cat->getUpdatedAt()));
                        $sheet->setCellValue('L' . $i, $durum);
                    }
                }

            }
            if ($table == 'request') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'KULLANICI')
                    ->setCellValue('C1', 'ÜRÜN ADI')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $request = \Yabasi\Request::find();
                if (count($request)>0){
                    $i = 1;
                    foreach ($request as $request){
                        $i++;
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($request->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $kullanici="Bİlinmiyor";
                        $user=User::findFirst($request->getUserId());
                        if ($user){
                            $kullanici=$user->getName();
                        }
                        $pro="Bilinmiyor";
                        $product=Product::findFirst($request->getProductId());
                        if ($product){
                            $pro=$product->getName();
                        }

                        $sheet->setCellValue('A' . $i, $request->getId());
                        $sheet->setCellValue('B' . $i, $kullanici);
                        $sheet->setCellValue('C' . $i, $pro);
                        $sheet->setCellValue('D' . $i, self::unixToDate($request->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($request->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }

                }

            }
            elseif ($table == 'feature') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'ANA KATEGORİ')
                    ->setCellValue('C1', 'BAŞLIK')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $feature = Feature::find();
                if (count($feature) != 0) {
                    $i = 1;
                    foreach ($feature as $fea) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($fea->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($fea->getTopId() != 0) {
                            $mainFea = Feature::findFirst($fea->getTopId());
                            if ($mainFea) {
                                $anaKategori = $mainFea->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $fea->getId());
                        $sheet->setCellValue('B' . $i, $anaKategori);
                        $sheet->setCellValue('C' . $i, $fea->getName());
                        $sheet->setCellValue('D' . $i, self::unixToDate($fea->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($fea->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'address') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'EKLEYEN KULLANICI')
                    ->setCellValue('C1', 'ULKE ADI')
                    ->setCellValue('D1', 'SEHIR ADI')
                    ->setCellValue('E1', 'ILCE ADI')
                    ->setCellValue('F1', 'BAŞLIK')
                    ->setCellValue('G1', 'KULLANICI ADI')
                    ->setCellValue('H1', 'TELEFON')
                    ->setCellValue('I1', 'ADRES')
                    ->setCellValue('J1', 'POSTA KODU')
                    ->setCellValue('K1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('L1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('M1', 'DURUM');


                $address = Address::find();
                if (count($address) != 0) {
                    $i = 1;
                    foreach ($address as $add) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($add->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('M' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('M' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($add->getUserId() != 0) {
                            $user = User::findFirst($add->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $add->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $add->getCountryId());
                        $sheet->setCellValue('D' . $i, $add->getCityId());
                        $sheet->setCellValue('E' . $i, $add->getDistId());
                        $sheet->setCellValue('F' . $i, $add->getName());
                        $sheet->setCellValue('G' . $i, $add->getUserInfo());
                        $sheet->setCellValue('H' . $i, $add->getPhone());
                        $sheet->setCellValue('I' . $i, $add->getAddress());
                        $sheet->setCellValue('J' . $i, $add->getZipCode());
                        $sheet->setCellValue('K' . $i, self::unixToDate($add->getCreatedAt()));
                        $sheet->setCellValue('L' . $i, self::unixToDate($add->getUpdatedAt()));
                        $sheet->setCellValue('M' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'settings') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'BAŞLIK')
                    ->setCellValue('C1', 'ICERIK')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $settings = Settings::find();
                if (count($settings) != 0) {
                    $i = 1;
                    foreach ($settings as $set) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($set->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        $sheet->setCellValue('A' . $i, $set->getId());
                        $sheet->setCellValue('B' . $i, $set->getName());
                        $sheet->setCellValue('C' . $i, $set->getValue());
                        $sheet->setCellValue('D' . $i, self::unixToDate($set->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($set->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'bank') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'BASLIK')
                    ->setCellValue('C1', 'ICERIK')
                    ->setCellValue('E1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('F1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('G1', 'DURUM');


                $bank = Bank::find();
                if (count($bank) != 0) {
                    $i = 1;
                    foreach ($bank as $ba) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($ba->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        $sheet->setCellValue('A' . $i, $ba->getId());
                        $sheet->setCellValue('B' . $i, $ba->getName());
                        $sheet->setCellValue('C' . $i, $ba->getContent());
                        $sheet->setCellValue('D' . $i, self::unixToDate($ba->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($ba->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            } elseif ($table == 'supplier') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'BASLIK')
                    ->setCellValue('C1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('D1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('E1', 'DURUM');


                $supp = Supplier::find();
                if (count($supp) != 0) {
                    $i = 1;
                    foreach ($supp as $ba) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($ba->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('E' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        $sheet->setCellValue('A' . $i, $ba->getId());
                        $sheet->setCellValue('B' . $i, $ba->getName());
                        $sheet->setCellValue('C' . $i, self::unixToDate($ba->getCreatedAt()));
                        $sheet->setCellValue('D' . $i, self::unixToDate($ba->getUpdatedAt()));
                        $sheet->setCellValue('E' . $i, $durum);
                    }
                }

            } elseif ($table == 'content') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'EKLEYEN KULLANICI')
                    ->setCellValue('C1', 'KATEGORİ ADI')
                    ->setCellValue('D1', 'ICERIK KATEGORİ ADI')
                    ->setCellValue('E1', 'SEO BASLIK')
                    ->setCellValue('F1', 'ANAHTAR KELIME')
                    ->setCellValue('G1', 'SEF')
                    ->setCellValue('H1', 'BAGLANTI URL')
                    ->setCellValue('I1', 'BASLIK')
                    ->setCellValue('J1', 'KISA ICERIK')
                    ->setCellValue('K1', 'ICERIK')
                    ->setCellValue('L1', 'ACIKLAMA')
                    ->setCellValue('M1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('N1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('O1', 'DURUM');


                $content = Content::find();
                if (count($content) != 0) {
                    $i = 1;
                    foreach ($content as $con) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($con->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('O' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('O' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($con->getUserId() != 0) {
                            $user = User::findFirst($con->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($con->getCatId() != 0) {
                            $mainCat = Cats::findFirst($con->getCatId());
                            if ($mainCat) {
                                $anaKategori = $mainCat->getName();
                            }
                        }

                        $contentCat = 'Ana Kategori';
                        if ($con->getContentCatId() != 0) {
                            $mainCat = Contentcats::findFirst($con->getContentCatId());
                            if ($mainCat) {
                                $contentCat = $mainCat->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $con->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $anaKategori);
                        $sheet->setCellValue('C' . $i, $contentCat);
                        $sheet->setCellValue('E' . $i, $con->getSeoTitle());
                        if ($con->getKeyword()) {
                            $sheet->setCellValue('F' . $i, $con->getKeyword());
                        }
                        $sheet->setCellValue('G' . $i, $con->getSef());
                        $sheet->setCellValue('H' . $i, $con->getRedirectUrl());
                        $sheet->setCellValue('I' . $i, $con->getName());
                        $sheet->setCellValue('J' . $i, $con->getShortContent());
                        $sheet->setCellValue('K' . $i, $con->getContent());
                        $sheet->setCellValue('L' . $i, $con->getDescription());
                        $sheet->setCellValue('M' . $i, self::unixToDate($con->getCreatedAt()));
                        $sheet->setCellValue('N' . $i, self::unixToDate($con->getUpdatedAt()));
                        $sheet->setCellValue('O' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'contentcats') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'EKLEYEN KULLANICI')
                    ->setCellValue('C1', 'ANA KATEGORİ')
                    ->setCellValue('D1', 'SEO BAŞLIGI')
                    ->setCellValue('E1', 'SEF')
                    ->setCellValue('F1', 'ANAHTAR KELİMELER')
                    ->setCellValue('G1', 'AÇIKLAMA')
                    ->setCellValue('H1', 'ISIM')
                    ->setCellValue('I1', 'ICERIK')
                    ->setCellValue('J1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('K1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('L1', 'DURUM');


                $contentcats = Contentcats::find();
                if (count($contentcats) != 0) {
                    $i = 1;
                    foreach ($contentcats as $ccats) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($ccats->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('L' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('L' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($ccats->getUserId() != 0) {
                            $user = User::findFirst($ccats->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($ccats->getTopId() != 0) {
                            $mainCat = Cats::findFirst($ccats->getTopId());
                            if ($mainCat) {
                                $anaKategori = $mainCat->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $ccats->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $anaKategori);
                        $sheet->setCellValue('D' . $i, $ccats->getSeoTitle());
                        $sheet->setCellValue('E' . $i, $ccats->getSef());
                        if ($ccats->getKeyword()) {
                            $sheet->setCellValue('F' . $i, $ccats->getKeyword());
                        }
                        $sheet->setCellValue('G' . $i, $ccats->getDescription());
                        $sheet->setCellValue('H' . $i, $ccats->getName());
                        $sheet->setCellValue('I' . $i, $ccats->getContent());
                        $sheet->setCellValue('J' . $i, self::unixToDate($ccats->getCreatedAt()));
                        $sheet->setCellValue('K' . $i, self::unixToDate($ccats->getUpdatedAt()));
                        $sheet->setCellValue('L' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'district') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1','SEHIR ADI')
                    ->setCellValue('C1','BASLIK')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $district = District::find();
                if (count($district) != 0) {
                    $i = 1;
                    foreach ($district as $dis) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($dis->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($dis->getTownId() != 0) {
                            $mainDis = District::findFirst($dis->getTownId());
                            if ($mainDis) {
                                $anaKategori = $mainDis->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $dis->getId());
                        $sheet->setCellValue('B' . $i, $anaKategori);
                        $sheet->setCellValue('C' . $i, $dis->getName());
                        $sheet->setCellValue('D' . $i, self::unixToDate($dis->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($dis->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'cargo') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'BASLIK')
                    ->setCellValue('C1', 'İÇERİK')
                    ->setCellValue('D1', 'FIYAT')
                    ->setCellValue('E1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('F1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('G1', 'DURUM');


                $cargo = Cargo::find();
                if (count($cargo) != 0) {
                    $i = 1;
                    foreach ($cargo as $car) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($car->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('G' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('G' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $sheet->setCellValue('A' . $i, $car->getId());
                        $sheet->setCellValue('B' . $i, $car->getName());
                        $sheet->setCellValue('C' . $i, $car->getContent());
                        $sheet->setCellValue('D' . $i, $car->getPrice());
                        $sheet->setCellValue('E' . $i, self::unixToDate($car->getCreatedAt()));
                        $sheet->setCellValue('F' . $i, self::unixToDate($car->getUpdatedAt()));
                        $sheet->setCellValue('G' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'user') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'GRUP ADI')
                    ->setCellValue('C1', 'MAIL')
                    ->setCellValue('D1', 'AD SOYAD')
                    ->setCellValue('E1', 'TELEFON NUMARASI')
                    ->setCellValue('F1', 'TC KIMLIK NO')
                    ->setCellValue('G1', 'DOGUM TARIHI')
                    ->setCellValue('H1', 'CINSIYET')
                    ->setCellValue('I1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('J1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('K1', 'DURUM');


                $user = User::find();
                if (count($user) != 0) {
                    $i = 1;
                    foreach ($user as $us) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($us->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('K' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('K' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* cinsiyet bulduk */
                        $cinsiyet = 'Bilinmiyor';
                        if ($us->getGender() != 0) {
                            $cinsiyet = "Erkek";
                            }else {
                            $cinsiyet = "Kadın";
                        }


                        /* main kategori var ise onu set ettik */
                        $anaGrup = 'Tanımsız';
                        if ($us->getGroupId() != 0) {
                            $mainUser = Usergroup::findFirst($us->getGroupId());
                            if ($mainUser) {
                                $anaGrup = $mainUser->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $us->getId());
                        $sheet->setCellValue('B' . $i, $anaGrup);
                        $sheet->setCellValue('C' . $i, $us->getEmail());
                        $sheet->setCellValue('D' . $i, $us->getName());
                        $sheet->setCellValue('E' . $i, $us->getPhone());
                        $sheet->setCellValue('F' . $i, $us->getIdNo());
                        $sheet->setCellValue('G' . $i, $us->getBirthDate());
                        $sheet->setCellValue('H' . $i, $cinsiyet);
                        $sheet->setCellValue('I' . $i, self::unixToDate($us->getCreatedAt()));
                        $sheet->setCellValue('J' . $i, self::unixToDate($us->getUpdatedAt()));
                        $sheet->setCellValue('K' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'usergroup') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'GRUP ADI')
                    ->setCellValue('C1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('D1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('E1', 'DURUM');


                $usergroup = Usergroup::find();
                if (count($usergroup) != 0) {
                    $i = 1;
                    foreach ($usergroup as $ug) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($ug->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('E' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



                        $sheet->setCellValue('A' . $i, $ug->getId());
                        $sheet->setCellValue('B' . $i, $ug->getName());
                        $sheet->setCellValue('C' . $i, self::unixToDate($ug->getCreatedAt()));
                        $sheet->setCellValue('D' . $i, self::unixToDate($ug->getUpdatedAt()));
                        $sheet->setCellValue('E' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'quarter') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'ILCE ADI')
                    ->setCellValue('C1', 'BASLIK')
                    ->setCellValue('D1', 'POSTA KODU')
                    ->setCellValue('E1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('F1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('G1', 'DURUM');


                $quarter = Quarter::find();
                if (count($quarter) != 0) {
                    $i = 1;
                    foreach ($quarter as $qua) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($qua->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('G' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('G' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        /* main kategori var ise onu set ettik */
                        $anaIlce = 'Ana Ilce';
                        if ($qua->getDistrictId() != 0) {
                            $mainQua = Quarter::findFirst($qua->getDistrictId());
                            if ($mainQua) {
                                $anaIlce = $mainQua->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $qua->getId());
                        $sheet->setCellValue('B' . $i, $anaIlce);
                        $sheet->setCellValue('C' . $i, $qua->getName());
                        $sheet->setCellValue('D' . $i, $qua->getZipCode());
                        $sheet->setCellValue('E' . $i, self::unixToDate($qua->getCreatedAt()));
                        $sheet->setCellValue('F' . $i, self::unixToDate($qua->getUpdatedAt()));
                        $sheet->setCellValue('G' . $i, $durum);
                    }
                }

            }

            elseif ($table == 'brand') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'EKLEYEN KULLANICI')
                    ->setCellValue('C1', 'SEF URL')
                    ->setCellValue('D1', 'SEO BAŞLIĞI')
                    ->setCellValue('E1', 'AÇIKLAMA')
                    ->setCellValue('F1', 'ANAHTAR KELİMELER')
                    ->setCellValue('G1', 'BASLIK')
                    ->setCellValue('H1', 'İÇERİK')
                    ->setCellValue('I1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('J1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('K1', 'DURUM');


                $brand = Brand::find();
                if (count($brand) != 0) {
                    $i = 1;
                    foreach ($brand as $bra) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($bra->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('K' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('K' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($bra->getUserId() != 0) {
                            $user = User::findFirst($bra->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $bra->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $bra->getSef());
                        $sheet->setCellValue('D' . $i, $bra->getSeoTitle());
                        $sheet->setCellValue('E' . $i, $bra->getDescription());
                        if ($bra->getKeyword()) {
                            $sheet->setCellValue('F' . $i, self::parseKeywords($bra->getKeyword()));
                        }
                        $sheet->setCellValue('G' . $i, $bra->getName());
                        $sheet->setCellValue('H' . $i, $bra->getContent());
                        $sheet->setCellValue('I' . $i, self::unixToDate($bra->getCreatedAt()));
                        $sheet->setCellValue('J' . $i, self::unixToDate($bra->getUpdatedAt()));
                        $sheet->setCellValue('K' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'pnotification') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'EKLEYEN KULLANICI')
                    ->setCellValue('C1', 'SIPARIS')
                    ->setCellValue('D1', 'BANKA')
                    ->setCellValue('E1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('F1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('G1', 'DURUM');


                $paymentnotification = Pnotification::find();
                if (count($paymentnotification) != 0) {
                    $i = 1;
                    foreach ($paymentnotification as $pn) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($pn->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('G' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('G' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($pn->getUserId() != 0) {
                            $user = User::findFirst($pn->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        /* bankayı bulduk */
                        $banks = 'Banka Adı';
                        if($pn->getBankId()){
                            $mainBank = Bank::findFirst($pn->getBankId());
                            if($mainBank){
                                $banks = $mainBank->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $pn->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $pn->getOrderId());
                        $sheet->setCellValue('D' . $i, $banks);
                        $sheet->setCellValue('E' . $i, self::unixToDate($pn->getCreatedAt()));
                        $sheet->setCellValue('F' . $i, self::unixToDate($pn->getUpdatedAt()));
                        $sheet->setCellValue('G' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'refund') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'KULLANICI')
                    ->setCellValue('C1', 'ÖDEME TÜRÜ')
                    ->setCellValue('D1', 'SİPARİŞ KODU')
                    ->setCellValue('E1', 'İADE TUTARI')
                    ->setCellValue('F1', 'OLUŞTURULMA tarihi')
                    ->setCellValue('G1', 'DURUM');


                $refund = Refund::find();
                if (count($refund) != 0) {
                    $i = 1;
                    foreach ($refund as $pn) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($pn->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('G' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('G' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($pn->getUserId() != 0) {
                            $user = User::findFirst($pn->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }

                        }
                        $odeme="Bilinmiyor";
                        $order=Order::findFirst($pn->getOrderId());
                        if ($order){
                            $json=json_decode($order->getMetaValue(),true);
                            if ($json){
                                $a=(int)$json['payment_type'];
                                $paymetType=Paymenttype::findFirst($a);
                                if ($paymetType){
                                    $odeme=$paymetType->getName();
                                }
                            }
                        }


                        $sheet->setCellValue('A' . $i, $pn->getId());
                        $sheet->setCellValue('B' . $i, $ekleyen);
                        $sheet->setCellValue('C' . $i, $odeme);
                        $sheet->setCellValue('D' . $i, $pn->getCode());
                        $sheet->setCellValue('E' . $i, $pn->getRefundAmount()." ".$pn->getCurrency());
                        $sheet->setCellValue('F' . $i, self::unixToDate($pn->getCreatedAt()));
                        $sheet->setCellValue('G' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'city') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'ULKE ADI')
                    ->setCellValue('C1', 'BASLIK')
                    ->setCellValue('D1', 'PLAKA')
                    ->setCellValue('E1', 'ALAN KODU')
                    ->setCellValue('F1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('G1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('H1', 'DURUM');


                $city = City::find();
                if (count($city) != 0) {
                    $i = 1;
                    foreach ($city as $ct) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($ct->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('H' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('H' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $country = 'Bilinmiyor';
                        if ($ct->getUserId() != 0) {
                            $coun = Country::findFirst($ct->getCountryId());
                            if ($coun) {
                                $country = $coun->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $ct->getId());
                        $sheet->setCellValue('B' . $i, $country);
                        $sheet->setCellValue('C' . $i, $ct->getName());
                        $sheet->setCellValue('D' . $i, $ct->getPlaque());
                        $sheet->setCellValue('E' . $i, $ct->getAreaCode());
                        $sheet->setCellValue('F' . $i, self::unixToDate($ct->getCreatedAt()));
                        $sheet->setCellValue('G' . $i, self::unixToDate($ct->getUpdatedAt()));
                        $sheet->setCellValue('H' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'town') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'SEHIR ADI')
                    ->setCellValue('C1', 'BASLIK')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $town = Town::find();
                if (count($town) != 0) {
                    $i = 1;
                    foreach ($town as $tw) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($tw->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $sehir = 'Bilinmiyor';
                        if ($tw->getCityId() != 0) {
                            $sehirAdi = City::findFirst($tw->getCityId());
                            if ($sehirAdi) {
                                $sehir = $sehirAdi->getName();
                            }
                        }


                        $sheet->setCellValue('A' . $i, $tw->getId());
                        $sheet->setCellValue('B' . $i, $sehir);
                        $sheet->setCellValue('C' . $i, $tw->getName());
                        $sheet->setCellValue('D' . $i, self::unixToDate($tw->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($tw->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'country') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'IKILI KODU')
                    ->setCellValue('C1', 'UCLU KODU')
                    ->setCellValue('D1', 'BASLIK')
                    ->setCellValue('E1', 'ULKE KODU')
                    ->setCellValue('F1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('G1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('H1', 'DURUM');


                $ulke = Country::find();
                if (count($ulke) != 0) {
                    $i = 1;
                    foreach ($ulke as $ul) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($ul->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('H' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('H' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        $sheet->setCellValue('A' . $i, $ul->getId());
                        $sheet->setCellValue('A' . $i, $ul->getBinaryCode());
                        $sheet->setCellValue('A' . $i, $ul->getTripleCode());
                        $sheet->setCellValue('A' . $i, $ul->getName());
                        $sheet->setCellValue('A' . $i, $ul->getCountryCode());
                        $sheet->setCellValue('K' . $i, self::unixToDate($ul->getCreatedAt()));
                        $sheet->setCellValue('L' . $i, self::unixToDate($ul->getUpdatedAt()));
                        $sheet->setCellValue('M' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'variant') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'ANA KATEGORİ')
                    ->setCellValue('C1', 'BAŞLIK')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $variant = Variant::find();
                if (count($variant) != 0) {
                    $i = 1;
                    foreach ($variant as $var) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($var->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($var->getTopId() != 0) {
                            $mainCat = Cats::findFirst($var->getTopId());
                            if ($mainCat) {
                                $anaKategori = $mainCat->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $var->getId());
                        $sheet->setCellValue('B' . $i, $anaKategori);
                        $sheet->setCellValue('C' . $i, $var->getName());
                        $sheet->setCellValue('D' . $i, self::unixToDate($var->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($var->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'comment') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'URUN ADI')
                    ->setCellValue('C1', 'KULLANICI ADI')
                    ->setCellValue('D1', 'IP ADRESI')
                    ->setCellValue('E1', 'TARAYICI BILGISI')
                    ->setCellValue('F1', 'YORUM')
                    ->setCellValue('G1', 'PUAN')
                    ->setCellValue('H1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('I1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('J1', 'DURUM');


                $comment = Comment::find();
                if (count($comment) != 0) {
                    $i = 1;
                    foreach ($comment as $com) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($com->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('J' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('J' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($com->getUserId() != 0) {
                            $user = User::findFirst($com->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        /* main kategori var ise onu set ettik */
                        $anaPro = 'Ana Kategori';
                        if ($com->getProId() != 0) {
                            $mainPro = Product::findFirst($com->getProId());
                            if ($mainPro) {
                                $anaPro = $mainPro->getName();
                            }
                        }

                        $sheet->setCellValue('A' . $i, $com->getId());
                        $sheet->setCellValue('B' . $i, $anaPro);
                        $sheet->setCellValue('C' . $i, $ekleyen);
                        $sheet->setCellValue('D' . $i, $com->getIpAddress());
                        $sheet->setCellValue('E' . $i, $com->getUserAgent());
                        $sheet->setCellValue('F' . $i, $com->getComment());
                        $sheet->setCellValue('G' . $i, $com->getPoint());
                        $sheet->setCellValue('H' . $i, self::unixToDate($com->getCreatedAt()));
                        $sheet->setCellValue('I' . $i, self::unixToDate($com->getUpdatedAt()));
                        $sheet->setCellValue('J' . $i, $durum);
                    }
                }

            }
            elseif ($table == 'product') {
                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'URUN ADI')
                    ->setCellValue('C1', 'KATEGORİLER')
                    ->setCellValue('D1', 'STOK KODU')
                    ->setCellValue('E1', 'MARKA ')
                    ->setCellValue('F1', 'FiYAT')
                    ->setCellValue('G1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('H1', 'GÜNCELLENME TARİHİ')
                    ->setCellValue('I1', 'DURUM');

                $product = Product::find();
                if (count($product) != 0) {
                    $i = 1;
                    foreach ($product as $product) {
                        $i++;
                        $sale_rate = "";
                        $rate = $product->getSaleRate();
                        if ($rate) {
                            $sale_rate = 'TL';
                            if ($rate == 2) {
                                $sale_rate = 'USD';
                            } else if ($rate == 3) {
                                $sale_rate = 'EURO';
                            }
                        }

                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($product->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $anaKategori = '';
                        $cats = explode(",", $product->getCatsId());
                        foreach ($cats as $cat) {
                            $kategori = Cats::findFirst($cat);
                            $anaKategori .= $kategori->getName() . ",";
                        }

                        $brand = "Bilinmiyor";
                        $marka = Brand::findFirst($product->getBrandId());
                        if ($marka) {
                            $brand = $marka->getName();
                        }
                        $sheet->setCellValue('A' . $i, $product->getId());
                        $sheet->setCellValue('B' . $i, $product->getName());
                        $sheet->setCellValue('C' . $i, $anaKategori);
                        $sheet->setCellValue('D' . $i, $product->getStockCode());
                        $sheet->setCellValue('E' . $i, $brand);
                        $sheet->setCellValue('F' . $i, $product->getSalePrice() . " " . $sale_rate);
                        $sheet->setCellValue('G' . $i, self::unixToDate($product->getCreatedAt()));
                        $sheet->setCellValue('H' . $i, self::unixToDate($product->getUpdatedAt()));
                        $sheet->setCellValue('I' . $i, $durum);
                    }


                }
            }

            elseif ($table == 'vouchers') {

                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'BASLIK')
                    ->setCellValue('C1', 'META DEGERI')
                    ->setCellValue('D1', 'OLUŞTURMA TARİHİ')
                    ->setCellValue('E1', 'GÜNCELLEME TARİHİ')
                    ->setCellValue('F1', 'DURUM');


                $vouchers = Vouchers::find();
                if (count($vouchers) != 0) {
                    $i = 1;
                    foreach ($vouchers as $vou) {
                        $i++;

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        $durumBG = 'ff3434';
                        if ($vou->getStatus() == 1) {
                            $durum = 'AKTİF';
                            $durumBG = '4998ea';
                        }
                        $sheet->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($durumBG);
                        $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $sheet->setCellValue('A' . $i, $vou->getId());
                        $sheet->setCellValue('B' . $i, $vou->getName());
                        $sheet->setCellValue('C' . $i, $vou->getMetaValue());
                        $sheet->setCellValue('D' . $i, self::unixToDate($vou->getCreatedAt()));
                        $sheet->setCellValue('E' . $i, self::unixToDate($vou->getUpdatedAt()));
                        $sheet->setCellValue('F' . $i, $durum);
                    }
                }

            }

            $filename = 'oyos-' . time() . '.xls';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age:0');

            header('Cache-Control: max-age:1');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        } else {
            echo json_encode(array('code' => 404, 'message' => 'Wrong parameter!'));
            die();
        }
    }

    public function pdfAction($table = false) {

        $this->view->disable();
        $document = new Dompdf();
        if (!$table) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }

        $tables = array(
            'address',
            'product',
            'request',
            'settings',
            'bank',
            'content',
            'contentcats',
            'district',
            'cargo',
            'cats',
            'user',
            'usergroup',
            'quarter',
            'brand',
            'pnotification',
            'feature',
            'city',
            'town',
            'country',
            'variant',
            'comment',
            'vouchers',
            'supplier'
        );

        if (in_array($table, $tables)) {




            if ($table == 'cats') {


                $output = "

 <style>
 
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: 'Roboto', sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   


<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Kategoriler</H1></center>
  

    <table style='font-family: DejaVu Sans, sans-serif;' >
 <tr style='font-family: DejaVu Sans, sans-serif;'>
  <th style='font-family: DejaVu Sans, sans-serif;'>ID</th >
  <th style='font-family: DejaVu Sans, sans-serif;'>EKLEYEN KULLANICI</th>
  <th style='font-family: DejaVu Sans, sans-serif;'>ANAKATEGORİ</th>
  <th style='font-family: DejaVu Sans, sans-serif;'>BAŞLIK</th>
  <th style='font-family: DejaVu Sans, sans-serif;'>OLUŞTURULMA TARİHİ</th>
  <th style='font-family: DejaVu Sans, sans-serif;'>DURUM</th>
 </tr>

</body>
</html>';
        


";
                $cats = Cats::find();
                if (count($cats) != 0) {
                    foreach ($cats as $cat) {

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        if ($cat->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }


                        /* içerik ekleyen kullanıcıyı bulduk */
                        $ekleyen = 'Bilinmiyor';
                        if ($cat->getUserId() != 0) {
                            $user = User::findFirst($cat->getUserId());
                            if ($user) {
                                $ekleyen = $user->getName();
                            }
                        }

                        /* main kategori var ise onu set ettik */
                        $anaKategori = 'Ana Kategori';
                        if ($cat->getTopId() != 0) {
                            $mainCat = Cats::findFirst($cat->getTopId());
                            if ($mainCat) {
                                $anaKategori = $mainCat->getName();
                            }
                        }

                        $output .= '
     <tr style="font-family: DejaVu Sans, sans-serif;">
      <td style="font-family: DejaVu Sans, sans-serif;">' . $cat->getId() . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . $ekleyen . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . $anaKategori . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . $cat->getName() . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . self::unixToDate($cat->getCreatedAt()) . '</td>
    <td style="font-family: DejaVu Sans, sans-serif;">' . $durum . '</td>
  </tr style="font-family: DejaVu Sans, sans-serif;"> ';
                    }
                }
            }
            if ($table == 'product') {


                $output = "

 <style>
 
table {
margin-left:auto; 
margin-right:auto;
}
*{
font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   


<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Ürünler</H1></center>
  

    <table style='font-family: DejaVu Sans, sans-serif;' >
 <tr >
  <th>ID</th >
  <th >BAŞLIK</th> 
  <th >KATEGORİLER</th>
  <th >STOK KODU</th>
   <th >Marka</th>
   <th >Fiyat</th>
  <th >OLUŞTURULMA TARİHİ</th>
  <th >DURUM</th>
 </tr>

</body>
</html>';
        


";
                $product = Product::find();
                if (count($product) != 0) {
                    foreach ($product as $product) {
                        $sale_rate="";
                        $rate=$product->getSaleRate();
                        if ($rate) {
                            $sale_rate = 'TL';
                            if ($rate == 2) {
                                $sale_rate = 'USD';
                            } else if ($rate == 3) {
                                $sale_rate = 'EURO';
                            }
                            }
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';
                        if ($product->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $anaKategori = '';
                        $cats= explode(",",$product->getCatsId());
                        foreach ($cats as $cat){
                            $kategori=Cats::findFirst($cat);
                            $anaKategori.=$kategori->getName().",";
                        }

                        $brand="Bilinmiyor";
                        $marka = Brand::findFirst($product->getBrandId());
                        if ($marka){
                            $brand=$marka->getName();
                        }

                        $output .= '
     <tr style="font-family: DejaVu Sans, sans-serif;">
      <td style="font-family: DejaVu Sans, sans-serif;">' . $product->getId() . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . $product->getName() . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . $anaKategori . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . $product->getStockCode() . '</td>
     <td style="font-family: DejaVu Sans, sans-serif;">' . $brand . '</td>
      <td style="font-family: DejaVu Sans, sans-serif;">' . $product->getSalePrice()." ".$sale_rate . '</td>
   <td style="font-family: DejaVu Sans, sans-serif;">' . self::unixToDate($product->getCreatedAt()) . '</td>
    <td style="font-family: DejaVu Sans, sans-serif;">' . $durum . '</td>
  </tr style="font-family: DejaVu Sans, sans-serif;"> ';
                    }
                }
            }
            else if ($table == 'brand') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Markalar</H1></center>
  

   <table style='font-family: DejaVu Sans, sans-serif;'>
                    
 <tr>
  <th>ID</th>
  <th>MARKA ADI</th>
  <th>URL</th>
  <th>SEO BAŞLIĞI</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $brands = Brand::find();
                if (count($brands) != 0) {

                    foreach ($brands as $brand) {
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($brand->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }

                        $output .= '
       <tr>
            <td>' . $brand->getId() . '</td>
            <td>' . $brand->getName() . '</td>
            <td>' . $brand->getSef() . '</td>
            <td>' . $brand->getSeoTitle() . '</td>
            <td>' . self::unixToDate($brand->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }

            else if ($table == 'feature') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Ürün Özellikleri</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>ANA KATEGORİ</th>
  <th>BAŞLIK</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $features = Feature::find();
                if (count($features) != 0) {

                    foreach ($features as $feature) {
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($feature->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $anaKategori = 'Ana Kategori';
                        if ($feature->getTopId() != 0) {
                            $mainFeature = Feature::findFirst($feature->getTopId());
                            if ($mainFeature) {
                                $anaKategori = $mainFeature->getName();
                            }
                        }

                        $output .= '
       <tr>
            <td>' . $feature->getId() . '</td>
            <td>' . $anaKategori . '</td>
            <td>' . $feature->getName() . '</td>
            <td>' . self::unixToDate($feature->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }

            else if ($table == 'variant') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Varyasyon</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>ANA KATEGORİ</th>
  <th>BAŞLIK</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $variants = Variant::find();
                if (count($variants) != 0) {
                    foreach ($variants as $variant) {
                      /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($variant->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $anaKategori = 'Ana Kategori';
                        if ($variant->getTopId() != 0) {
                            $mainVariant = Variant::findFirst($variant->getTopId());
                            if ($mainVariant) {
                                $anaKategori = $mainVariant->getName();
                            }
                        }

                        $output .= '
       <tr>
            <td>' . $variant->getId() . '</td>
            <td>' . $anaKategori . '</td>
            <td>' . $variant->getName() . '</td>
            <td>' . self::unixToDate($variant->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            else if ($table == 'request') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>İSTEKLER</H1></center>
  

   <table >
 <tr>
  <th>ID</th>
  <th>KULLANICI</th>
  <th>ÜRÜN ADI</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>GÜNCELLENME TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $request = \Yabasi\Request::find();
                if (count($request) != 0) {
                    foreach ($request as $request) {
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($request->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $kullanici="Bilinmiyor";
                        $user=User::findFirst($request->getUserId());
                        if ($user){
                            $kullanici=$user->getName();
                        }
                        $pro="Bilinmiyor";
                        $product=Product::findFirst($request->getProductId());
                        if ($product){
                            $pro=$product->getName();
                        }
                        $output .= '
       <tr>
            <td>' . $request->getId() . '</td>
            <td>' . $kullanici . '</td>
            <td>' . $pro . '</td>
            <td>' . self::unixToDate($request->getCreatedAt()) . '</td>
             <td>' . self::unixToDate($request->getUpdatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }

            else if ($table == 'comment') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Yorumlar</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>KULLANICI</th>
  <th>ÜRÜN</th>
  <th>YORUM</th>
  <th>PUAN</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $comments= Comment::find();
                if (count($comments) != 0) {
                    foreach ($comments as $comment) {
                      /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($comment->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }

                        $proId=$comment->getProId();
                        if (isset($proId)){
                            $proname=Product::findFirst($proId);
                            if ($proname){
                                  $proId=$proname->getName();
                            }else{
                                $proId="Ürün Bulunamadı";
                            }
                            }
                        $userId=$comment->getUserId();
                        if (isset($userId)){
                            $email=User::findFirst($userId);
                                if ($email){
                                    $userId=$email->getEmail();
                                }else{
                                    $userId="Kullanıcı Bulunamadı";

                                }

                        }




                        $output .= '
       <tr>
            <td>' . $comment->getId() . '</td>
            <td>' . $userId . '</td>
            <td>' . $proId . '</td>
            <td>' . $comment->getComment() . '</td>
            <td>'.$comment->getPoint().'</td>
            <td>' . self::unixToDate($comment->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }

            else if ($table == 'cargo') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{
font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>KARGO FİRMALARI</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>KARGO FİRMA ADI</th>
   <th>FİYAT</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $cargos= Cargo::find();
                if (count($cargos) != 0) {
                    foreach ($cargos as $cargo) {
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($cargo->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
            $output .= '
       <tr>
            <td>' . $cargo->getId() . '</td>
            <td>'.$cargo->getName().'</td>
            <td>'.$cargo->getPrice().'</td>
            <td>' . self::unixToDate($cargo->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            else if ($table == 'bank') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Yorumlar</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>BANKA ADI</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $banks= Bank::find();
                if (count($banks) != 0) {
                    foreach ($banks as $bank) {
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($bank->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $output .= '
       <tr>
            <td>' . $bank->getId() . '</td>
            <td>'.$bank->getName().'</td>
            <td>' . self::unixToDate($bank->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }

            else if ($table == 'content') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>İçerikler</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>BAŞLIK</th>
  <th>KATEGORİ</th>
  <th>URL</th>
  <th>DÖNÜŞ URLSİ</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $contents= Content::find();
                if (count($contents) != 0) {
                   foreach ($contents as $content) {
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($content->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                             $cats=$content->getContentCatId();
                        if (isset($contents)){
                            $catName=Contentcats::findFirst($cats);
                            if (isset($catName)){
                                $cats=$catName->getName();

                            } else{
                                $cats="Kategori Bulunamadı";
                            }


                        }

                        $output .= '
       <tr>
            <td>' . $content->getId() . '</td>
            <td>'.$content->getName().'</td>
             <td>'.$cats.'</td>
             <td>'.$content->getSef().'</td>
             <td>'.$content->getRedirectUrl().'</td>
            <td>' . self::unixToDate($content->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }

            else if ($table == 'vouchers') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Kampanyalar</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>KAMPANYA ADI</th>
  <th>HEDİYE KODU</th>
  <th>İNDİRİM</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>BAŞLANGIÇ TARİHİ</th>
  <th>BİTİŞ TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $vouchers= Vouchers::find();
                if (count($vouchers) != 0) {

                    foreach ($vouchers as $voucher) {
                           $durum = 'PASİF';
                           if ($voucher->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $parse = json_decode($voucher->getMetaValue(),true);

                        $discount=$parse["discount"]."₺";
                        if ($parse['discount_type']=="2"){
                            $discount="%".$parse["discount"];
                        }

                        $output .= '
       <tr>
            <td>' . $voucher->getId() . '</td>
            <td>'.$voucher->getName().'</td>
             <td>'.$parse['voucher_code'].'</td>
             <td>'.$discount.'</td>
             <td>'.self::unixToDate($parse['start_date']) .'</td>
             <td>'.self::unixToDate($parse['end_date']) .'</td>
            <td>' . self::unixToDate($voucher->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            else if ($table == 'pnotification') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Ödeme Bildirimleri</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>Kullanıcı</th>
  <th>Banka</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $paymentnotification= Pnotification::find();
                if (count($paymentnotification) != 0) {
                foreach ($paymentnotification as $payment) {
                  /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($payment->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $user = $payment->getUserId();

                        if ($user){
                          $email=User::findFirst($user);
                          if ($email){
                              $user=$email->getEmail();
                          }else{
                              $user="Kullanıcı bulunamadı";

                          }
                        }
                        $bank=$payment->getBankId();
                        if (isset($bank)){
                            $banka=Bank::findFirst($bank);
                            if ($email){
                                $bank=$banka->getName();
                            }else{

                                $bank="banka bulunamadı";
                            }


                        }

                        $output .= '
       <tr>
            <td>' . $payment->getId() . '</td>
            <td>'.$user.'</td>
             <td>'.$bank.'</td>
            <td>' . self::unixToDate($payment->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            else if ($table == 'contentcats') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>İçerik Kategorileri</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>BAŞLIK</th>
  <th>ANAKATEGORİ</th>
  <th>URL</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $contentcats= Contentcats::find();
                if (count($contentcats) != 0) {

                    foreach ($contentcats as $contentcat) {
                        $anaKategori = 'Ana Kategori';
                        if ($contentcat->getTopId() != 0) {
                            $mainCat = Contentcats::findFirst($contentcat->getTopId());
                            if ($mainCat) {
                                $anaKategori = $mainCat->getName();
                            }
                        }
                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($contentcat->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }


                        $output .= '
       <tr>
            <td>' . $contentcat->getId() . '</td>
            <td>'.$contentcat->getName().'</td>
              <td>'.$anaKategori.'</td>
             <td>'.$contentcat->getSef().'</td>
            <td>' . self::unixToDate($contentcat->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            else if ($table == 'user') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Kullancılar</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>GRUP</th>
  <th>EMAİL</th>
  <th>ADI SOYADI</th>
  <th>TELEFON</th>
  <th>CİNSİYET</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $users= User::find();
                if (count($users) != 0) {

                    foreach ($users as $user) {

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($user->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }
                        $groups=$user->getGroupId();
                        if ($groups){
                            $group=Usergroup::findFirst($groups);
                             if ($group){
                                 $group=$group->getName();
                             }else{
                                 $group="Kullanıcı grubu bulunamadı";
                             }
                        }
                        $gender="Erkek";
                            if ($user->getGender() == "2") {
                                $gender = 'Kadın';
                            }else if($user->getGender()=="3"){
                                $gender = 'Belirtmek İstemiyor';
                            }


                        $output .= '
       <tr>
            <td>' . $user->getId() . '</td>
             <td>'.$group.'</td>
              <td>'.$user->getEmail().'</td>
            <td>'.$user->getName().'</td>
               <td>'.$user->getPhone().'</td>
             <td>'.$gender.'</td>
            <td>' . self::unixToDate($user->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            else if ($table == 'usergroup') {


                $output = "

 <style>
table {
margin-left:auto; 
margin-right:auto;
}
*{

font-family: DejaVu Sans, sans-serif;
}


td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
'<html lang='tr'>   
<link href=\"https://fonts.googleapis.com/css2?family=Dosis:wght@700&family=Roboto:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
</head>
<body>
<center><H1>Kullanıcı Grupları</H1></center>
  

   <table ”>
 <tr>
  <th>ID</th>
  <th>AD</th>
  <th>OLUŞTURULMA TARİHİ</th>
  <th>DURUM</th>
 </tr>

</body>
</html>';";
                $usergroups= Usergroup::find();
                if (count($usergroups) != 0) {

                    foreach ($usergroups as $usergroup) {

                        /* durumu text'e çevirdik */
                        $durum = 'PASİF';

                        if ($usergroup->getStatus() == 1) {
                            $durum = 'AKTİF';
                        }


                        $output .= '
       <tr>
            <td>' . $usergroup->getId() . '</td>
            <td>'.$usergroup->getName().'</td>
             <td>' . self::unixToDate($usergroup->getCreatedAt()) . '</td>
            <td>' . $durum . '</td>
        </tr> ';
                    }
                }
            }
            $output .= '</table>';
            $document->loadHtml($output, "UTF-8");
            $document->setPaper('A4', 'landscape');
            $document->render();
            $document->stream("Oyos" . $this->getnow(), array("Attachment" => 0));
        } else {
            echo json_encode(array('code' => 404, 'message' => 'Wrong parameter!'));
            die();
        }
    }


}