<?php


namespace Yabasi\Frontend\Controllers;


use Phalcon\Mvc\Model;
use Yabasi\Cargocity;
use Yabasi\City;
use Yabasi\Comment;
use Yabasi\Content;
use Yabasi\ContentCats;
use Yabasi\District;
use Yabasi\Feature;
use Yabasi\Images;
use Yabasi\Order;
use Yabasi\Product;
use Yabasi\Productvariant;
use Yabasi\Relation;
use Yabasi\Settings;
use Yabasi\Shopcart;
use Yabasi\Town;
use Yabasi\User;
use Yabasi\Cats;
use Yabasi\Usergroup;
use Yabasi\Variant;
use Yabasi\Virtualpos;
use Yabasi\Vouchers;
use Yabasi\Voucheruse;

class Functions extends Model
{

    public static function totalprice($id, $total = false)
    {
        if (is_numeric($id)) {
            $pro = Product::findFirst($id);
            if ($pro) {
                $sale_price = $pro->getSalePrice();
                $discount_type = $pro->getDiscountType();
                $discount_rate = $pro->getDiscountRate();
                $total_price = $pro->getSalePrice();
                if ($total) {
                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate = number_format($discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    return $total_price;
                } else {

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate = number_format($discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);
                        $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                        $total_price = $format->format($total_price);
                        $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                        $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                        $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                        $total_price = $format->format($total_price);
                        $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                        $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                    }
                    return $total_price;
                }

            }
        }
    }
    public static function price($id)
    {
        if (is_numeric($id)) {
            $shop=Shopcart::findFirst($id);
            $pro = Product::findFirst($shop->getProId());
            if ($shop->getMetaValue()==null) {
                $sale_price = $pro->getSalePrice();
                $discount_type = $pro->getDiscountType();
                $discount_rate = $pro->getDiscountRate();
                $total_price = $pro->getSalePrice();

                if ($discount_type == 1) {
                        // fiyat
                    $clean_rate = number_format($discount_rate, 2);
                    $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $total_price = $format->format($total_price);
                    $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                    $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                } else if ($discount_type == 2) {
                    // yüzde
                    $total_price = ($sale_price * $discount_rate) / 100;
                    $total_price = $sale_price - $total_price;
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $total_price = $format->format($total_price);
                    $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                    $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                }
                return $total_price;
                }
            else{
                $variantId=$shop->getMetaValue();
                $variant=Productvariant::findFirst("pro_id=".$shop->getProId()." and variant_id="."'$variantId'");
                $sale_price = $variant->getSalePrice();
                $discount_type = $pro->getDiscountType();
                $discount_rate = $pro->getDiscountRate();

                if ($discount_type == 1) {
                    // fiyat
                    $clean_rate = number_format($discount_rate, 2);
                    $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $total_price = $format->format($total_price);
                    $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                    $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                } else if ($discount_type == 2) {
                    // yüzde
                    $total_price = ($sale_price * $discount_rate) / 100;
                    $total_price = $sale_price - $total_price;
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $total_price = $format->format($total_price);
                    $clean_symbol = preg_replace('/[^0-9,"."]/', '', $total_price);
                    $total_price = $clean_symbol . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                }
                return $total_price;
            }

            }

    }

    public static function oldprice($id = false)
    {
        if (is_numeric($id)) {

            $pro = Product::findFirst($id);
            if ($pro) {
                $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                $oldprice = $format->format($pro->getSalePrice());
                return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
            }
        }
    }
    public static function oldpricesepet($id = false)
    {
        if (is_numeric($id)) {
            $shop=Shopcart::findFirst($id);
            $pro = Product::findFirst($shop->getProId());
            if ($shop->getMetaValue()==null){
                if ($pro) {
                    $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                    $oldprice = $format->format($pro->getSalePrice());
                    return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
                }
            }else{
                $variantId=$shop->getMetaValue();
                $variant = Productvariant::findFirst("pro_id=".$shop->getProId()." and variant_id="."'$variantId'");
                $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
                $oldprice = $format->format($variant->getSalePrice());
                return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());
            }

        }
    }

    public static function totaldiscount($id = false)
    {
        if (is_numeric($id)) {
            $pro = Product::findFirst($id);
            if ($pro) {
                if ($pro->getDiscountRate() != 0){
                    $discount = '';
                    if ($pro->getDiscountType() == 1) {
                        $fiyat=$pro->getSalePrice();
                        $yuzde=(100*$pro->getDiscountRate())/$fiyat;
                        $yuzde=ceil($yuzde);
                        $discount ="%". $yuzde ;
                        return '<span>' . $discount . '</span>';
                    } elseif($pro->getDiscountType() == 2) {
                        $discount = '%' . $pro->getDiscountRate();
                        return '<span>' . $discount . '</span>';
                    }
                }
               else{
                    return "";
                }

            }
        }
    }

    public function decimalAdd($a, $b, $numDecimals = 2)
    {
        $intSum = (float)str_replace(".", "", $a) - (float)str_replace(".", "", $b);
        $paddedIntSum = str_pad(abs($intSum), $numDecimals, 0, STR_PAD_LEFT);
        $result = ($intSum < 0 ? "-" : "") . ($intSum < 100 && $intSum > -100 ? "0" : "") . substr_replace($paddedIntSum, ".", -$numDecimals, 0);
        return $result;
    }

    public function saleRate($rate = false)
    {
        if ($rate) {
            $sale_rate = 'TL';
            if ($rate == 2) {
                $sale_rate = 'USD';
            } else if ($rate == 3) {
                $sale_rate = 'EURO';
            }
            return $sale_rate;
        }
    }

    public static function comment($id)
    {
        $comment = Comment::findFirst($id);
        $anonim = $comment->getAnonymous();
        if ($anonim == 1) {
            $user = User::findFirst($comment->getUserId());
            if ($user) {
                return $user->getName();

            }
        } else if ($anonim == 0) {
            $user = User::findFirst($comment->getUserId());
            if ($user) {
                return substr($user->getName(), 0, 3) . "***";

            }
        }
    }

    public static function prodate($tarih)
    {
        $day = date('w', strtotime($tarih));
        if ($day == 0) {
            $day = "Pazar";
        } else if ($day == 1) {
            $day = "Pazartesi";
        } else if ($day == 2) {
            $day = "Salı";
        } else if ($day == 3) {
            $day = "Çarşamba";
        } else if ($day == 4) {
            $day = "Perşembe";
        } else if ($day == 5) {
            $day = "Cuma";
        } else if ($day == 6) {
            $day = "Cumartesi";
        }
        $tarih = date("d-m-Y", $tarih);
        $tarih = explode(" ", $tarih);
        $tarih = explode("-", $tarih[0]);
        switch ($tarih[1]) {
            case "01":
                $tarih[1] = "Ocak";
                break;

            case "02":
                $tarih[1] = "Şubat";
                break;

            case "03":
                $tarih[1] = "Mart";
                break;

            case "04":
                $tarih[1] = "Nisan";
                break;

            case "05":
                $tarih[1] = "Mayıs";
                break;

            case "06":
                $tarih[1] = "Haziran";
                break;

            case "07":
                $tarih[1] = "Temmuz";
                break;

            case "08":
                $tarih[1] = "Ağustos";
                break;

            case "09":
                $tarih[1] = "Eylül";
                break;

            case "10":
                $tarih[1] = "Ekim";
                break;

            case "11":
                $tarih[1] = "Kasım";
                break;

            case "12":
                $tarih[1] = "Aralık";
                break;
        }

        return $tarih[0] . " " . $tarih[1] . " " . $tarih[2] . " " . $day;
    }


    public static function points($point)
    {
        $points = "";
        $point = round($point);
        if (is_numeric($point)) {

            for ($i = 0; $i < $point; $i++) {
                $points .= '<i class="fa fa-star"></i>';
            }
            return $points;
        }
    }

    /* breadcrumb için kategori bilgileri */
    public static function cats($id) {
        if (is_numeric($id)) {
            $cat = Cats::findFirst($id);
            if ($cat) {
                return $cat->getName();
            }
        }
    }

    public static function catsef($id) {
        if (is_numeric($id)) {
            $cat = Cats::findFirst($id);
            if ($cat) {
                return $cat->getSef();
            }
        }
    }

    public static function feature($id)
    {
        if (is_numeric($id)) {
            $features = Feature::findFirst($id);
            if ($features) {
                $featuresName = $features->getName();
                return $featuresName;
            }
        }

    }

    public static function featureName($id)
    {
        if (is_numeric($id)) {
            $features = Feature::findFirst($id);
            if ($features) {
                $feature = Feature::findFirst("id=" . $features->getTopId());
                return $feature->getName();
            }
        }
    }

    public static function product($id)
    {
        if (is_numeric($id)) {
            $pro = Product::findFirst($id);
        }
        if ($pro) {

            return $pro;
        }
    }

    public static function cargo($id, $priece = false)
    {
        if (isset($_COOKIE['auth'])) {
            $toplam_fiyat = 0;
            $total = Shopcart::find("user_id=" . $id);
            foreach ($total as $total) {
                $pro = Product::findFirst($total->getProId());
                if ($pro->getShippingFee() == null) {
                    $toplam_fiyat += 0;
                } else {
                    $toplam_fiyat += $pro->getShippingFee();
                }

            }
            if ($priece == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        } else {
            $toplam_fiyat = 0;

            $total = Shopcart::find("session_id=" . "'$id'");
            foreach ($total as $total) {
                $pro = Product::findFirst($total->getProId());
                if ($pro->getShippingFee() == null) {
                    $toplam_fiyat += 0;
                } else {
                    $toplam_fiyat += $pro->getShippingFee();
                }
            }
            if ($priece == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        }
    }

    public static function productImage($id)
    {

        /* bu alanı revize ettim omer. eger showcase 1 olan ürün yok ise koşulsuz return ettik.*/
        $images = Images::findFirst('status=1 and meta_key="product" and content_id=' . $id . ' and showcase=1');
        if ($images) {
            return $images->getMetaValue();
        } else {
            $images = Images::findFirst('status=1 and meta_key="product" and content_id=' . $id . '');
            if ($images) {
                return $images->getMetaValue();
            }
        }
    }

    public static function sepettotalprice($id, $price = false)
    {
        if (isset($_COOKIE['auth'])) {
            $toplam_fiyat = 0;
            $total = Shopcart::find("user_id=" . $id);
            foreach ($total as $total) {
                $toplam_fiyat += self::totalpriceVocuher($total->getProId(),$total->getMetaValue()) * $total->getPiece();
            }
            if ($price == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        } else {
            $toplam_fiyat = 0;
            $total = Shopcart::find("session_id=" . "'$id'");
            foreach ($total as $total) {
                $toplam_fiyat += self::totalpriceVocuher($total->getProId(),$total->getMetaValue()) * $total->getPiece();
            }
            if ($price == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        }
    }

    public static function pricesepet($id = false, $pro_id = false)
    {
        if (is_numeric($id)) {
            $pro = Product::findFirst($pro_id);
            $format = new \NumberFormatter("tr-TR", \NumberFormatter::CURRENCY);
            $oldprice = $format->format($id);
            return preg_replace('/[^0-9,"."]/', '', $oldprice) . ' ' . (new Functions)->saleRate($pro->getSaleRate());

        }
    }

    public static function round($number)
    {
        return round($number);
    }

    public static function city($id)
    {
        $city = City::findFirst($id);
        return $city->getCityName();
    }

    public static function town($id)
    {
        $town = Town::findFirst($id);
        return $town->getTownName();
    }

    public static function dist($id)
    {
        $dist = District::findFirst($id);
        return $dist->getDistrictName();
    }

    public static function taksit($id, $total)
    {
        $taksits = "";
        $pos = Virtualpos::findFirst("status=1 and id=" . $id);

        $rate = json_decode($pos->getRate(), true);
        foreach ($rate as $rat => $value) {

            if (is_numeric($value)) {
                $tutar = $value + $total;
                $taksit = number_format($tutar / $rat, 2);
                $tutar = number_format($tutar, 2);
                $taksits .= "<tr>
                                <td>$rat</td>
                                <td>$taksit</td>
                                <td>$tutar</td>
                            </tr>";

            }
        }
        return $taksits;
    }

    public static function order($id)
    {
        $order = Order::findFirst($id);
        if ($order) {
            $json = json_decode($order->getMetaValue(), true);
            if ($json) {
                $name = $json['code'];
            }
        }
        return $name;

    }

    public static function voucher($id = false)
    {
        // voucher id kontrol.
        // status kontrol.
        $a = "";
        $b = "";
        $vouchers = Vouchers::find();
        if ($vouchers) {
            foreach ($vouchers as $vouchers) {
                $code = $vouchers->getCode();
                $user_id = Voucheruse::findFirst('voucher_id = ' . $vouchers->getId());
                if ($user_id) {
                    $json = json_decode($vouchers->getMetaValue(), true);
                    if ($user_id->count() <= $json['maximum_usage']) {
                        $user = $user_id->getUserId();
                        $table_user = User::findFirst('id=' . $user);
                        if ($table_user) {
                            if ($table_user->getId() === $user) {
                                $group = Usergroup::findFirst('id = ' . $table_user->getGroupId());
                                if ($group) {
                                    $group = $group->getId();
                                }

                                if ($json) {
                                    $discount = $json['discount'];
                                    $db_limit_of_per_person = $json['limit_of_per_person'];
                                    $limit_of_per_person = $db_limit_of_per_person - $user_id->getUseOf();

                                    $start = strtotime(date("d-m-Y", $json['start_date']));
                                    $end = strtotime(date("d-m-Y", $json['end_date']));
                                    $time = strtotime(date("d-m-Y", time()));

                                    if ($user === $id) {
                                        if ($json['limit_of_per_person'] > $user_id->getUseOf()) {
                                            if ($start <= $time && $end >= $time) {
                                                if ($vouchers->getStatus() === "1") {
                                                    if ($json['discount_type'] === "1") {
                                                        $discount = $discount . " TL";
                                                    } elseif ($json['discount_type'] === "2") {
                                                        $discount = "%" . $discount;
                                                    }

                                                    if ($json['voucher_type'] === "1") {
                                                        if ($json['voucher_value'][0] == !"0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        } elseif ($json['voucher_value'][0] === "0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        }
                                                    }

                                                    if ($json['voucher_type'] === "2") {
                                                        if ($json['voucher_value'][0] == !"0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        } elseif ($json['voucher_value'][0] === "0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        }
                                                    }

                                                    if ($json['voucher_type'] === "3") {
                                                        if ($json['voucher_value'][0] == !"0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        } elseif ($json['voucher_value'][0] === "0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        }
                                                    }

                                                    if ($json['voucher_type'] === "4") {
                                                        if ($json['voucher_value'][0] == !"0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        } elseif ($json['voucher_value'][0] === "0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        }
                                                    }

                                                    if ($json['voucher_type'] === "5") {
                                                        if ($json['voucher_value'][0] == !"0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        } elseif ($json['voucher_value'][0] === "0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        }
                                                    }


                                                    if ($json['voucher_type'] === "6") {
                                                        if ($json['voucher_value'][0] == !"0") {
                                                            $i = 0;
                                                            if ($group === $json['voucher_value'][$i]) {
                                                                $i++;
                                                                $a .= '<div class="frm_kutu">
                                                                            <div class="kpn">' . $code . '</div>
                                                                            <div class="kpn_bilgi">
                                                                                <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                                <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                            </div >
                                                                        </div > ';

                                                            }
                                                        } elseif ($json['voucher_value'][0] === "0") {
                                                            $a .= '<div class="frm_kutu">
                                                                        <div class="kpn">' . $code . '</div>
                                                                        <div class="kpn_bilgi">
                                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                                                        </div >
                                                                    </div > ';
                                                        }
                                                    }
                                                    // SAĞLANMIYORSA KOŞULLARI

                                                } elseif ($vouchers->getStatus() === "2") {
                                                    $a .= '<div class="frm_kutu">
                                                                <div class="kpn">' . $code . '</div>
                                                                <div class="kpn_bilgi">
                                                                    <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                                    <span><b>Bu Kupon Kullanıma Uygun Değildir!</b ></span >
                                                                </div >
                                                            </div > ';
                                                }
                                            }
                                        } elseif ($json['limit_of_per_person'] <= $user_id->getUseOf()) {
                                            $a .= '<div class="frm_kutu">
                                                        <div class="kpn">' . $code . '</div>
                                                        <div class="kpn_bilgi">
                                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                                            <span><b>Bu Kopunu Kullanma Hakkınız Bitmiştir. </b ></span >
                                                        </div >
                                                    </div > ';
                                        }
                                    }
                                }
                            }
                        }
                    }
                } elseif (!$user_id) {
                    $json = json_decode($vouchers->getMetaValue(), true);

                    if ($json) {
                        $discount = $json['discount'];
                        $limit_of_per_person = $json['limit_of_per_person'];
                        if ($json['discount_type'] === "1") {
                            $discount = $discount . " TL";
                        } elseif ($json['discount_type'] === "2") {
                            $discount = "%" . $discount;
                        }

                        if ($json['voucher_type'] === "1") {
                            if ($json['voucher_value'][0] == !"0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            } elseif ($json['voucher_value'][0] === "0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            }
                        }

                        if ($json['voucher_type'] === "2") {
                            if ($json['voucher_value'][0] == !"0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            } elseif ($json['voucher_value'][0] === "0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            }
                        }

                        if ($json['voucher_type'] === "3") {
                            if ($json['voucher_value'][0] == !"0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            } elseif ($json['voucher_value'][0] === "0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            }
                        }

                        if ($json['voucher_type'] === "4") {
                            if ($json['voucher_value'][0] == !"0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            } elseif ($json['voucher_value'][0] === "0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            }
                        }

                        if ($json['voucher_type'] === "5") {
                            if ($json['voucher_value'][0] == !"0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            } elseif ($json['voucher_value'] === "0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            }
                        }

                        if ($json['voucher_type'] === "6") {
                            if ($json['voucher_value'][0] == !"0") {
                                $user = User::findFirst($id);
                                if ($user) {
                                    $group = Usergroup::findFirst($user->getGroupId());
                                    if ($group) {
                                        $re = false;
                                        foreach ($json['voucher_value'] as $item) {
                                            if ($item == $group->getId()) {
                                                $re = true;
                                            }
                                        }

                                        if ($re == true) {
                                            $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                                        }
                                    }
                                }
                            } elseif ($json['voucher_value'][0] === "0") {
                                $a .= '<div class="frm_kutu">
                                        <div class="kpn">' . $code . '</div>
                                        <div class="kpn_bilgi">
                                            <span>Seçtiğiniz ürünlerde <b>' . $discount . '</b> indirim hakkı.</span>
                                            <span>Bu Kuponu <b>' . $limit_of_per_person . ' </b > defa kullanma hakkınız var.</span >
                                        </div >
                                    </div > ';
                            }
                        }
                    }
                }
            }
        }
        return $a;
    }

    public static function sepetVoucher($id)
    {
        $durum = "false";
        if (is_numeric($id)) {
            $shop = Shopcart::find("user_id=" . $id);
            if ($shop->count()>0) {
                foreach ($shop as $shop) {
                    if ($shop->getVoucher() != null) {
                        $durum = "true";

                    }
                }
            } else {
                $durum = "true";
            }
        } else {
            $durum = "session";
        }
        return $durum;
    }

    public static function contentbycatid($id) {
        if (is_numeric($id)) {
            $content = Content::find('content_cat_id='.$id);
            if ($content) {
                return $content;
            }
        }
    }

    public static function contentgallery($id) {
        if (is_numeric($id)) {
            $images = Images::find('content_id='.$id.' and meta_key="content" and status=1');
            if ($images) {
                return $images;
            }
        }
    }

    public static function  variant($id){
        $ad="";
        $variantAna=Productvariant::findFirst("pro_id=".$id);
        if ($variantAna){
            $var=explode(",",$variantAna->getVariantId());
            $variantTamamai=Productvariant::find("pro_id=".$id);
            $arr=array();
            $ad="";
            foreach ($var as $var){
                $variant=Variant::findFirst("id=".$var);
                $variant2=Variant::findFirst("id=".$variant->getTopId());
                $ad.= '<select id="varyant_'.$variant2->getId().'" class="varyant"><option>'.$variant2->getName().'</option>';
                foreach ($variantTamamai as $value){
                    if ($value->getStock()>0){
                        $var2=explode(",",$value->getVariantId());
                        foreach ($var2 as $var2){
                            $variant3=Variant::findFirst("id=".$var2);
                            $variant4=Variant::findFirst("id=".$variant3->getTopId());
                            if ($variant4->getId()==$variant2->getId()){
                                if (!empty($arr)){
                                    if (!in_array($variant3->getId(),$arr)){
                                        $ad.= '<option value="'.$variant3->getId().'">'.$variant3->getName().'</option>';
                                    }
                                }else{
                                    $ad.= '<option value="'.$variant3->getId().'">'.$variant3->getName().'</option>';
                                }
                                $arr[].=$variant3->getId();
                            }
                        }
                    }

                }
                $ad.="</select>";
            }



            return $ad;
        }


    }

    public static function sepetVariant($id){
            $variant="";
            $sepet=Shopcart::findFirst($id);

                if ($sepet->getMetaValue()!=null){
                    $meta_key=explode(",",$sepet->getMetaValue());
                    foreach ($meta_key as $meta_key){
                        $variantName=Variant::findFirst("id=".$meta_key);
                        $variantAna=Variant::findFirst($variantName->getTopId());
                        $variant.='<span>'.$variantAna->getName().':'.$variantName->getName().'</span>';
                    }
                }
                else{
                    $variant='<span></span>';
                }
            return $variant;
        }

    public static function sepetStock($id){
       $shop=Shopcart::findFirst($id);
       if ($shop){
           $variant=$shop->getMetaValue();
           $productVariant=Productvariant::findFirst("pro_id=".$shop->getProId()." and variant_id="."'$variant'");
           if ($productVariant){
               return $productVariant->getStock();
           }
           else {
               $product=Product::findFirst($shop->getProId());
               return $product->getUnit();
           }
       }

    }

    public static function indirim($id){
        $shop=Shopcart::find("user_id=".$id);
        $toplam=0;
        foreach ($shop as $shopcart){
            if ($shopcart->getVoucher()!=null){
                $prodcut=Product::findFirst($shopcart->getProId());
                $parse = json_decode($shopcart->getVoucher(), true);
                if ($shopcart->getMetaValue()!==null){
                    if ($parse['discount_type']==1){
                        $toplam+=($parse['discount']*$shopcart->getPiece());
                    }else if($parse['discount_type']==2){
                        $sale_price = self::totalpriceVocuher($shopcart->getProId(),$shopcart->getMetaValue()) ;
                        $total_price = ($sale_price* $parse['discount']*$shopcart->getPiece()) / 100;
                        $toplam+=round($total_price,2);

                    }
                }else{
                    if ($parse['discount_type']==1){
                        $toplam+=($parse['discount']*$shopcart->getPiece());
                    }else if($parse['discount_type']==2){
                        $sale_price = self::totalpriceVocuher($shopcart->getProId()) ;
                        $total_price = ($sale_price* $parse['discount']*$shopcart->getPiece()) / 100;
                        $toplam+=round($total_price,2);
                    }
                }

            }
        }
          return preg_replace('/[^0-9,"."]/', '', $toplam) . ' ' . (new Functions)->saleRate($prodcut->getSaleRate());
    }
    public  static function totalpriceVocuher($id,$variant=false) {
        if (is_numeric($id)) {
            if ($variant!=null){
                $pro = Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variant'");
                $product = Product::findFirst($id);
                if ($pro) {
                    $sale_price     = $pro->getSalePrice();
                    $discount_type  = $product->getDiscountType();
                    $discount_rate  = $product->getDiscountRate();
                    $total_price    = 0;

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate   = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    return $total_price;
                }
            }else{
                $pro = Product::findFirst($id);

                if ($pro) {
                    $sale_price     = $pro->getSalePrice();
                    $discount_type  = $pro->getDiscountType();
                    $discount_rate  = $pro->getDiscountRate();
                    $total_price    = 0;

                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate   = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    return $total_price;
                }
            }

        }
    }
    public static function sepettoplam($id, $price = false)
    {
        if (isset($_COOKIE['auth'])) {
            $toplam_fiyat = 0;
            $total = Shopcart::find("user_id=" . $id);
            foreach ($total as $total) {
                if ($total->getVoucher() == null) {
                    $toplam_fiyat += self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                } else if ($total->getVoucher() != null) {
                    $parse = json_decode($total->getVoucher(), true);
                    $sale_price = self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                    $discount_type = $parse['discount_type'];
                    $discount_rate = $parse['discount'];
                    $total_price = 0;
                    if ($discount_type == 1) {
                        $total_price = $sale_price - ($discount_rate * $total->getPiece());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    $toplam_fiyat += $total_price;
                }
            }
            if ($price == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        } else {
            $toplam_fiyat = 0;
            $total = Shopcart::find("session_id=" . "'$id'");
            foreach ($total as $total) {
                if ($total->getVoucher() == null) {
                    $toplam_fiyat += self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                } else if ($total->getVoucher() != null) {
                    $parse = json_decode($total->getVoucher(), true);
                    $sale_price = self::totalpriceVocuher($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                    $discount_type = $parse['discount_type'];
                    $discount_rate = $parse['discount'];
                    $total_price = 0;
                    if ($discount_type == 1) {
                        $total_price = $sale_price - ($discount_rate * $total->getPiece());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    $toplam_fiyat += $total_price;
                }
            }
            if ($price == false) {
                return self::pricesepet($toplam_fiyat, $total->getProId());
            } else {
                return $toplam_fiyat;
            }
        }
    }

    /* ilişkili ürünler frontend */
    public static function getRelatedPro($id = false) {
        if (is_numeric($id)) {
            $related = Relation::find('top_id='.$id);
            if (count($related) > 0) {
                $respond = '<div class="urn_alternatif"><h4>İlişkili Ürünler</h4><ul>';
                foreach ($related as $item) {
                    $pro = Product::findFirst($item->getProId());
                    if ($pro) {
                        $respond .= '<li><a href="urun/'.$pro->getSef().'"><img src="media/product/'.self::productImage($pro->getId()).'" alt=""><span>'.$pro->getName().'</span><span>'.self::totalprice($pro->getId()).'</span></a></li>';
                    }
                }
                $respond .= '</ul></div>';
                return $respond;
            }
        }
    }

    /* hediye ürünler frontend */
    public static function getGiftPro($id = false) {
        if (is_numeric($id)) {
            $gift = Product::findFirst($id);
            if ($gift) {
                $gifts = $gift->getGift();
                if ($gifts) {
                    $gifts = explode(',', $gifts);
                    $respond = '<div class="urn_alternatif hediye"><h4>Hediye Ürünler</h4><ul>';
                    foreach ($gifts as $item) {
                        $pros = Product::findFirst($item);
                        if ($pros) {
                            $respond .= '<li><a href="urun/'.$pros->getSef().'"><img src="media/product/'.self::productImage($pros->getId()).'" alt="'.$pros->getName().'"><span>'.$pros->getName().'</span></a></li>';
                        }
                    }
                    $respond .= '</ul></div>';
                    return $respond;
                }
            }
        }
    }

    /* tavsiye ürünler frontend */
    public static function getRecommendetPro($id = false) {
        if (is_numeric($id)) {
            $recom = Product::findFirst($id);
            if ($recom) {
                $recommendet = $recom->getRecommendedProducts();
                if ($recommendet) {
                    $parse = explode(',', $recommendet);
                    $respond = '<div class="urn_alternatif hediye"><h4>Tavsiye Ürünler</h4><ul>';
                    foreach ($parse as $item) {
                        $pros = Product::findFirst($item);
                        if ($pros) {
                            $respond .= '<li><a href="urun/'.$pros->getSef().'"><img src="media/product/'.self::productImage($pros->getId()).'" alt="'.$pros->getName().'"><span>'.$pros->getName().'</span></a></li>';
                        }
                    }
                    $respond .= '</ul></div>';
                    return $respond;
                }
            }
        }
    }
    public  static  function  hediye($id){
        $product=Product::findFirst($id);
        if ($product->getGift()!=null) {
            $gift=explode(",",$product->getGift());
        }

        $span="";
        if (isset($gift)){
            foreach ($gift as $item){
                $id= Product::findFirst($item);
                $span.='<span>Hediye ürün: '.$id->getName().'</span> <br>';

            }
        }


        return $span;

    }

    public static function cargocity($cityId,$townId ){
        $return="false";
        $cargocity=Cargocity::findFirst("city_id=".$cityId);
        if ($cargocity){
            if ($cargocity->getTownId()==0){
                $return= "true";
            }else{
                $town=explode(",",$cargocity->getTownId());
                foreach ($town as $town){
                    if ($town==$townId){
                        $return= "true";
                    }
                }
            }
        }
        return $return;
    }

    public static function havalekontrol($id){
        $kontrol="false";
        if (isset($_COOKIE['auth'])) {
            $shop=Shopcart::find("user_id=".$id);
            if ($shop->count()>0){
                foreach ($shop as $shop){
                    $product=Product::findFirst($shop->getProId());
                    if ($product->getTransferDiscount() !=0){
                        $kontrol="true";
                    }
                }
            }
        }
        else{
            $shop=Shopcart::find("session_id="."'$id'");
            if ($shop->count()>0){
                foreach ($shop as $shop){
                    $product=Product::findFirst($shop->getProId());
                    if ($product->getTransferDiscount() !=0){
                        $kontrol="true";
                    }
                }
            }
        }
        return $kontrol;
    }

    public static function havaletoplam($id, $price = false)
    {
        if (isset($_COOKIE['auth'])) {
            $toplam_fiyat = 0;
            $total = Shopcart::find("user_id=" . $id);
            foreach ($total as $total) {
                if ($total->getVoucher() == null) {
                    $toplam_fiyat += self::totalpriceHavale($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                } else if ($total->getVoucher() != null) {
                    $parse = json_decode($total->getVoucher(), true);
                    $sale_price = self::totalpriceHavale($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                    $discount_type = $parse['discount_type'];
                    $discount_rate = $parse['discount'];
                    $total_price = 0;
                    if ($discount_type == 1) {
                        $total_price = $sale_price - ($discount_rate * $total->getPiece());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    $toplam_fiyat += $total_price;
                }
            }

            return $toplam_fiyat;

        } else {
            $toplam_fiyat = 0;
            $total = Shopcart::find("session_id=" . "'$id'");
            foreach ($total as $total) {
                if ($total->getVoucher() == null) {
                    $toplam_fiyat += self::totalpriceHavale($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                } else if ($total->getVoucher() != null) {
                    $parse = json_decode($total->getVoucher(), true);
                    $sale_price = self::totalpriceHavale($total->getProId(), $total->getMetaValue()) * $total->getPiece();
                    $discount_type = $parse['discount_type'];
                    $discount_rate = $parse['discount'];
                    $total_price = 0;
                    if ($discount_type == 1) {
                        $total_price = $sale_price - ($discount_rate * $total->getPiece());
                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                    }
                    $toplam_fiyat += $total_price;
                }
            }

            return $toplam_fiyat;

        }
    }

    public  static function totalpriceHavale($id,$variant=false) {
        if (is_numeric($id)) {
            if ($variant!=null){
                $pro = Productvariant::findFirst("pro_id=".$id." and variant_id="."'$variant'");
                $product = Product::findFirst($id);
                if ($pro) {
                    $sale_price     = $pro->getSalePrice();
                    $discount_type  = $product->getDiscountType();
                    $discount_rate  = $product->getDiscountRate();
                    $total_price    = 0;
                    if ($product->getTransferDiscount()!=0){
                        $sale_price = $sale_price-$product->getTransferDiscount();
                    }
                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate   = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        if ($product->getTransferDiscount()!=0){
                            $total_price = $sale_price - $total_price-$product->getTransferDiscount();
                        }else{
                            $total_price = $sale_price - $total_price;
                        }

                    }
                    return $total_price;
                }
            }else{
                $pro = Product::findFirst($id);

                if ($pro) {
                    $sale_price     = $pro->getSalePrice();
                    $discount_type  = $pro->getDiscountType();
                    $discount_rate  = $pro->getDiscountRate();
                    $total_price    = 0;
                    if ($pro->getTransferDiscount()!=0){
                        $sale_price = $sale_price-$pro->getTransferDiscount();
                    }
                    if ($discount_type == 1) {
                        // fiyat
                        $clean_rate   = number_format((float)$discount_rate, 2);
                        $total_price = (new Functions)->decimalAdd($sale_price, $clean_rate, 2);

                    } else if ($discount_type == 2) {
                        // yüzde
                        $total_price = ($sale_price * $discount_rate) / 100;
                        $total_price = $sale_price - $total_price;
                        if ($pro->getTransferDiscount()!=0){
                            $total_price = $sale_price - $total_price-$pro->getTransferDiscount();
                        }else{
                            $total_price = $sale_price - $total_price;
                        }
                    }
                    return $total_price;
                }
            }

        }
    }
}
