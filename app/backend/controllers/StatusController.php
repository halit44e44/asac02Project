<?php
namespace Yabasi\Backend\Controllers;
use Yabasi\Backend\Controllers\ControllerBase;
use Yabasi\Cats;
use Yabasi\Contentcats;
use Yabasi\Product;
use Yabasi\User;

class StatusController extends ControllerBase {

    public function initialize() {
        self::isAuth();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    }

    public function indexAction() {
        echo json_encode(array('code' => 200, 'message' => 'Auth is required!'));
    }

    public function doAction($table = false, $id = false) {
        $this->view->disable();

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
            'vouchers',
            'virtualpos',
            'supplier',
            'order',
            'Paymenttype',
            'points',
            'request',
            'tags'
        );
        if (in_array($table, $tables)) {
            $user=User::findFirst($this->getAuthId());
            if ($user->getGroupId()==3){

            }else{
                if (is_numeric($id)) {
                    $update= self::db($table)::findFirst($id);

                    if ($update->getStatus()==1) {
                        $update->setStatus("2");
                        if($update->save()) {
                            $this->log($this->cookies->get('user'), $id, $table, "update");
                            echo 'ok';
                        } }
                    else if($update->getStatus()==2)  {
                        $update->setStatus("1");
                        if($update->save()){
                            $this->log($this->cookies->get('user'),$id,$table,"update");
                            echo 'ok';
                        }


                    }


                }
            }


    }}

    public function campaignAction($id = false, $column = false, $table = false) {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{ if (!$id || !$column) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }

            if (is_numeric($id)) {
                if ($table == 'product') {
                    $update = Product::findFirst($id);
                } else if ($table == 'cats') {
                    $update = Cats::findFirst($id);
                }

                if ($column == 'new_chance') {
                    if ($update->getNewChance() == 1) {
                        $update->setNewChance(2);
                        if($update->save()) {
                            $this->log($this->cookies->get('user'), $id, 'product', "update");
                            echo 'ok';
                        }
                    } else if($update->getNewChance() == 2)  {
                        $update->setNewChance(1);
                        if($update->save()){
                            $this->log($this->cookies->get('user'),$id,'product',"update");
                            echo 'ok';
                        }
                    }
                } else if ($column == 'daily_chance') {
                    if ($update->getDailyChance() == 1) {
                        $update->setDailyChance(2);
                        if($update->save()) {
                            $this->log($this->cookies->get('user'), $id, 'product', "update");
                            echo 'ok';
                        }
                    } else if($update->getDailyChance() == 2)  {
                        $update->setDailyChance(1);
                        if($update->save()){
                            $this->log($this->cookies->get('user'),$id,'product',"update");
                            echo 'ok';
                        }
                    }
                } else if ($column == 'unmissable_chance') {
                    if ($update->getUnmissableChance() == 1) {
                        $update->setUnmissableChance(2);
                        if($update->save()) {
                            $this->log($this->cookies->get('user'), $id, 'product', "update");
                            echo 'ok';
                        }
                    } else if($update->getUnmissableChance() == 2)  {
                        $update->setUnmissableChance(1);
                        if($update->save()){
                            $this->log($this->cookies->get('user'),$id,'product',"update");
                            echo 'ok';
                        }
                    }
                } else if ($column == 'banner') {
                    if ($update->getBanner() == 1) {
                        $update->setBanner(2);
                        if($update->save()) {
                            $this->log($this->cookies->get('user'), $id, 'cats', "update");
                            echo 'ok';
                        }
                    } else if($update->getBanner() == 2)  {
                        $update->setBanner(1);
                        if($update->save()){
                            $this->log($this->cookies->get('user'),$id,'cats',"update");
                            echo 'ok';
                        }
                    }
                }




            }}

    }

    public function navAction($id = false, $position = false, $table = false) {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{ if ($this->request->isAjax()) {
            if ($this->request->isGet()) {
                if (!$id || !$position) {
                    echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
                    die();
                }

                if ($table) {
                    if ($table == 'contentcats') {
                        $item = Contentcats::findFirst($id);
                        if ($item) {
                            if ($item->getNav() == 2) {
                                $item->setNav(0);
                            } else {
                                $item->setNav(2);
                            }
                            $item->update();
                        }
                    }
                }
            }
        }}

    }
}