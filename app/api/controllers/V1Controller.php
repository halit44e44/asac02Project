<?php
declare(strict_types=1);

namespace Yabasi\Api\Controllers;

use DateInterval;
use DatePeriod;
use DateTime;
use Yabasi\Order;
use Yabasi\Product;

class V1Controller extends ControllerBase {

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
            'address',
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
            'product',
            'order',
            'test'
        );
        if (in_array($table, $tables)) {

            if ($table == 'address') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'user_id='.$id;
                }

                $list = self::db('address')::find($param);

                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'user_id' => $list->user_id,
                            'country_id' => $list->country_id,
                            'city_id' => $list->city_id,
                            'district_id' => $list->dist_id,
                            'name' => $list->name,
                            'user_info' => $list->user_info,
                            'phone' => $list->phone,
                            'address' => $list->address,
                            'zip_code' => $list->zip_code,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }

            } else if ($table == 'bank') {
                $list = self::db('bank')::find();
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'name' => $list->name,
                            'content' => $list->content,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'content') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'content_cat_id='.$id;
                }
                $list = self::db('content')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr = array(
                            'id' => (int) $list->id,
                            'user_id' => (int) $list->user_id,
                            'cat_id' => (int) $list->cat_id,
                            'content_cat_id' => (int) $list->content_cat_id,
                            'sef' => $list->sef,
                            'redirect_url' => $list->redirect_url,
                            'name' => $list->name,
                            'short_content' => $list->short_content,
                            'content' => $list->content,
                            'description' => $list->description,
                            'images' => $list->images,
                            'created_at' => (int) $list->created_at,
                            'updated_at' => (int) $list->updated_at,
                            'status' => (int) $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'order') {
                $param = '';
                if (is_numeric($id)) {
                    $param ='top_id='.$id;
                }
                $list = self::db('contentcats')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => (int) $list->id,
                            'user_id' => (int) $list->user_id,
                            'top_id' => (int) $list->top_id,
                            'sef' => $list->sef,
                            'description' => $list->description,
                            'name' => $list->name,
                            'content' => $list->content,
                            'images' => $list->images,
                            'created_at' => (int) $list->created_at,
                            'updated_at' => (int) $list->updated_at,
                            'status' => (int) $list->status
                        );
                    }

                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            }
            else if ($table == 'test') {

                $ordered=Order::find((array('group' => 'pro_id','conditions' => 'meta_key="products"')));
                    foreach ($ordered as $orders){
                        $orderpro=Order::find('meta_key="products" and pro_id='.$orders->getProId());
                        $arr[]=array("count"=>$orderpro->count(),'id'=>$orders->getProId());
                        arsort($arr);

                    }
                    print_r($arr);
                foreach ($arr as $arr){
                    $list = Product::find("id=".$arr['id']);
                    foreach ($list as $list){
                        echo $list->getId();
                    }
                }






            }

            else if ($table == 'district') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'town_id='.$id;
                }
                $list = self::db('district')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => (int) $list->id,
                            'town_id' => $list->town_id,
                            'name' => $list->name,
                            'created_at' => (int) $list->created_at,
                            'updated_at' => (int) $list->updated_at,
                            'status' => (int) $list->status
                        );
                    }

                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'cargo') {
                $list = self::db('cargo')::find();
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => (int) $list->id,
                            'name' => $list->name,
                            'content' => $list->content,
                            'price' => $list->price,
                            'created_at' => (int) $list->created_at,
                            'updated_at' => (int) $list->updated_at,
                            'status' => (int) $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'cats') {
                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=' . $id;
                }

                $list = self::db('cats')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $total_subcat = self::db("cats")::count('top_id='.$list->id);

                        $arr[] =$list->id;
                    }
                    echo json_encode($arr);
                }

            }else if ($table == 'user') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'group_id='.$id;
                }

                $list = self::db('user')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'group_id' => $list->group_id,
                            'email' => $list->email,
                            'name' => $list->name,
                            'phone' => $list->phone,
                            'id_no' => $list->id_no,
                            'birth_date' => $list->birth_date,
                            'gender' => $list->gender,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );

                        echo json_encode($arr);
                    }
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'usergroup') {
                $list = self::db('usergroup')::find();
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'name' => $list->name,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'quarter') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'district_id='.$id;
                }

                $list = self::db('quarter')::find();
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'district_id' => $list->district_id,
                            'name' => $list->name,
                            'zip_code' => $list->zip_code,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'brand') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'user_id='.$id;
                }

                $list = self::db('brand')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'user_id' => $list->user_id,
                            'sef' => $list->sef,
                            'description' => $list->description,
                            'name' => $list->name,
                            'content' => $list->content,
                            'image' => $list->image,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'pnotification') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'user_id='.$id;
                }
                $list = self::db('pnotification')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'user_id' => $list->user_id,
                            'order_id' => $list->order_id,
                            'bank_id' => $list->bank_id,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'feature') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'top_id='.$id;
                }
                $list = self::db('feature')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'top_id' => $list->top_id,
                            'name' => $list->name,
                            'image' => $list->image,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'city') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'country_id='.$id;
                }
                $list = self::db('city')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'country_id' => $list->country_id,
                            'name' => $list->name,
                            'area_code' => $list->area_code,
                            'plaque' => $list->plaque,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'town') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'city_id='.$id;
                }
                $list = self::db('town')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'city_id' => $list->city_id,
                            'name' => $list->name,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'country') {
                $list = self::db('country')::find();
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'binary_code' => $list->binary_code,
                            'triple_code' => $list->triple_code,
                            'name' => $list->name,
                            'country_code' => $list->country_code,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'variant') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'top_id='.$id;
                }
                $list = self::db('variant')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'top_id' => $list->top_id,
                            'name' => $list->name,
                            'image' => $list->image,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'comment') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'pro_id='.$id;
                }
                $list = self::db('comment')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'pro_id' => $list->pro_id,
                            'user_id' => $list->user_id,
                            'comment' => $list->comment,
                            'point' => $list->point,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            } else if ($table == 'product') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'cat_id='.$id;
                }

                $list = self::db('product')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'cat_id' => $list->cat_id,
                            'cats_id' => $list->cats_id,
                            'brand_id' => $list->brand_id,
                            'user_id' => $list->user_id,
                            'variant_id' => $list->variant_id,
                            'feature_id' => $list->feature_id,
                            'description' => $list->description,
                            'name' => $list->name,
                            'content' => $list->content,
                            'short_content' => $list->short_content,
                            'sef' => $list->sef,
                            'image' => $list->image,
                            'price' => $list->price,
                            'barcode' => $list->barcode,
                            'stock' => $list->stock,
                            'stock_code' => $list->stock_code,
                            'unit' => $list->unit,
                            'offer' => $list->offer,
                            'gift' => $list->gift,
                            'warranty' => $list->warranty,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                    echo json_encode($arr);
                } else {
                    echo json_encode(array('code' => 404, 'message' => 'doesn\'t find'));
                }
            }
        } else {
            echo json_encode(array('code' => 404, 'message' => 'incorrect parameter!'));
            die();
        }
    }
}