<?php
namespace Yabasi\Backend\Controllers;
use Yabasi\Backend\Controllers\ControllerBase;

class EditController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    }

    public function indexAction() {
        echo json_encode(array('code' => 200, 'message' => 'Auth is required!'));
    }

    public function doAction() {
        $this->view->disable();

        $id = $this->request->getQuery("id");
        $table = $this->request->getQuery('table');

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
            'images',
            'vouchers',
            'supplier',
            'tags'
        );
        if (in_array($table, $tables)) {
            if (is_numeric($id)) {
                if ($table=="cats"){
                    $table="category";
                }
                if ($this->isAuthorityEdit($table)=="noauth"){
                    echo json_encode(array('status' => "noauth"));
                }else{
                    echo json_encode(array('status' => true));
                }
            }
        }
    }


}