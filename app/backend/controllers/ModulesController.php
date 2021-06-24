<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Yabasi\Auth;
use Yabasi\Bank;
use Yabasi\Images;

class ModulesController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkmodul('user');
        self::checkLicenceKey();
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'user';
        $this->view->subpage = 'usergroup';
    }
    public function indexAction($id) {
        $this->isAuthority("modules","read");
        if (is_numeric($id)) {
            $this->view->id= $id;
        }
    }


    public function doAction($table = false, $id = false ,$status=false) {
        $this->view->disable();

        if (!$table) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }

        $tables = array(
            'read',
            'write',
            'edit',
            'delete',
        );
        if (in_array($table, $tables)) {
            if (is_numeric($id)) {
                $update=Auth::findFirst($id);
                $update->setUpdatedAt($this->getnow());
                 if ($table=="read"){
                     if ($status==1) {
                         $update->setRead("0");
                         if($update->save()) {
                             $this->log($this->cookies->get('user'), $id, "auth", "update");
                             echo 'ok';
                         } }
                     else if($status==0)  {
                         $update->setRead("1");
                         if($update->save()){
                             $this->log($this->cookies->get('user'),$id,"auth","update");
                         }

                         echo 'ok';
                     }
                 }
                 else if($table=="write"){
                     if ($status==1) {
                         $update->setWrite("0");
                         if($update->save()) {
                             $this->log($this->cookies->get('user'), $id, "auth", "update");
                             echo 'ok';
                         } }
                     else if($status==0)  {
                         $update->setWrite("1");
                         if($update->save()){
                             $this->log($this->cookies->get('user'),$id,'auth',"update");
                         }

                         echo 'ok';
                     }
                 }
                 else if($table=="edit"){
                     if ($status==1) {
                         $update->setEdit("0");
                         if($update->save()) {
                             $this->log($this->cookies->get('user'), $id, "auth", "update");
                             echo 'ok';
                         } }
                     else if($status==0)  {
                         $update->setEdit("1");
                         if($update->save()){
                             $this->log($this->cookies->get('user'),$id,'auth',"update");
                         }

                         echo 'ok';
                     }
                 }
                 else if($table=="delete"){
                     if ($status==1) {
                         $update->setRemove("0");
                         if($update->save()) {
                             $this->log($this->cookies->get('user'), $id, "auth", "update");
                             echo 'ok';
                         } }
                     else if($status==0)  {
                         $update->setRemove("1");
                         if($update->save()){
                             $this->log($this->cookies->get('user'),$id,'auth',"update");
                         }

                         echo 'ok';
                     }
                 }



            }

        }}


}