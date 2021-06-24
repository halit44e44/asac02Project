<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Yabasi\Cargo;
use Yabasi\Images;
use Yabasi\Supplier;
use Yabasi\User;

// kargo sistemi
class SupplierController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkLicenceKey();
        self::isAuthorityWrite("supplier");
        self::checkmodul('product');
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'product';
        $this->view->subpage = 'supplier';
    }

    public function indexAction() {
        self::isAuthority("supplier","write");
        $this->view->type = 'insert';
    }

    public function updateAction($id = false) {
        self::isAuthority("supplier","edit");
        $this->view->type = 'update';

        if(is_numeric($id)){
            $this->view->supplier = Supplier::findFirst($id);
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {


                $this->view->disable();
                $name = $this->request->getPost('name');
                $id   = $this->request->getPost("id");
                $supplier = Supplier::findFirst($id);
                $supplier->setName($name);
                $supplier->setUpdatedAt(self::getnow());
                if ($supplier->save()) {
                    echo "ok";
                }
            }
        }
    }

    public function insertAction()
    {
        self::isAuthority("supplier", "write");
        $this->view->type = 'insert';
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();
                    $name = $this->request->getPost('name');
                    $insert = new Supplier();
                    $insert->setName($name);
                    $insert->setCreatedAt(self::getnow());
                    $insert->setUpdatedAt(self::getnow());
                    if ($insert->save()) {
                        $this->log($this->cookies->get('user'), $insert->getId(), "supplier", "add");
                        echo 'ok';
                    } else {
                        foreach ($insert->getMessages() as $message) {
                            echo $message;
                        }
                    }
                }
            }
        }


    }
}