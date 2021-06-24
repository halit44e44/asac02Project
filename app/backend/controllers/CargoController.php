<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Yabasi\Cargo;
use Yabasi\Images;
use Yabasi\User;

// kargo sistemi
class CargoController extends ControllerBase {
    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkLicenceKey();
        self::isAuthorityWrite("cargo");
        self::checkmodul('order');
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'order';
        $this->view->subpage = 'cargo';
    }

    public function indexAction() {
        self::isAuthority("cargo","read");
    }

    public function updateAction($id = false) {
        self::isAuthority("cargo","edit");
        $this->view->type = 'update';

        if(is_numeric($id)){
            $this->view->cargo = Cargo::findFirst($id);
            $this->view->images   = Images::find('meta_key="cargo" and content_id='.$id);
        }

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {

                $this->view->disable();

                $name = $this->request->getPost('name');
                $content = $this->request->getPost('content');
                $price = $this->request->getPost('price');
                $id = $this->request->getPost('id');

                $cargo = Cargo::findFirst($id);
                $cargo->setName($name);
                $cargo->setContent($content);
                $cargo->setPrice(self::priceTextCorrector($price));
                $cargo->setUpdatedAt(self::getnow());
                if ($cargo->save()) {
                    $this->log($this->cookies->get('user'),$cargo->getId(),"cargo","update");
                    echo json_encode(array('status' => 'ok', 'id' => $cargo->getId()));
                }
            }
        }
    }

    public function insertAction() {
        self::isAuthority("cargo","write");
        $this->view->type = 'insert';
        $user=User::findFirst($this->getAuthId());
        $this->view->user=$user;
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $name = $this->request->getPost('name');
                $content = $this->request->getPost('content');
                $price = $this->request->getPost('price');

                $insert = new Cargo();
                $insert->setName($name);
                $insert->setContent($content);
                $insert->setPrice(self::priceTextCorrector($price));
                $insert->setCreatedAt(self::getnow());
                $insert->setUpdatedAt(self::getnow());
                if ($insert->save()) {
                    $this->log($this->cookies->get('user'),$insert->getId(),"cargo","add");
                    echo json_encode(array('status' => 'ok', 'id' => $insert->getId()));
                }
            }
        }
    }
}