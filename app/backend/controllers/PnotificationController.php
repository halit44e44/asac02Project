<?php


namespace Yabasi\Backend\Controllers;


use http\Client\Curl\User;
use Yabasi\Bank;
use Yabasi\Mail;
use Yabasi\Order;
use Yabasi\Pnotification;

class PnotificationController extends ControllerBase {

    public function initialize() {
        self::getName();
        self::getModul();
        self::isAuth();
        self::isAuthorityVolt();
        self::isAuthorityWrite("pnotification");
        self::checkmodul('order');
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'order';
        self::checkLicenceKey();
        $this->view->subpage = 'pnotification';
    }

    public function indexAction($id = false)
    {
        self::isAuthority("pnotification", "read");
        if($id=="seen"){
            $pnotification=Pnotification::find("seen=1");
            if ($pnotification){
                foreach ($pnotification as $pnotification){
                    $pnotification->setSeen("0");
                    $pnotification->setUpdatedAt(self::getnow());
                    $pnotification->update();
                }
            }
        }
    }

    public function updateAction()
    {
        self::isAuthority("pnotification", "edit");
    }

    public function insertAction()
    {
        self::isAuthority("pnotification", "write");
    }

    public function getAction($id = false) {
        $this->view->disable();
        if (is_numeric($id)) {
            $returned = '';
            $detail = Pnotification::findFirst($id);
            $banka=Bank::findFirst($detail->getBankId());
            if ($detail) {
                $order = Order::findFirst($detail->getOrderId());
                if ($order){
                    $json = json_decode($order->getMetaValue(), true);
                    if ($json){
                        $code = $json['code'];
                    }
                }
                $aratoplam=$order->getTotalPrice()-(int)$json["cargo_price"];
                $returned = '<tr>
                            <th scope="row">Sipariş Kodu</th>
                            <td>'. $code .'</td>
                        </tr>
                         <tr>
                            <th scope="row">Ara Topam</th>
                            <td>'. $aratoplam .' '.$order->getCurrency().'</td>
                        </tr>
                         <tr>
                            <th scope="row">Kargo Fiyat</th>
                            <td>'.$json["cargo_price"].' '.$order->getCurrency().'</td>
                        </tr>
                        <tr>
                            <th scope="row">Toplam Fiyat</th>
                            <td>'.$order->getTotalPrice().' '.$order->getCurrency().'</td>
                        </tr>
                         <tr>
                            <th scope="row">Banka</th>
                            <td>'.$banka->getName().'</td>
                        </tr>
                        <tr>
                            <th scope="row">Not</th>
                            <td>'.$detail->getNote().'</td>
                        </tr>';
            }

            echo $returned;
        }
    }
    public function doAction($id){
        $update= Pnotification::findFirst($id);

        if ($update->getStatus()==1) {
            $update->setStatus("2");
            if($update->save()) {
                $this->log($this->cookies->get('user'), $id, "pnotification", "update");
                echo 'ok';
            } }
        else if($update->getStatus()==2)  {
            $update->setStatus("1");
            if($update->save()){
                $this->log($this->cookies->get('user'),$id,"pnotification","update");
                require APP_PATH.'/library/Mail.php';
                $order=Order::findFirst($update->getOrderId());
                $parse=json_decode($order->getMetaValue(),true);
                $test = Mail::odeme($update->getUserId(),$parse['code']);
                echo $test;
            }


        }

    }

}