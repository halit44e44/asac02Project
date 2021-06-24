<?php

use Yabasi\Auth;
use Yabasi\Backend\Controllers\ControllerBase;
use Yabasi\Modules;
use Yabasi\User;
use Yabasi\Usergroup;

class Authentication extends ControllerBase {
    public function check($module = false, $process = false) {
        if(!$process){
            $process="read";
        }

        if ($module && $process) {
            $email = $_COOKIE["auth"];

            if (!$email) {
                $this->response->redirect("backend/login");
            }

            $user = User::findFirst('email="'.$email.'"');
            if ($user) {
                $group = Usergroup::findFirst($user->getGroupId());
                if ($group) {
                    $auth = Auth::findFirst($group->getId());
                    if ($auth) {
                        $modules = Modules::findFirst('sef="'.$module.'"');
                        if ($modules) {
                            $checkAuth = Auth::findFirst('group_id='.$user->getGroupId().' and module_id='.$modules->getId().' and '.$process.'=1');
                            if (!$checkAuth) {
                                $this->response->redirect("backend/");
                            }
                            else {
                                $this->response->redirect("backend/$module");
                            }
                        }
                    } else {
                        $this->response->redirect("backend/login");
                    }
                }
            }



        }
    }
}