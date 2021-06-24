<?php

namespace Yabasi\Api\Controllers;

use Yabasi\Bank;
use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Content;
use Yabasi\Images;
use Yabasi\Order;
use Yabasi\Ordertype;
use Yabasi\Paymenttype;
use Yabasi\Pnotification;
use Yabasi\Points;
use Yabasi\Product;
use Yabasi\Refund;
use Yabasi\Request;
use Yabasi\Tags;
use Yabasi\User;
use Yabasi\Supplier;
use Yabasi\Usergroup;
use Yabasi\Vouchers;
use Yabasi\IntegrationSettings;
use Yabasi\IntegrationOrder;
use Yabasi\IntegrationProduct;

class V2Controller extends ControllerBase
{

    public function initialize()
    {
        $this->isAuth();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    }

    public function indexAction()
    {
        echo json_encode(array('code' => 200, 'message' => 'Auth is required!'));
    }

    public function getAction($table = false, $id = false)
    {
        if (!$table) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }

        $sorted = $this->request->getPost('sort');
        $orderby = 'desc';
        $field = 'id';
        if (isset($sorted)) {
            $sort = $sorted['sort'];
            $field = $sorted['field'];
            if ($sort === 'asc') {
                $orderby = 'asc';
            }
        }

        $order_param = array('order' => $field.' '.$orderby);

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
            'vouchers',
            'currency',
            'modules',
            'auth',
            'request',
            'product',
            'virtualpos',
            'order',
            'supplier',
            'refund',
            'statisticpro',
            'paymenttype',
            'points',
            'integrationorder',
            'integrationproduct',
            'tags'
        );

        if (in_array($table, $tables)) {

            require_once "class-list-util.php";

            if ($table == 'content') {

                $json = Content::find($order_param);

                foreach ($json as $json) {
                    $getCat = self::db("contentcats")::findFirst($json->content_cat_id);
                    $catName = "";
                    if ($getCat) {
                        $catName = $getCat->getName();
                    }
                    $arr[] = array(
                        'id' => $json->id,
                        'user_id' => $json->user_id,
                        'cat_id' => $getCat->id,
                        'category' => $catName,
                        'content_cat_id' => $json->content_cat_id,
                        'sef' => $json->sef,
                        'redirect_url' => $json->redirect_url,
                        'name' => $json->name,
                        'short_content' => $json->short_content,
                        'content' => $json->content,
                        'description' => $json->description,
                        'map' => $json->getMap(),
                        'image' => $this->getImage($json->getId(), 'content'),
                        'created_at' => $json->created_at,
                        'updated_at' => $json->updated_at,
                        'status' => $json->status,
                    );
                }
            } else if ($table == 'user') {
                if (is_numeric($id)) {
                    $order_param = array('conditions' => 'group_id=' . $id, 'order' => $field.' '.$orderby);
                }

                $list = User::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $group = self::db('usergroup')::findFirst($list->getGroupId());
                        $groupName = "";
                        if ($group) {
                            $groupName = $group->name;
                        }
                        $tcno = $list->id_no;
                        if ($list->id_no == 0) {
                            $tcno = '';
                        }
                        $arr[] = array(
                            'id' => $list->id,
                            'group_id' => $list->group_id,
                            'user_group' => $groupName,
                            'email' => $list->email,
                            'name' => $list->name,
                            'phone' => $list->phone,
                            'id_no' => $tcno,
                            'birth_date' => $list->birth_date,
                            'gender' => $list->gender,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'request') {
                if (is_numeric($id)) {
                    $orderby = 'id';
                    $order_param = array('conditions' => 'id=' . $id, 'order' => $field.' '.$orderby);
                }

                $list = Request::find($order_param);
                if ($list->count() > 0) {
                    foreach ($list as $list) {
                        $pro_id = self::db('product')::findFirst($list->product_id);
                        $proName = "";
                        if ($pro_id) {
                            $proName = $pro_id->name;
                        }
                        $users_id = self::db('user')::findFirst($list->user_id);
                        $userEmail = "";
                        if ($users_id) {
                            $userEmail = $users_id->email;
                        }

                        $arr[] = array(
                            'id' => $list->id,
                            'product' => $proName,
                            'user' => $userEmail,
                            'product_id' => $list->product_id,
                            'user_id' => $list->user_id,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'cargo') {
                $list = self::db('cargo')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {

                        $arr[] = array(
                            'id' => $list->id,
                            'name' => $list->name,
                            'content' => $list->content,
                            'image' => $this->getImage($list->getId(), 'cargo'),
                            'price' => $list->price,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'supplier') {
                $list = self::db('supplier')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {

                        $arr[] = array(
                            'id' => $list->id,
                            'name' => $list->name,
                            'image' => $this->getImage($list->getId(), 'cargo'),
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'virtualpos') {
                $list = self::db('virtualPos')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {

                        $arr[] = array(
                            'id' => $list->id,
                            'name' => $list->name,
                            'image' => $this->getImage($list->getId(), 'virtualPos'),
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status,
                        );
                    }
                }
            } else if ($table == 'vouchers') {
                $list = Vouchers::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $parse = json_decode($list->getMetaValue(), true);

                        if ($parse["discount_type"] == "1") {
                            $arr[] = array(
                                'id' => $list->getId(),
                                'name' => $list->getName(),
                                "voucher_code" =>$list->getCode(),
                                "discount_type" => $parse["discount_type"],
                                "discount" => $parse["discount"] . "₺",
                                "voucher_type" => $parse["voucher_type"],
                                "maximum_usage" => $parse["maximum_usage"],
                                "limit_of_per_person" => $parse["limit_of_per_person"],
                                "start_date" => $parse["start_date"],
                                "end_date" => $parse["end_date"],
                                "voucher_value" => $parse["voucher_value"],
                                'created_at' => $list->getCreatedAt(),
                                'updated_at' => $list->getUpdatedAt(),
                                'status' => $list->getStatus()

                            );

                        } else if ($parse["discount_type"] == "2") {
                            $arr[] = array(
                                'id' => $list->getId(),
                                'name' => $list->getName(),
                                "voucher_code" =>$list->getCode(),
                                "discount_type" => $parse["discount_type"],
                                "discount" => "%" . $parse["discount"],
                                "voucher_type" => $parse["voucher_type"],
                                "maximum_usage" => $parse["maximum_usage"],
                                "limit_of_per_person" => $parse["limit_of_per_person"],
                                "start_date" => $parse["start_date"],
                                "end_date" => $parse["end_date"],
                                "voucher_value" => $parse["voucher_value"],
                                'created_at' => $list->getCreatedAt(),
                                'updated_at' => $list->getUpdatedAt(),
                                'status' => $list->getStatus()
                            );

                        }

                    }
                }
            } else if ($table == 'usergroup') {
                $list = Usergroup::find($order_param);
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
                }
            } else if ($table == 'product') {
                $list = Product::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {


                        $brand_name = '';
                        $brands = Brand::findFirst($list->getBrandId());
                        if ($brands) {
                            $brand_name = $brands->getName();
                        }

                        $cat_name = '';
                        foreach (explode(",",$list->getCatsId()) as $cats) {
                            $category = Cats::findFirst($cats);
                            if ($category) {
                                $cat_name .= "<span class='text-dark-75 font-weight-bold font-size-sm'>".$category->getName()."</span>, ";
                            }
                        }

                        $supplier_name = '';
                        $supplier = Supplier::findFirst($list->getSupplierId());
                        if ($supplier) {
                            $supplier_name = $supplier->getName();
                        }

                        $cat_name = mb_substr($cat_name, 0,-2);

                        $sale_rate = 'TL';
                        if ($list->getSaleRate() == 2) {
                            $sale_rate = 'USD';
                        } else if ($list->getSaleRate() == 3) {
                            $sale_rate = 'EURO';
                        }

                        $arr[] = array(
                            'id' => $list->id,
                            'cats_id' => $list->cats_id,
                            'cat_name' => $cat_name,
                            'brand_id' => $list->brand_id,
                            'supplier_id' => $list->supplier_id,
                            'variant_id' => $list->variant_id,
                            'supplier_name' => $supplier_name,
                            'brand_name' => $brand_name,
                            'user_id' => $list->user_id,
                            'feature_id' => $list->feature_id,
                            'description' => $list->description,
                            'name' => $list->name,
                            'content' => $list->content,
                            'short_content' => $list->short_content,
                            'sef' => $list->sef,
                            'image' => $image = $this->getImage($list->getId(), 'product'),
                            'sale_price' => $list->sale_price,
                            'rate' => $sale_rate,
                            'purchase_price' => $list->purchase_price,
                            'vat_rate' => $list->vat_rate,
                            'transfer_discount' => $list->transfer_discount,
                            'barcode' => $list->barcode,
                            'stock' => $list->unit,
                            'stock_code' => $list->stock_code,
                            'cargo_weight' => $list->cargo_weight,
                            'unit' => $list->unit,
                            'offer' => $list->offer,
                            'gift' => $list->gift,
                            'warranty' => $list->warranty,
                            'new_chance' => $list->getNewChance(),
                            'daily_chance' => $list->getDailyChance(),
                            'unmissable_chance' => $list->getUnmissableChance(),
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'cats') {
                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=' . $id;
                }
                $order_param = array('conditions' => $param, 'order' => $field.' '.$orderby);

                $list = Cats::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $total_subcat = self::db("cats")::count('top_id=' . $list->id);

                        $arr[] = array(
                            'id' => $list->getId(),
                            'user_id' => $list->getUserId(),
                            'top_id' => $list->getTopId(),
                            'total_subcat' => $total_subcat,
                            'sef' => $list->getSef(),
                            'description' => $list->getDescription(),
                            'name' => $list->getName(),
                            'short_content' => $list->getShortContent(),
                            'content' => $list->getContent(),
                            'image' => $this->getImage($list->getId(), 'category'),
                            'unmissable_chance' => $list->getUnmissableChance(),
                            'banner' => $list->getBanner(),
                            'created_at' => $list->getCreatedAt(),
                            'updated_at' => $list->getUpdatedAt(),
                            'status' => $list->getStatus()
                        );
                    }
                }
            } else if ($table == 'contentcats') {

                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=' . $id;
                }
                $order_param = array('conditions' => $param, 'order' => $field.' '.$orderby);

                $list = self::db('contentcats')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $total_subcat = self::db("contentcats")::count('top_id=' . $list->id);
                        $arr[] = array(
                            'id' => $list->id,
                            'user_id' => $list->user_id,
                            'top_id' => $list->top_id,
                            'total_subcat' => $total_subcat,
                            'sef' => $list->sef,
                            'description' => $list->description,
                            'name' => $list->name,
                            'content' => $list->content,
                            'image' => $this->getImage($list->getId(), 'contentcats'),
                            'nav' => (int) $list->nav,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'bank') {
                $list = Bank::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->getId(),
                            'name' => $list->getName(),
                            'content' => $list->getContent(),
                            'iban'=>$list->getIban(),
                            'owner'=>$list->getOwner(),
                            'accountNumber'=>$list->getAccountNumber(),
                            'branch'=>$list->getBranch(),
                            'image' => $this->getImage($list->getId(), 'bank'),
                            'created_at' => $list->getCreatedAt(),
                            'updated_at' => $list->getUpdatedAt(),
                            'status' => $list->getStatus()
                        );
                    }
                }
            } else if ($table == 'auth') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'group_id=' . $id;
                }

                $list = self::db('auth')::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $modules = self::db("modules")::findFirst($list->module_id);
                        $arr[] = array(
                            'id' => $list->id,
                            'group_id' => $list->group_id,
                            'modules_id' => $list->module_id,
                            'name' => $modules->name,
                            'read' => $list->read,
                            'write' => $list->write,
                            'edit' => $list->edit,
                            'delete' => $list->remove,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'brand') {
                $list = self::db('brand')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'user_id' => $list->user_id,
                            'sef' => $list->sef,
                            'description' => $list->description,
                            'keyword' => $list->keyword,
                            'name' => $list->name,
                            'content' => $list->content,
                            'image' => $this->getImage($list->getId(), 'brand'),
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            } else if ($table == 'variant') {
                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=' . $id;
                }

                $order_param = array('conditions' => $param, 'order' => $field.' '.$orderby);

                $list = self::db('variant')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $total_subcat = self::db("variant")::count('top_id=' . $list->id);
                        $arr[] = array(
                            'id' => $list->id,
                            'top_id' => $list->top_id,
                            'name' => $list->name,
                            'image' => $this->getImage($list->getId(), 'variant'),
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status,
                            'total_subcat' => $total_subcat,

                        );
                    }
                }
            } else if ($table == 'feature') {
                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=' . $id;
                }

                $order_param = array('conditions' => $param, 'order' => $field.' '.$orderby);

                $list = self::db('feature')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $total_subcat = self::db("feature")::count('top_id=' . $list->id);
                        $arr[] = array(
                            'id' => $list->id,
                            'top_id' => $list->top_id,
                            'name' => $list->name,
                            'image' => $this->getImage($list->getId(), 'feature'),
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status,
                            'total_subcat' => $total_subcat,

                        );
                    }
                }
            }
            else if ($table == 'pnotification') {
                $param = '';
                if (is_numeric($id)) {
                    $param = 'user_id='.$id;
                }

                $list = Pnotification::find($param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {

                        $user_info = "Misafir";
                        $email = null;
                        $user  = User::findFirst($list->getUserId());
                        if ($user) {
                            $user_info = $user->getName();
                            $email = $user->getEmail();
                        }

                        $bank_info = null;
                        $bank  = Bank::findFirst($list->getBankId());
                        if ($bank) {
                            $bank_info = $bank->getName();
                        }

                        $order_code = null;
                        $order = Order::findFirst($list->getOrderId());
                        if ($order){
                            $json = json_decode($order->getMetaValue(), true);
                            if ($json){
                                $order_code = $json['code'];
                            }
                        }
                        $arr[] = array(
                            'id' => $list->getId(),
                            'name' => $user_info,
                                'note' => $list->getNote(),
                            'email' => $email,
                            'order_id' =>$order_code,
                            'orderGo' => $list->getOrderId(),
                            'bank_id' => $bank_info,
                            'created_at' => $list->getCreatedAt(),
                            'updated_at' => $list->getUpdatedAt(),
                            'status' => $list->getStatus()
                        );
                    }
                }
            }
            else if ($table == 'comment') {
                $list = self::db('comment')::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $userInfo = '';
                        $user = User::findFirst($list->getUserId());
                        if ($user) {
                            $userInfo = $user->getName();
                        }
                        $arr[] = array(
                            'id' => $list->id,
                            'pro_id' => $list->pro_id,
                            'user_id' => $list->user_id,
                            'userInfo' => $userInfo,
                            'ip_address' => $list->ip_address,
                            'user_agent' => $list->user_agent,
                            'comment' => $list->comment,
                            'point' => $list->point,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            }
            else if ($table == 'currency') {
                $list = self::db('currency')::find();
                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $arr[] = array(
                            'id' => $list->id,
                            'unit' => $list->unit,
                            'kur' => $list->kur,
                            'name' => $list->name,
                            'forex_buying' => $list->forex_buying,
                            'forex_selling' => $list->forex_selling,
                            'created_at' => $list->created_at,
                            'updated_at' => $list->updated_at,
                            'status' => $list->status
                        );
                    }
                }
            }
            else if ($table == 'order' && $id) {

                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=0';
                }

                $order_param = array('conditions' => $param, 'order' => $field.' '.$orderby);

                $list = self::db('order')::findFirst('meta_key="order" and '.$param);

                $product = self::db('order')::find(array('conditions' => 'meta_key="products" and '.'top_id='.$id, 'order' => 'id desc'));
                        foreach ($product as $products){
                            $parse2 = json_decode($products->meta_value, true);
                            $arr3 = array(['id'=>$parse2['id'],
                                'name'=>$parse2['name'],
                                'currency'=>$parse2['currency'],
                                'total_price'=>$products->total_price
                            ]);

                                $parse = json_decode($list->meta_value, true);

                                $total_subcat = self::db("order")::count('top_id=' . $list->id);
                                $PaymenttypeText = null;
                                $Paymenttype = Paymenttype::findFirst($parse['payment_type']);
                                if ($Paymenttype) {
                                    $PaymenttypeText = $Paymenttype->getName();
                                }
                                $order_text=Ordertype::findFirst( $products->order_status);
                                $order_statustext=$order_text->getName();

                                $user = User::findFirst($products->getUserId());
                                $user_info = '';
                                $user_email = '';
                                if ($user) {
                                    $user_info = $user->getName();
                                    $user_email = $user->getEmail();
                                }

                                if ($parse) {
                                    $arr[] = array(
                                        "id" => $products->id,
                                        "name" => $parse2['name'],
                                        "user_email" => $user_email,
                                        "user_id" => $list->getUserId(),
                                        "order_text" =>$order_statustext,
                                        "date"=>date('d/m/Y', (int) $list->getCreatedAt()),
                                        "code" => $parse["code"],
                                        "payment_type" => (int) $parse["payment_type"],
                                        "payment_type_text" => $PaymenttypeText,
                                        "cargo" => $parse["cargo"],
                                        "cargo_type" => $parse["cargo_type"],
                                        "cargo_price" => $parse["cargo_price"],
                                        "total_price" => $products->total_price,
                                        "gift_package" => $parse["gift_package"],
                                        "gift_note" => $parse["gift_note"],
                                        "order_date" => $list->getCreatedAt(),
                                        "ip" => $parse["ip"],
                                        "created_at" => $list->getCreatedAt(),
                                        "updated_at" => $list->getUpdatedAt(),
                                        "currency" => $parse["currency"],
                                        "delivery_address" => $parse["delivery_address"],
                                        "invoice_address" => $parse["invoice_address"],
                                        'status' => $list->status,
                                        'order_status' =>$products->order_status,
                                        'total_subcat' =>0,
                                        "products"=>['id'=>$parse2['id'],
                                            'name'=>$parse2['name'],
                                            'currency'=>$parse2['currency'],
                                            'total_price'=>$products->total_price]
                                    );
                                }





                }
            }  else if ($table == 'order' && $id==false) {

                $param = 'top_id=0';
                if (is_numeric($id)) {
                    $param = 'top_id=0';
                }

                $list = Order::find(array('conditions' => 'meta_key="order" and '.$param, 'order' => 'id desc'));

                if ($list->count() != 0) {
                    foreach ($list as $list) {
                        $product = Order::find(array('conditions' => 'meta_key="products" and '.'top_id='.$list->id, 'order' => 'id desc'));
                        $arr2 = array();
                        foreach ($product as $prodcuts){
                            $parse2 = json_decode($prodcuts->meta_value, true);
                            $arr2[] = array('id'=>$list->id,
                                'name'=>$parse2['name'],
                                'currency'=>$parse2['currency'],
                                'total_price'=>$prodcuts->total_price
                            );
                        }
                        $parse = json_decode($list->meta_value, true);

                        $total_subcat = self::db("order")::count('top_id=' . $list->id);
                        $PaymenttypeText = null;
                        $Paymenttype = Paymenttype::findFirst($parse['payment_type']);
                        if ($Paymenttype) {
                            $PaymenttypeText = $Paymenttype->getName();
                        }

                        $user = User::findFirst($list->getUserId());
                        $user_info = '';
                        $user_email = '';
                        if ($user) {
                            $user_info = $user->getName();
                            $user_email = $user->getEmail();
                        }

                        if ($parse) {
                            $arr[] = array(
                                "id" => $list->id,
                                "name" => $user_info,
                                "user_email" =>$user_email,
                                "currency_kur" => $list->getCurrency(),
                                "user_id" => $list->getUserId(),
                                "code" => $parse["code"],
                                "payment_type" => (int) $parse["payment_type"],
                                "payment_type_text" => $PaymenttypeText,
                                "cargo" => $parse["cargo"],
                                "cargo_price" => $parse["cargo_price"],
                                "date"=>date('m/d/Y', (int) $list->getCreatedAt()),
                                "total_price" => $list->total_price,
                                "gift_package" => $parse["gift_package"],
                                "gift_note" => $parse["gift_note"],
                                "order_date" => $list->getCreatedAt(),
                                "ip" => $parse["ip"],
                                "created_at" => $list->getCreatedAt(),
                                "updated_at" => $list->getUpdatedAt(),
                                "currency" => $parse["currency"],
                                "products" => $arr2,
                                "delivery_address" => $parse["delivery_address"],
                                "invoice_address" => $parse["invoice_address"],
                                'status' => $list->status,
                                'order_status' => $list->order_status,
                                'total_subcat' => $total_subcat
                            );
                        }
                    }
                }
            }
            else if ($table == 'integrationorder' && $id==false) {

                $orders = IntegrationOrder::find();

                if ($orders->count() != 0) {
                    foreach ($orders as $order) {
                        $placeName = IntegrationSettings::findFirst($order->getPlace())->getName();
                        $orderDetail = json_decode($order->getOrderDetail(), true);

                        switch ($placeName) {
                            case 'n11':
                                $buyer_name = $orderDetail["buyer"]["fullName"];
                                break;

                            default:
                                $buyer_name = "";
                                break;
                        }

                        $arr[] = array(
                            "id" => $order->id,
                            "place" => $placeName,
                            "order_code" => $order->order_code,
                            "buyer_name" => $buyer_name,
                            "status" => $order->status,
                        );
                    }
                }
            }
            else if ($table == 'integrationproduct' && $id==false) {

                $products = Product::find();

                if ($products->count() != 0) {
                    foreach ($products as $product) {
                        $placeList = IntegrationSettings::find();
                        $placeReturnList = '';

                        foreach ($placeList as $place) {
                            $IntegrationproductData = IntegrationProduct::find('site_id = '.$product->id.' AND place = '.$place->id);

                            if ($IntegrationproductData->count()!=0) {
                                $placeReturnList .= $place->getName().'#'.$place->getId().'#1%';
                            }else{
                                $placeReturnList .= $place->getName().'#'.$place->getId().'#0%';
                            }
                        }

                        $arr[] = array(
                            "id" => $product->id,
                            "name" => $product->name,
                            "IntegrationStatus" => $placeReturnList,
                        );
                    }
                }
            }
            else if ($table == 'refund') {
                $list = Refund::find($order_param);
                if ($list->count() != 0) {
                    foreach ($list as $list) {

                        $user_info = null;
                        $user = User::findFirst($list->getUserId());
                        if ($user) {
                            $user_info = $user->getName();
                        }

                        $order_date = '';
                        $total_price = '';
                        $order_currency = '';
                        $order_status = 0;
                        $order = Order::findFirst($list->getOrderId());
                        if ($order) {
                            $order_id = $order->getId();
                            $order_date = $order->getCreatedAt();
                            $total_price = $order->getTotalPrice();
                            $order_currency = $order->getCurrency();
                            $order_status = $order->getOrderStatus();
                        }
                        $orderStatusinfo = null;
                        $order = Ordertype::findFirst($order_status);
                        if ($order) {
                            $orderStatusinfo = $order->getName();
                        }
                        $orderList =Order::findFirst($order_id);
                            if ($orderList->count()!=0)   {
                                if ($orderList->getMetaKey()=="order")   {
                                    $parse = json_decode($orderList->getMetaValue(), true);
                                    if ($parse) {
                                        $paymentId=$parse['payment_type'];
                                        $Paymenttype = Paymenttype::findFirst($paymentId);
                                            if ($Paymenttype) {
                                                $paymentText = $Paymenttype->getName();
                                            }
                                    }
                                 } else if ($orderList->getMetaKey()=="products")   {
                                    $orderss=Order::findFirst($orderList->getTopId());
                                    $parse = json_decode($orderss->getMetaValue(), true);
                                    if ($parse) {
                                        $paymentId=$parse['payment_type'];
                                        $Paymenttype = Paymenttype::findFirst($paymentId);
                                        if ($Paymenttype) {
                                            $paymentText = $Paymenttype->getName();
                                        }
                                    }
                                }

                            }

                        $arr[] = array(
                            'id' => $list->getId(),
                            'user_id' => $list->getUserId(),
                            'user_info' => $user_info,
                            'order_id' => $list->getOrderId(),
                            'PaymenttypeText' => $paymentText,
                            'order_status' => $order_status,
                            'orderStatusinfo' => $orderStatusinfo,
                            'total_order' => $total_price,
                            'order_currency' => $order_currency,
                            'order_date' => $order_date,
                            'code' => $list->getCode(),
                            'refund_amount' => $list->getRefundAmount(),
                            'refund_currency' => $list->getCurrency(),
                            'created_at' => $list->getCreatedAt(),
                            'updated_at' => $list->getUpdatedAt(),
                            'status' => $list->getStatus()
                        );
                    }
                }
            }
            else if ($table == 'statisticpro') {
                $list = Product::find('status=1');
                if (is_numeric($id)){
                    $order = Order::find((array('group' => 'user_id','conditions' => 'meta_key="products" and pro_id='.$id)));
                    if (count($order) > 0){
                        foreach ($order as $order) {
                            $orders = Order::find('meta_key="products" and pro_id='.$id.' and user_id='.$order->getUserId());
                            if (count($orders) > 0) {
                                $user="";
                                $users=User::findFirst($order->getUserId());
                                if ($users){
                                    $user=$users->getName();
                                }
                                if ($orders->count('user_id='.$order->getUserId()) > 0) {
                                    $arr[] = array(
                                        'id' => $order->getId(),
                                        'name'=>$user,
                                        'count'=>$orders->count('user_id='.$order->getUserId()),
                                        'image' => $this->getImage($id, 'product'),
                                        'total_subcat'=>0,
                                        'created_at' => $order->getCreatedAt(),
                                        'updated_at' => $order->getUpdatedAt(),
                                        'status' => $order->getStatus()
                                    );
                                }

                            }
                        }
                    }
                } else{
                    if ($list->count() != 0) {
                        foreach ($list as $list) {
                            $order = Order::find('meta_key="products" and pro_id='.$list->getId())->count();
                            if ($order>0){
                                $arr[] = array(
                                    'id' => $list->getId(),
                                    'name'=>$list->getName(),
                                    'image' => $this->getImage($list->getId(), 'product'),
                                    'total_subcat'=>$order,
                                    'created_at' => $list->getCreatedAt(),
                                    'updated_at' => $list->getUpdatedAt(),
                                    'count'=>$order
                                );
                                usort($arr, function($a, $b) { //Sort the array using a user defined function
                                    return $a['count'] > $b['count'] ? -1 : 1; //Compare the scores
                                });

                            }

                        }
                    }
                }

            } else if ($table == 'paymenttype') {
                $list = Paymenttype::find($order_param);
                if (count($list) > 0) {
                    foreach ($list as $item) {
                        $arr[] = array(
                            'id' => $item->getId(),
                            'name' => $item->getName(),
                            'created_at' => $item->getCreatedAt(),
                            'updated_at' => $item->getUpdatedAt(),
                            'status' => $item->getStatus()
                        );
                    }
                }
            } else if ($table == 'points') {
                $list = Points::find($order_param);
                if (count($list) > 0) {
                    foreach ($list as $item) {

                        $user = User::findFirst($item->getUserId());
                        $user_info = '';
                        $user_email = '';
                        if ($user) {
                            $user_info = $user->getName();
                            $user_email = $user->getEmail();
                        }
                        $arr[] = array(
                            'id' => $item->getId(),
                            'user_id' => $item->getUserId(),
                            'user_info' => $user_info,
                            'user_email' => $user_email,
                            'operation' => $item->getOperation(),
                            'point' => $item->getPoint(),
                            'created_at' => $item->getCreatedAt(),
                            'updated_at' => $item->getUpdatedAt(),
                            'status' => $item->getStatus()
                        );
                    }
                }
            } else if ($table == 'tags') {
                $list = Tags::find($order_param);
                if (count($list) > 0) {
                    foreach ($list as $item) {
                        $pro_name = '';
                        $pro = Product::findFirst($item->getProId());
                        if ($pro) {
                            $pro_name = $pro->getName();
                        }
                        $arr[] = array(
                            'id' => $item->getId(),
                            'pro_id' => $item->getProId(),
                            'pro_name' => $pro_name,
                            'image' => $this->getImage($item->getProId(), 'product'),
                            'name' => $item->getName(),
                            'created_at' => $item->getCreatedAt(),
                            'updated_at' => $item->getUpdatedAt(),
                            'status' => $item->getStatus()
                        );
                    }
                }
            }



            $data = $alldata = @$arr;

            $datatable = array_merge(array('pagination' => array(), 'sort' => array(), 'query' => array()), $_REQUEST);

            // search filter by keywords
            $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
            if (!empty($filter)) {
                $data = array_filter($data, function ($a) use ($filter) {
                    return @(boolean)preg_grep("/$filter/i", (array)$a);
                });
                unset($datatable['query']['generalSearch']);
            }

            // filter by field query
            $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
            if (is_array($query)) {
                $query = array_filter($query);
                foreach ($query as $key => $val) {
                    $data = list_filter($data, array($key => $val));
                }
            }

            $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
            $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'id';

            $meta = array();
            $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
            $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

            $pages = 1;
            $total = @count($data); // total items in array

            // sort
            @uasort($data, function ($a, $b) use ($sort, $field) {
                if (!isset($a->$field) || !isset($b->$field)) {
                    return false;
                }

                if ($sort === 'asc') {
                    return $a->$field > $b->$field ? true : false;
                }

                return $a->$field < $b->$field ? true : false;
            });

            // $perpage 0; get all data
            if ($perpage > 0) {
                $pages = ceil($total / $perpage); // calculate total pages
                $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
                $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
                $offset = ($page - 1) * $perpage;
                if ($offset < 0) {
                    $offset = 0;
                }

                $data = array_slice($data, $offset, $perpage, true);
            }

            $meta = array(
                'page' => $page,
                'pages' => $pages,
                'perpage' => $perpage,
                'total' => $total,
            );

            if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
                $meta['rowIds'] = array_map(function ($row) {
                    foreach ($row as $first) break;
                    return $first;
                }, $alldata);
            }

            $result = array(
                'meta' => $meta + array(
                        'sort' => $sort,
                        'field' => $field,
                    ),
                'data' => $data
            );

            echo json_encode($result, JSON_PRETTY_PRINT);
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

}