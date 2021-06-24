<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Yabasi\User;
use Yabasi\Usergroup;

// üye giriş işlemleri
class LoginController extends ControllerBase {

    public function initialize() {
        $this->view->cevir = self::getTranslator();
        $this->view->page='login';
        self::checkLicenceKey();
    }
    
    public function indexAction() {
        if (isset($_COOKIE['user'])){
            setcookie('user', '', time() - 3600);
            unset($_COOKIE['user']);
        }
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            if ($email && $password) {

                $user = User::findFirst('email="'.$email.'" and status=1 and group_id != 2');
                if ($user) {
                    $group = Usergroup::findFirst($user->getId());
                    if ($group) {
                        if ($group->getType() != 1) {
                            $this->response->redirect('backend/login');
                        }
                    }
                    if ($this->security->checkHash($password, $user->getPassword())) {
                        $random = new \Phalcon\Security\Random();
                        $code =  $random->hex(15);
                        $this->cookies->set('user', $email, time() + 15 * 86400);
                        $this->cookies->set('password', $code, time() + 15 * 86400);
                        $users=User::findFirstByEmail($email);
                        $codes =  $this->security->hash($code);
                        $ip= $this->request->getClientAddress();
                        $browser= $_SERVER['HTTP_USER_AGENT'] ;
                        $users->setCode($codes);
                        $users->setIp($ip);
                        $users->setBrowser($browser);
                        $users->save();
                        $this->cookies->send();
                        //setcookie('auth', $email, time() + (7200 * 1));
                        $this->response->redirect('backend');
                    } else {
                        $this->response->redirect('backend/login');
                    }
                }
            }
        }

    }
    public function logoutAction() {
        $this->cookies->get('user')->delete();
        $this->cookies->get('password')->delete();
        $this->response->redirect('backend/login');
    }

    public function resetAction() {

        $this->view->pick('inc/reset');

        if ($this->request->isPost()) {
            $this->view->disable();
            require '../vendor/autoload.php';
            $email = $this->request->getPost('email');
            if (isset($email)) {
                $smtp = new PHPMailer(true);
                try {
                    $random = new \Phalcon\Security\Random();
                    $code = $random->hex(13);
                    $stmp->SMTPDebug = 2;
                    $stmp->isSMTP();
                    $stmp->Host = 'ssl://smtp.gmail.com';
                    $stmp->SMTPAuth = true;
                    $stmp->Username = '';
                    $stmp->Password = '';
                    $stmp->SMTPSecure = 'tls';
                    $stmp->Port = 465;
                    $message = 'Merhaba Abbas, Şifre sıfırlama linki aşağıdadır.\n http://localhost/yabasi/login/forget/'.$email.'/code/'.$code;
                    $smtp->setFrom('reset@yabasi.com');
                    $stmp->addAddress($email, 'İsim Soyisim');
                    $stmp->isHTML();
                    $stmp->Subject = 'Şifre Sıfırlama';
                    $smtp->Body = $message;

                    $user = self::db('user')::findFirstByEmail($email);
                    if ($user) {
                        $user->setCode($code);
                        $user->setUpdatedAt(self::getnow());
                        $user->update();
                        if ($smtp->send()) {
                            echo 'mail gönderildi';
                        } else {
                            echo 'mail gönderilemedi';
                        }
                    }
                        
                } catch(Exception $e) {
                    echo $e->getMessage();
                }
            }
        }

    }

    public function forgetAction($code) {
        if (isset($code)) {
            $user = self::db('user')::findFirstByCode($code);
            if ($user) {
                if (time() < $user->getUpdatedAt()) {
                    if ($this->request->isPost()) {
                        $password1 = $this->request->getPost('password1');
                        $password2 = $this->request->getPost('password2');
                        if ($password1 && $password2 ) {
                            if ($password1 == $password2) {

                                $random = new \Phalcon\Security\Random();
                                $code = $random->hex(13);

                                $user->setCode($code);
                                $user->setPassword(sha1($password1));
                                $user->setUpdatedAt(self::getnow());
                                $user->update();
                                $this->response->redirect('backend/login/');
                            }
                        }
                    }
                }
            }
        }
    }

}