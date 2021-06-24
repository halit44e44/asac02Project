<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;
use Yabasi\Auth;
use Yabasi\Bank;
use Yabasi\Images;
use Yabasi\Modules;
use Yabasi\User;
use Yabasi\Usergroup;

class BankController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::isAuth();
        self::isAuthorityVolt();
        self::getModul();
        self::isAuthorityWrite("bank");
        self::checkmodul('order');
        self::checkLicenceKey();
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'order';
        $this->view->subpage = 'bank';
    }
    public function indexAction() {
    self::isAuthority("bank","read");
    }

    public function updateAction($id = false) {
        self::isAuthority("bank","edit");
        $this->view->type = 'update';

        if(is_numeric($id)) {
            $this->view->bank = Bank::findFirst($id);
            $this->view->images = Images::find('meta_key="bank" and content_id=' . $id);
        }
        if ($this->request->isPost()) {
                if ($this->request->isAjax()) {
                    $this->view->disable();
                    $id= $this->request->get("id");
                    $name= $this->request->get("name");
                    $owner= $this->request->get("owner");
                    $iban= $this->request->get("iban");
                    $branch=$this->request->get("branch");
                    $account_number=$this->request->get("account_number");
                    $content=$this->request->get("content");
                    $bank=Bank::findFirst($id);
                    $bank->setName($name);
                    $bank->setOwner($owner);
                    $bank->setIban($iban);
                    $bank->setAccountNumber($account_number);
                    $bank->setBranch($branch);
                    $bank->setContent($content);
                    $bank->setUpdatedAt($this->getnow());
                    if ($bank->save()){
                      //$this->log($_COOKIE["auth"],$bank->getId(),"bank","update");
                        echo json_encode(array('status' => 'ok', 'id' => $bank->getId()));
                    }else{
                        foreach ($bank->getMessages() as $message){
                            echo $message;
                        }
                    }
                }
            }



    }
    public function insertAction() {
        $user=User::findFirst($this->getAuthId());

        $this->view->user=$user;
        self::isAuthority("bank","write");
        $this->view->type = 'insert';
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $this->view->disable();
                $name= $this->request->get("name");
                $owner= $this->request->get("owner");
                $iban= $this->request->get("iban");
                $branch=$this->request->get("branch");
                $account_number=$this->request->get("account_number");
                $content=$this->request->get("content");
                $bank=new Bank();
                $bank->setName($name);
                $bank->setOwner($owner);
                $bank->setIban($iban);
                $bank->setAccountNumber($account_number);
                $bank->setBranch($branch);
                $bank->setContent($content);
                $bank->setCreatedAt($this->getnow());
                $bank->setUpdatedAt($this->getnow());
                $bank->setStatus(1);
                if ($bank->save()){
                    echo json_encode(array('status' => 'ok', 'id' => $bank->getId()));

                }

            }
        }
    }


}