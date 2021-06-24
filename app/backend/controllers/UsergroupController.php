<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;



use Yabasi\Auth;
use Yabasi\Modules;
use Yabasi\User;
use Yabasi\Usergroup;

class UsergroupController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::checkLicenceKey();
        self::isAuthorityWrite("usergroup");
        self::checkmodul('user');
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'user';
        $this->view->subpage = 'usergroup';
    }
    public function indexAction() {
        self::isAuthority("usergroup","read");
    }

    public function updateAction($id = false) {
        self::isAuthority("usergroup","edit");
        $this->view->type = 'update';

        if(is_numeric($id)){
            $this->view->usergroup = Usergroup::findFirst($id);
        }

        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();

                    $name = $this->request->getPost('name');
                    $type = $this->request->getPost('type');
                    $id   = $this->request->getPost("id");

                    $update = Usergroup::findFirst($id);
                    if ($update) {
                        $update->setName($name);
                        $update->setUpdatedAt(self::getnow());
                        $update->setType($type);
                        if ($update->update()) {
                            $this->log($this->cookies->get('user'), $update->getId(), "usergroup", "update");
                            echo 'ok';
                        }
                    }
                }
            }
        }


    }

    public function insertAction() {
        self::isAuthority("usergroup","write");
        $this->view->type = 'insert';
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $this->view->disable();
                    $name = $this->request->getPost('name');
                    $type = $this->request->getPost('type');

                    $insert = new Usergroup();
                    $insert->setName($name);
                    $insert->setCreatedAt(self::getnow());
                    $insert->setUpdatedAt(self::getnow());
                    $insert->setType($type);
                    if ($insert->save()) {
                        $this->log($this->cookies->get('user'),$insert->getId(),"usergroup","add");
                        $this->setModules($insert->getId());
                        echo 'ok';
                    }
                }
            }
        }

    }
    public function setModules($group_id = false) {
        if (is_numeric($group_id)) {
            $groups = Usergroup::findFirst($group_id);
            if ($groups) {
                $modules = Modules::find();
                if (count($modules) > 0) {
                    foreach ($modules as $item) {
                        $read = 0;
                        $write = 0;
                        $edit = 0;
                        $remove = 0;
                        if ($item->getId() == 16) {
                            $write = 2;
                            $edit = 2;
                            $remove = 2;
                        }
                        $auth = new Auth();
                        $auth->setGroupId($group_id);
                        $auth->setModuleId($item->getId());
                        $auth->setRead($read);
                        $auth->setWrite($write);
                        $auth->setEdit($edit);
                        $auth->setRemove($remove);
                        $auth->setCreatedAt(self::getnow());
                        $auth->setUpdatedAt(self::getnow());
                        $auth->setStatus(1);
                        $auth->save();
                    }
                }

            }
        }
    }
}