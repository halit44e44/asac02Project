<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;

use Yabasi\Comment;
use Yabasi\User;

// kullanıcı yorum sistemi
class CommentController extends ControllerBase {
    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkmodul('content');
        self::checkLicenceKey();
        $this->view->cevir   = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page    = 'content';
        $this->view->subpage    = 'comment';
        $this->isAuthorityVolt();
    }
    public function indexAction($table=false ,$id=false) {
        self::isAuthority("comment","read");
        $this->view->subpage = 'comment';

        if($table=="seen" && $id==false){
            $comment=Comment::find("seen=1");
            if ($comment){
                foreach ($comment as $comments){
                    $comments->setSeen("0");
                    $comments->setUpdatedAt(self::getnow());
                    $comments->update();
                }
            }
        }
       else if($table=="seen" && is_numeric($id)){
            $comment=Comment::find("seen=1");
            $this->view->id=$id;
            if ($comment){
                foreach ($comment as $comments){
                    $comments->setSeen("0");
                    $comments->setUpdatedAt(self::getnow());
                    $comments->update();

                }
            }
        }
    }

    public function updateAction() {
        self::isAuthority("comment","edit");
    }

    public function getAction($id = false) {
        $this->view->disable();
        if (is_numeric($id)) {
            $returned = '';
            $detail = Comment::findFirst($id);
            if ($detail) {
                $user = User::findFirst($detail->getUserId());
                $userInfo = '';
                if ($user) {
                    $userInfo = $user->getName();
                }

                $points = '';
                for ($i = 0; $i < $detail->getPoint(); $i++) {
                    $points .= '<i class="fa fa-star"></i>';
                }

                $returned = '<tr>
                            <th scope="row">Ürün</th>
                            <td><a href="javascript:;" target="_blank">Örnek Ürün #1</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Kullanıcı</th>
                            <td>'.$userInfo.'</td>
                        </tr>
                        <tr>
                            <th scope="row">Yorum</th>
                            <td>'.$detail->getComment().'</td>
                        </tr>
                        <tr>
                            <th scope="row">Puan</th>
                            <td>'.$points.'</td>
                        </tr>
                        <tr>
                            <th scope="row">Ip Adresi</th>
                            <td>'.$detail->getIpAddress().'</td>
                        </tr>
                        <tr>
                            <th scope="row">Tarayıcı Bilgileri</th>
                            <td>'.$detail->getUserAgent().'</td>
                        </tr>
                        <tr>
                            <th scope="row">Yorum Tarihi</th>
                            <td>'.self::unixToDate($detail->getCreatedAt()).'</td>
                        </tr>';
            }

            echo $returned;
        }
    }
}