<?php
declare(strict_types=1);

namespace Yabasi\Api\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Security;
use Yabasi\Cats;
use Yabasi\User;

class ControllerBase extends Controller {

    public function db($table = false) {
        if ($table) {
            return "\Yabasi".'\\'.ucfirst($table);
        }
    }

    public function getCats($id)
    {
        if (is_numeric($id)){
            $catsdd =Cats::find();
            $return = "";
            $return .= "$id,";
            $i=0;
            foreach ($catsdd as $cat) {
                if ($id==$cat->getTopId()){
                    $return .= $this->getCats($cat->getId());
                    $i++;
                }
            }
            return $return;

        }
    }
    protected function isAuth() {

        $user=$this->cookies->get('user');
        $code=$this->cookies->get('password');
        $users=User::findFirst("email="."'$user'");
        $security  = new Security();
        $ip= $this->request->getClientAddress();
        $browser= $_SERVER['HTTP_USER_AGENT'] ;
        if ($users ) {
            if ( $security->checkHash( "$code",$users->getCode())){
                if ($ip==$users->getIp()){
                    if ($browser==$users->getBrowser()){
                    }
                    else{
                        $this->response->redirect('backend/login');
                    }
                }
                else{
                    $this->response->redirect('backend/login');
                }
            }else{
                $this->response->redirect('backend/login');
            }

        } else{
            $this->response->redirect('backend/login');
        }
    }
}
