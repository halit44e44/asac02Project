<?php
declare(strict_types=1);

namespace Yabasi\Api\Controllers;

use DateInterval;
use DatePeriod;
use DateTime;
use Yabasi\Order;
use Yabasi\Product;
use Yabasi\Statisticpro;
use Yabasi\User;
use Yabasi\Usergroup;

class V3Controller extends ControllerBase {

    public function initialize() {
        $this->isAuth();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    }

    public function indexAction() {
        echo json_encode(array('code' => 200, 'message' => 'Auth is required!'));
    }

    public function getAction($table = false, $id = false) {
        if (!$table) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }
        $tables = array(
            'user',
            'product',
            'order',
            'vizor',
            'vizoruser',
            'pro',
            'users',
            'products',
            'prouser'
        );
        if (in_array($table, $tables)) {
            if ($table == 'user') {
                echo "Name,Count\n";
                $list = Order::find(array('order' => 'created_at DESC', 'conditions' => 'meta_key="order"',));

                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $parse = json_decode($list->getMetaValue(), true);
                        $user = User::findFirst($list->getUserId());
                        if ($user) {
                            $arr[] = array(
                                'user_name' => $user->getName(),
                                'user' => $user->getName(),
                            );
                        }
                        // asort($arr);
                    }
                    if (!empty($arr)) {
                        $result = array();
                        foreach ($arr as $element) {
                            $result[$element['user_name']][] = '' . $element['user'] . '';
                        }
                    }
                    $newArray = array_slice($result, 0, 10, true);
                    foreach ($newArray as $key => $value) {
                        $counts = array_count_values($result[$key]);
                        echo $key . "," . count($value) . "\n";
                    }
                }
            }
            if ($table == 'product') {
                // echo "Name,Count\n";
                $list = Order::find(array('order' => 'created_at DESC', 'conditions' => 'meta_key="products"'));
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $parse = json_decode($list->getMetaValue(), true);
                        $product = Product::findFirst($parse['id']);
                        $user = User::findFirst($list->getUserId());
                        $arr[] = array(
                            'proId' => $product->getId(),
                            'product' => $product->getName(),
                            'user' => $product->getName(),
                        );
                    }
                    $result = array();
                    foreach ($arr as $element) {
                        $result[$element['proId']][] = '' . $element['product'] . '';

                    }
                    $result2 = array();
                    foreach ($result as $key => $value) {
                        $result2[] = array(
                            'count' => count($value),
                            'pro' => $key,
                        );
                    }
                    $i = 0;
                    rsort($result2);
                    $arrUser = array();
                    $result4 = array();
                    foreach ($result2 as $item) {
                        if (count($result2) > 5) {
                            // echo $i."\n";
                            if ($i < 5) {
                                $i++;
                                $order = Order::find('meta_key="products"');
                                foreach ($order as $orders) {
                                    $meta_key = json_decode($orders->getMetaValue(), true);
                                    if ($meta_key['id'] == $item['pro']) {
                                        $arrUser[] = array(
                                            'user' => $orders->getUserId(),
                                            'product' => $meta_key['id'],
                                        );
                                    }
                                }

                            }
                        } else {
                            $order = Order::find('meta_key="products"');
                            foreach ($order as $orders) {
                                $meta_key = json_decode($orders->getMetaValue(), true);
                                if ($meta_key['id'] == $item['pro']) {
                                    $arrUser[] = array(
                                        'user' => $orders->getUserId(),
                                        'product' => $meta_key['id'],
                                    );
                                }
                            }

                        }
                    }
                    foreach ($arrUser as $element2) {
                        $result4['' . $element2['product'] . ''][] = '' . $element2['user'] . '';
                    }
                    $j = 0;
                    foreach ($result4 as $key => $value) {
                        $j++;
                        if ($j <= 3) {
                            $counts = array_count_values($result4[$key]);
                            reset($counts);
                            arsort($counts);
                            $newArray = array_slice($counts, 0, 1, true);
                            $result8[] = array(
                                'user' => $newArray,
                                'pro' => $key,
                            );

                        }
                    }
                }
                $d = json_decode(json_encode($result8), true);
                echo json_encode($d);
                $yeni = array();
                foreach ($d as $a) {
                    foreach ($a['user'] as $isos => $key) {
                        array_push($yeni, $isos);
                        // echo "$key" . " " . $isos . " " . " " . $a['pro'] . "\n";
                        $statisticpro = new Statisticpro();
                        $statisticpro->setUserId($isos);
                        $statisticpro->setProId($a['pro']);
                        $statisticpro->setCount($key);
                        $statisticpro->setCreatedAt(time());
                        $statisticpro->setUpdatedAt(time());
                        $statisticpro->setStatus("1");
                        $statisticpro->save();
                    }
                }
            }
            else if ($table == "vizor") {
                echo "category,first,second\n";
                for($i=0; $i<6; $i++){
                    $last_week_dates[] = date('Y-m-d', strtotime('last day -'.$i.'day'));
                }

                /* user işlemler başlar*/
                $user = User::find(array(
                    'conditions' => 'created_at BETWEEN ?1 AND ?2', 'order' => 'created_at DESC',
                    'bind' => array(
                        1 => strtotime(date("m/d/Y", strtotime("last week"))),
                        2 => time()
                    )));
                if ($user) {
                    foreach ($user as $item) {
                        $name = $item->getName();

                        $arruser[] = array(
                            'name' => $name,
                            'created_at' => date('Y-m-d', (int)$item->getCreatedAt()),
                        );

                    }
                    $resultuser = array();
                    if (!empty($arruser)) {
                        foreach ($arruser as $element) {
                            $resultuser[$element['created_at']][] = '' . $element['name'] . '';
                        }
                    }
                    if (!empty($resultuser)) {
                        foreach ($resultuser as $key => $value) {
                            $day = date('w', strtotime($key));
                            if ($day == 0) {
                                $day = "7";
                            }
                            $arr2user[] = array($day => count($value),);
                        }
                    }
                }
                /* user işlemler biter*/
                $order = Order::find(array(
                    'conditions' => 'meta_key="order" and created_at BETWEEN ?1 AND ?2', 'order' => 'created_at Desc',
                    'bind' => array(
                        1 => strtotime(date("m/d/Y", strtotime("-6 day"))),
                        2 => time()
                    )));
                if ($order) {
                    $total_earnings = 0;
                    $currency = "TL";
                    foreach ($order as $item) {
                        $total_price = $item->getTotalPrice();

                        $arrorder[] = array(
                            'total_price' => $total_price,
                            'created_at' => date('Y-m-d', (int)$item->getCreatedAt()),
                            'days' => date('w', (int)$item->getCreatedAt())
                        );

                    }
                    if (!empty($arrorder)) {
                        foreach ($arrorder as $element) {
                            $resultorder[$element['created_at']][] = '' . $element['total_price'] . '';
                        }
                    }
                    // arsort($resultorder);

                    $i = 0;
                    //echo json_encode($resultorder);
                    foreach ($last_week_dates as $a){
                        if (!empty($arrorder)) {
                            foreach ($resultorder as $key => $value) {
                                $i++;
                                $day = date('w', strtotime($key));
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
                                $usercount = 0;
                                if (isset($resultuser[$a])) {
                                    $usercount = count($resultuser[$a]);;
                                }
                                echo $day . "," . count($value) . "," . $usercount . "\n";
                            }
                        }
                    }

                }
            }
            else if ($table == 'order') {
                echo "Date,Open,High,Low,Close,Volume\n";
                $orders = "order";
                $list = Order::find(array('order' => 'created_at DESC', 'conditions' => 'meta_key="order"'));
                if ($list->count() != 0) {
                    foreach ($list as $order) {
                        if ($order->getOrderStatus() == 1 || $order->getOrderStatus() == 2 || $order->getOrderStatus() == 3 ||
                            $order->getOrderStatus() == 4 || $order->getOrderStatus() == 5 || $order->getOrderStatus() == 6 || $order->getOrderStatus() == 7
                            || $order->getOrderStatus() == 8 || $order->getOrderStatus() == 16
                        ) {
                            $total_price = $order->getTotalPrice();
                            $arr[] = array(
                                'total_price' => $total_price,
                                'created_at' => date('Y-m-d', (int)$order->getCreatedAt()),
                            );
                        }
                        else if ($order->getOrderStatus() == 9) {
                            $arr[] = array('total_price' => "order_iptal",
                                'created_at' => date('Y-m-d', (int)$order->getCreatedAt()),);

                        }
                        else if ($order->getOrderStatus() == 10 || $order->getOrderStatus() == 11 ||
                            $order->getOrderStatus() == 12 || $order->getOrderStatus() == 13 || $order->getOrderStatus() == 14
                            || $order->getOrderStatus() == 15 || $order->getOrderStatus() == 17 || $order->getOrderStatus() == 18 || $order->getOrderStatus() == 19) {
                            $arr[] = array('total_price' => "order_iade",
                                'created_at' => date('Y-m-d', (int)$order->getCreatedAt()),);
                        }
                    }
                    $result = array();
                    foreach ($arr as $element) {
                        $result[$element['created_at']][] = '' . $element['total_price'] . '';
                    }
                    foreach ($result as $key => $value) {
                        $counts = array_count_values($result[$key]);
                        if (isset($counts["order_iade"]) && isset($counts["order_iptal"])) {
                            $net_order = count($value) - ($counts["order_iade"]) - ($counts["order_iptal"]);
                            echo $key . "," . $net_order . "," . count($value) . "," . $counts["order_iade"] . "," . $counts["order_iptal"] . "," . array_sum($value) . "\n";
                        } else if (isset($counts["order_iade"]) || isset($counts["order_iptal"])) {
                            if (isset($counts["order_iade"])) {
                                $net_order = count($value) - ($counts["order_iade"]);
                                echo $key . "," . $net_order . "," . count($value) . "," . $counts["order_iade"] . ",0," . array_sum($value) . "\n";
                            }
                            if (isset($counts['order_iptal'])) {
                                $net_order = count($value) - ($counts["order_iptal"]);
                                echo $key . "," . $net_order . "," . count($value) . ",0," . $counts["order_iptal"] . "," . array_sum($value) . "\n";
                            }
                        } else {
                            echo $key . "," . count($value) . "," . count($value) . ",0,0," . array_sum($value) . "\n";
                        }
                    }
                }
            }
            if ($table == 'pro') {
                echo "moon,piece,price" . "\n";
                $list = Statisticpro::findFirst(array('order' => 'count DESC'));
                $product = Order::find(array(
                    'conditions' => 'created_at BETWEEN ?1 AND ?2 and meta_key="products"', 'order' => 'created_at DESC',
                    'bind' => array(
                        1 => strtotime(date("m/d/Y", strtotime("last year"))),
                        2 => time()
                    )));
                foreach ($product as $product) {
                    if ($product->getOrderStatus() == 1 || $product->getOrderStatus() == 2 || $product->getOrderStatus() == 3 ||
                        $product->getOrderStatus() == 4 || $product->getOrderStatus() == 5 || $product->getOrderStatus() == 6 || $product->getOrderStatus() == 7
                        || $product->getOrderStatus() == 8 || $product->getOrderStatus() == 16) {
                        $moon = date('M', (int)$product->getCreatedAt());
                        if ($moon == "Oct") {
                            $moon = "Ekim";
                        }
                        if ($moon == "Sep") {
                            $moon = "Eylül";
                        }
                        if ($moon == "Aug") {
                            $moon = "Ağustos";
                        }
                        if ($moon == "Jul") {
                            $moon = "Temmuz";
                        }
                        if ($moon == "Jun") {
                            $moon = "Haziran";
                        }
                        if ($moon == "May") {
                            $moon = "Mayıs";
                        }
                        if ($moon == "Apr") {
                            $moon = "Nisan";
                        }
                        if ($moon == "Mar") {
                            $moon = "Mart";
                        }
                        if ($moon == "Feb") {
                            $moon = "Şubat";
                        }
                        if ($moon == "Jan") {
                            $moon = "Ocak";
                        }
                        if ($moon == "Dec") {
                            $moon = "Aralık";
                        }
                        if ($moon == "Nov") {
                            $moon = "Kasım";
                        }
                        $arr[] = array(
                            'ay' => $moon,
                            'price' => $product->getTotalPrice()
                        );
                    }
                }
                $result = array();
                if (!empty($arr)) {
                    foreach ($arr as $element) {
                        $result[$element['ay']][] = '' . $element['price'] . '';
                    }
                }
                if (!empty($result)) {
                    foreach ($result as $key => $value) {
                        echo $key . "," . count($value) . "," . array_sum($value) . "\n";
                    }
                }
            }
            if ($table == 'users') {
                echo "Date,Count\n";
                $user = User::find(array('order' => 'created_at DESC'));
                if ($user) {
                    foreach ($user as $item) {
                        $name = $item->getGroupId();
                        $arruser[] = array(
                            'name' => $name,
                            'created_at' => date('Y-m-d', (int)$item->getCreatedAt()),);
                    }
                    $resultuser = array();
                    if (!empty($arruser)) {
                        foreach ($arruser as $element) {
                            $resultuser[$element['created_at']][] = '' . $element['name'] . '';
                        }
                    }
                    if (!empty($resultuser)) {
                        foreach ($resultuser as $key => $value) {
                            $group = Usergroup::findFirst($value);
                            echo $key . "," . count($value) . "\n";
                        }
                    }
                }
            }
            if ($table == 'products') {
                echo "date,piece,price" . "\n";
                if ($id) {
                    if (is_numeric($id)){
                        $product = Order::find(array('conditions' => 'meta_key="products"', 'order' => 'created_at DESC',
                        ));
                        foreach ($product as $product) {
                            $parse = json_decode($product->getMetaValue(), true);
                            if ($parse['id']==$id){
                                if ($product->getOrderStatus() == 1 || $product->getOrderStatus() == 2 || $product->getOrderStatus() == 3 ||
                                    $product->getOrderStatus() == 4 || $product->getOrderStatus() == 5 || $product->getOrderStatus() == 6 || $product->getOrderStatus() == 7
                                    || $product->getOrderStatus() == 8 || $product->getOrderStatus() == 16) {
                                    $moon = date('Y-m-d', (int)$product->getCreatedAt());
                                    $arr[] = array(
                                        'ay' => $moon,
                                        'price' => $product->getTotalPrice()
                                    );
                                }
                            }
                        }
                        $result = array();
                        if (!empty($arr)) {
                            foreach ($arr as $element) {
                                $result[$element['ay']][] = '' . $element['price'] . '';
                            }
                        }
                        if (!empty($result)) {
                            foreach ($result as $key => $value) {
                                echo $key . "," . count($value) . "," . array_sum($value) . "\n";
                            }
                        }
                    }
                }else{
                    $product = Order::find(array('conditions' => 'meta_key="products"', 'order' => 'created_at DESC'));
                    $list = Statisticpro::findFirst(array('order' => 'count DESC'));
                    if ($list) {
                        foreach ($product as $product) {
                            $parse = json_decode($product->getMetaValue(), true);
                            if ($parse['id']==$list->getProId()){
                                if ($product->getOrderStatus() == 1 || $product->getOrderStatus() == 2 || $product->getOrderStatus() == 3 ||
                                    $product->getOrderStatus() == 4 || $product->getOrderStatus() == 5 || $product->getOrderStatus() == 6 || $product->getOrderStatus() == 7
                                    || $product->getOrderStatus() == 8 || $product->getOrderStatus() == 16) {
                                    $moon = date('Y-m-d', (int)$product->getCreatedAt());
                                    $arr[] = array(
                                        'ay' => $moon,
                                        'price' => $product->getTotalPrice()
                                    );
                                }
                            }

                        }
                        $result = array();
                        if (!empty($arr)) {
                            foreach ($arr as $element) {
                                $result[$element['ay']][] = '' . $element['price'] . '';
                            }
                        }
                        if (!empty($result)) {
                            foreach ($result as $key => $value) {
                                echo $key . "," . count($value) . "," . array_sum($value) . "\n";
                            }
                        }
                    }

                }
            }
        }
        else {
            echo json_encode(array('code' => 404, 'message' => 'incorrect parameter!'));
            die();
        }
    }

}

