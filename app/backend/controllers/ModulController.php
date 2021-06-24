<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Yabasi\Auth;
use Yabasi\Bank;
use Yabasi\Comment;
use Yabasi\Images;
use Yabasi\Modul;
use Yabasi\Modules;
use Yabasi\User;
use Yabasi\Usergroup;

class ModulController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::isAuth();
        self::isAuthorityVolt();
        self::getModul();
        self::checkLicenceKey();
        self::isAuthorityWrite("bank");
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'index';
        $this->view->subpage = 'vizor';
    }
    public function indexAction() {
    self::isAuthority("bank","read");
    $modul=Modul::find();
    $this->view->modul=$modul;

    }

    public function getAction($id = false) {
        $this->view->disable();
        if (is_numeric($id)) {
            $returned = '';
            $detail = Modul::findFirst($id);
            if ($detail) {
                $returned = '<input type="hidden" name="id" class="id" value="'.$id.'">
                        <tr>
                            <th scope="row">Modül İsmi</th>
                            <td><a href="javascript:;">'.$detail->getName().'</a></td>
                        </tr>
                        </tr>
                        <tr>
                            <th scope="row">Açıklama</th>
                            <td>'.$detail->getContent().'</td>
                        </tr>
                        <tr>
                            <th scope="row">Fiyat</th>
                            <td>'.$detail->getPrice().'₺</td>
                        </tr>
                      
                      '

                ;
            }
            echo $returned;
        }
        if ($this->request->isPost()){
            if ($this->request->isAjax()) {
                $id      = $this->request->getPost('id');
                $modul = Modul::findFirst(2);
                echo $id;
                if ($modul) {
                    $modul->setStatus("2");
                    if ($modul->save()) {
                        echo  "ok";
                    }
                }
            }
        }
    }
    public function buyAction($id = false){

        $this->view->disable();

        if (is_numeric($id)) {
            $modul = Modul::findFirst($id);
            if ($modul) {
                $modul->setStatus("2");
                if ($modul->save()) {
                    echo  "ok";
                }
            }
        }

    }

}