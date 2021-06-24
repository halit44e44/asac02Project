<?php

namespace Yabasi;

use Phalcon\Mvc\Model;
use Phalcon\Security;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mail extends Model {

    public static function sifirla($email = false) {
        if ($email) {
            $user = User::findFirst('email="' . $email . '"');
            if ($user) {
                $smtp_sunucu = Settings::findFirst('name="smtp_sunucu"');
                $smtp_port = Settings::findFirst('name="smtp_port"');
                $smtp_gonderim_tipi = Settings::findFirst('name="smtp_gonderim_tipi"');
                $smtp_kullaniciadi = Settings::findFirst('name="smtp_kullaniciadi"');
                $smtp_sifre = Settings::findFirst('name="smtp_sifre"');

                $logo = Images::findFirst('meta_key="theme_content/logo" and status=1');
                $firma = Settings::findFirst('name="sirket_adi"');
                $firma_adi = '';
                if ($firma) {
                    $firma_adi = $firma->getValue();
                }

                $site_url = Settings::findFirst('name="site_url"');
                $url = '';
                if ($site_url) {
                    $url = $site_url->getValue();
                }

                $random = new \Phalcon\Security\Random();
                $rand12 = $random->base64(6);

                $security = new Security();
                $yeni_sifre = $security->hash($rand12);

                if ($smtp_sunucu && $smtp_port && $smtp_gonderim_tipi && $smtp_kullaniciadi && $smtp_sifre) {
                    require '../vendor/autoload.php';



                    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                              <title>Şifremi unuttum</title>
                              <style>body {background-color: #FFFFFF; padding: 0; margin: 0;}</style>
                            </head>
                            <body style="background-color: #FFFFFF; padding: 0; margin: 0;">
                            <table border="0" cellpadding="0" cellspacing="10" height="100%" bgcolor="#FFFFFF" width="100%" style="max-width: 650px;" id="bodyTable">
                              <tr>
                                <td align="center" valign="top">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="font-family:Arial; color: #333333;">
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">
                                        <img alt="' . $firma_adi . '" border="0" src="' . $url . '/media/theme_content/logo/' . $logo->getMetaValue() . '" title="Oyos" class="sitelogo" width="60%" style="max-width:250px;" />
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                                        <span style="font-size: 18px; font-weight: normal;">Merhaba ' . $user->getName() . ',</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="padding-top: 10px;">
                                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">
                                            Şifre sıfırlama talebinde bulundunuz, geçici şifreniz aşağıda belirtilmiştir.
                                            <br/><br/>
                                          Yeni Şifreniz: <b>' . $rand12 . '</b>
                                          <br/><br/>
                                            Girşi yapmak için tıklayınız <a href="' . $url . '">' . $url . '</a>
                                            <br/><br/>
                                            ' . $firma_adi . ' Müşteri Hizmetleri
                                        </span>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            </body>
                            </html>';

                    $transport = (new Swift_SmtpTransport($smtp_sunucu->getValue(), $smtp_port->getValue()))
                        ->setUsername($smtp_kullaniciadi->getValue())
                        ->setPassword($smtp_sifre->getValue());
                    $mailer = new Swift_Mailer($transport);
                    $message = (new Swift_Message("Sifre Sifirla"))
                        ->setFrom([$smtp_kullaniciadi->getValue() => $firma_adi])
                        ->setTo([$email => $user->getName()])
                        ->setBody($html);
                    $message->setContentType("text/html");
                    $result = $mailer->send($message);
                    if ($result){
                        $user->setPassword($yeni_sifre);
                        $user->save();
                        echo "ok";
                    }
                } else {
                    return 'nosmtp';
                }
            } else {
                echo 'nouser';
            }
        }
    }

    public static function siparis($id = false, $order = false) {

        if ($id) {
            $user = User::findFirst($id);
            $email = $user->getEmail();
            if ($user && $order) {
                $smtp_sunucu = Settings::findFirst('name="smtp_sunucu"');
                $smtp_port = Settings::findFirst('name="smtp_port"');
                $smtp_gonderim_tipi = Settings::findFirst('name="smtp_gonderim_tipi"');
                $smtp_kullaniciadi = Settings::findFirst('name="smtp_kullaniciadi"');
                $smtp_sifre = Settings::findFirst('name="smtp_sifre"');

                $logo = Images::findFirst('meta_key="theme_content/logo" and status=1');
                $firma = Settings::findFirst('name="sirket_adi"');
                $firma_adi = '';
                if ($firma) {
                    $firma_adi = $firma->getValue();
                }

                $site_url = Settings::findFirst('name="site_url"');
                $url = '';
                if ($site_url) {
                    $url = $site_url->getValue();
                }
                $siparis = "";

                if ($smtp_sunucu && $smtp_port && $smtp_gonderim_tipi && $smtp_kullaniciadi && $smtp_sifre) {
                    require '../vendor/autoload.php';

                    $orders = Order::findFirst($order);
                    if ($orders->getMetaKey() == "order") {
                        $parse = json_decode($orders->getMetaValue(), true);
                        $cargo_name = '';
                        if ($parse['cargo'] != null) {
                            $cargo = Cargo::findFirst($parse['cargo']);
                            $cargo_name = $cargo->getName();
                        }
                        $payment = Paymenttype::findFirst($parse['payment_type']);
                        $html = "";
                        $Ordertype = Ordertype::findFirst($orders->getOrderStatus());
                        $html .= '	<div style="width:800px; float:left;">
	    
                                        <img style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px alt="' . $firma_adi . '" border="0" src="' . $url . '/media/theme_content/logo/' . $logo->getMetaValue() . '" title="Oyos" class="sitelogo" width="60%" style="max-width:250px;" />
                                    
		<H3 style="font-family: Tahoma;">' . $Ordertype->getName() . '</H3>

		<!--siparis bilgileri-->
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th colspan="2" style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Sipariş Detayları</th>
			</tr>

			<tr style="border: 1px solid #ddd; padding:8px;">
				<td style="border: 1px solid #ddd; padding:8px;">
					<b>Siparis ID:</b> ' . $parse['code'] . '<br />
					<b>Siparis Tarih:</b> ' . date('d.m.Y H:i:s', $orders->getCreatedAt()) . '<br />
					<b>Odeme Metodu:</b> ' . $payment->getName() . '<br />
					<b>Kargo:</b> ' . $cargo_name . '<br />
					<b>Kargo Takip Numarası:</b> ' . $orders->getCargoNumber() . '<br />
				</td>
				<td style="border: 1px solid #ddd; padding:8px;">
					<b>İsim Soyisim:</b> ' . $user->getName() . '<br />
					<b>E-Mail</b> ' . $user->getEmail() . '<br />
					<b>Telefon</b> ' . $user->getPhone() . '<br />
				</td>
			</tr>
		</table>
		<!--siparis bilgileri biter-->

		<!--siparis notu-->
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Sipariş Notu</th>
			</tr>

			<tr style="border: 1px solid #ddd; padding:8px;">
				<td style="border: 1px solid #ddd; padding:8px;">
					' . $parse['gift_note'] . '
				</td>
			</tr>
		</table>        
		<!--siparis notu biter-->

		<!--adres bilgileri-->
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Teslimat Adresi</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Fatura Adresi</th>
			</tr>

			<tr style="border: 1px solid #ddd; padding:8px;">
				<td style="border: 1px solid #ddd; padding:8px;">
					TESLIMATADRES <b>' . $parse['delivery_address'] . '</b>
				</td>
				<td style="border: 1px solid #ddd; padding:8px;">
					FATURAADRES <b>' . $parse['invoice_address'] . '</b>
				</td>
			</tr>
		</table>
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Ürün</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Adet</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Fiyatı</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Toplam</th>
			</tr>';

                        $orderss = Order::find('top_id=' . $orders->getId());

                        foreach ($orderss as $orderss) {
                            $json = json_decode($orderss->getMetaValue(), true);

                            $html .= '<tr style="border: 1px solid #ddd; padding:8px;">
				            <td style="border: 1px solid #ddd; padding:8px;">' . $json['name'] . ' ';
                            if ($json['variant']) {
                                $variant = explode(",", $json['variant']);
                                foreach ($variant as $item) {
                                    $name = Variant::findFirst($item);
                                    $ana = Variant::findFirst($name->getTopId());
                                    $html .= '<br><span>' . $ana->getName() . ':' . $name->getName() . '</span>';
                                }

                            }


                            $aratoplam = $orders->getTotalPrice() - (float)$parse['cargo_price'];
                            $html .= '</td>
                                    <td style="border: 1px solid #ddd; padding:8px;">' . $orderss->getPiece() . '</td>
                                    <td style="border: 1px solid #ddd; padding:8px;"> ' . $orderss->getTotalPrice() . '</td>
                                    <td style="border: 1px solid #ddd; padding:8px;">' . $orderss->getTotalPrice() * $orderss->getPiece() . '</td>';
                                            }


                                            $html .= '<tr style="border: 1px solid #ddd; padding:8px;">
                                <td style="border: 1px solid #ddd; padding:8px;" colspan="3"><b>Ara Toplam</b> </td>
                                    <td style="border: 1px solid #ddd; padding:8px;">' . $aratoplam . ' ' . $orders->getCurrency() . '</td>
                                    
                                </tr>
                                    <tr style="border: 1px solid #ddd; padding:8px;">
                                    <td style="border: 1px solid #ddd; padding:8px;" colspan="3"><b>Kargo Fiyat</b> </td>
                                    <td style="border: 1px solid #ddd; padding:8px;">' . $parse['cargo_price'] . ' ' . $orders->getCurrency() . '</td>
                                </tr>
                                </tr>
                                    <tr style="border: 1px solid #ddd; padding:8px;">
                                    <td style="border: 1px solid #ddd; padding:8px;" colspan="3"><b>Toplam Fiyat</b> </td>
                                    <td style="border: 1px solid #ddd; padding:8px;">' . $orders->getTotalPrice() . ' ' . $orders->getCurrency() . '</td>
                                </tr>
                            </table>
                            <!--urunler-->
                        </div>';

                    }

                    if ($orders->getMetaKey() == "products") {
                        $orderss = Order::findFirst($orders->getTopId());
                        $parse = json_decode($orderss->getMetaValue(), true);

                        $cargo_name = '';
                        if ($parse['cargo'] != null) {
                            $cargo = Cargo::findFirst($parse['cargo']);
                            $cargo_name = $cargo->getName();
                        }
                        $payment = Paymenttype::findFirst($parse['payment_type']);
                        $html = "";
                        $Ordertype = Ordertype::findFirst($orders->getOrderStatus());
                        $html .= '	<div style="width:800px; float:left;">
	    
                                        <img style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px alt="' . $firma_adi . '" border="0" src="' . $url . '/media/theme_content/logo/' . $logo->getMetaValue() . '" title="Oyos" class="sitelogo" width="60%" style="max-width:250px;" />
                                    
		<H3 style="font-family: Tahoma;">' . $Ordertype->getName() . '</H3>

		<!--siparis bilgileri-->
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th colspan="2" style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Sipariş Detayları</th>
			</tr>

			<tr style="border: 1px solid #ddd; padding:8px;">
				<td style="border: 1px solid #ddd; padding:8px;">
					<b>Siparis ID:</b> ' . $parse['code'] . '<br />
					<b>Siparis Tarih:</b> ' . date('d.m.Y H:i:s', $orders->getCreatedAt()) . '<br />
					<b>Odeme Metodu:</b> ' . $payment->getName() . '<br />
					<b>Kargo:</b> ' . $cargo_name . '<br />
					<b>Kargo Takip Numarası:</b> ' . $orders->getCargoNumber() . '<br />
				</td>
				<td style="border: 1px solid #ddd; padding:8px;">
					<b>İsim Soyisim:</b> ' . $user->getName() . '<br />
					<b>E-Mail</b> ' . $user->getEmail() . '<br />
					<b>Telefon</b> ' . $user->getPhone() . '<br />
				</td>
			</tr>
		</table>
		<!--siparis bilgileri biter-->

		<!--siparis notu-->
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Sipariş Notu</th>
			</tr>

			<tr style="border: 1px solid #ddd; padding:8px;">
				<td style="border: 1px solid #ddd; padding:8px;">
					' . $parse['gift_note'] . '
				</td>
			</tr>
		</table>        
		<!--siparis notu biter-->

		<!--adres bilgileri-->
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Teslimat Adresi</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Fatura Adresi</th>
			</tr>

			<tr style="border: 1px solid #ddd; padding:8px;">
				<td style="border: 1px solid #ddd; padding:8px;">
					TESLIMATADRES <b>' . $parse['delivery_address'] . '</b>
				</td>
				<td style="border: 1px solid #ddd; padding:8px;">
					FATURAADRES <b>' . $parse['invoice_address'] . '</b>
				</td>
			</tr>
		</table>
		<table style="border-collapse: collapse; box-sizing:border-box; width:800px; float:left; font-family: Tahoma; float:left; margin-bottom:20px;">
			<tr style="border: 1px solid #ddd; padding:8px;">
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Ürün</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Adet</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Fiyatı</th>
				<th style="padding-top:12px; padding-bottom:12px; padding-left:8px; padding-right:8px; border: 1px solid #ddd; background-color: #efefef; text-align:left;">Toplam</th>
			</tr>';

                        $json = json_decode($orders->getMetaValue(), true);

                        $html .= '<tr style="border: 1px solid #ddd; padding:8px;">
                        <td style="border: 1px solid #ddd; padding:8px;">' . $json['name'] . ' ';
                        if ($json['variant']) {
                            $variant = explode(",", $json['variant']);
                            foreach ($variant as $item) {
                                $name = Variant::findFirst($item);
                                $ana = Variant::findFirst($name->getTopId());
                                $html .= '<br><span>' . $ana->getName() . ':' . $name->getName() . '</span>';
                            }

                        }


                        $aratoplam = $orders->getTotalPrice() - (float)$parse['cargo_price'];
                        $html .= '</td>
                                <td style="border: 1px solid #ddd; padding:8px;">' . $orders->getPiece() . '</td>
                                <td style="border: 1px solid #ddd; padding:8px;"> ' . $orders->getTotalPrice() . '</td>
                                <td style="border: 1px solid #ddd; padding:8px;">' . $orders->getTotalPrice() * $orderss->getPiece() . '</td>';


                                        $html .= '<tr style="border: 1px solid #ddd; padding:8px;">
                            <td style="border: 1px solid #ddd; padding:8px;" colspan="3"><b>Ara Toplam</b> </td>
                                <td style="border: 1px solid #ddd; padding:8px;">' . $aratoplam . ' ' . $orders->getCurrency() . '</td>
                                
                            </tr>
                                <tr style="border: 1px solid #ddd; padding:8px;">
                                <td style="border: 1px solid #ddd; padding:8px;" colspan="3"><b>Kargo Fiyat</b> </td>
                                <td style="border: 1px solid #ddd; padding:8px;">' . $parse['cargo_price'] . ' ' . $orders->getCurrency() . '</td>
                            </tr>
                            </tr>
                                <tr style="border: 1px solid #ddd; padding:8px;">
                                <td style="border: 1px solid #ddd; padding:8px;" colspan="3"><b>Toplam Fiyat</b> </td>
                                <td style="border: 1px solid #ddd; padding:8px;">' . $orders->getTotalPrice() . ' ' . $orders->getCurrency() . '</td>
                            </tr>
                        </table>
                        <!--urunler-->
                    </div>';

                    }
                    $transport = (new Swift_SmtpTransport($smtp_sunucu->getValue(), $smtp_port->getValue()))
                        ->setUsername($smtp_kullaniciadi->getValue())->setPassword($smtp_sifre->getValue());
                    $mailer = new Swift_Mailer($transport);
                    $message = (new Swift_Message($firma_adi . " " . $Ordertype->getName()))
                        ->setFrom([$smtp_kullaniciadi->getValue() => $firma_adi])
                        ->setTo([$email => $user->getName()])
                        ->setBody($html);

                    $message->setContentType("text/html");
                    $result = $mailer->send($message);
                    if ($result){
                        return true;
                    } else {return false;}

                } else {
                    return 'nosmtp';
                }
            } else {
                echo 'nouser';
            }
        }

    }

    public static function odeme($id = false, $code = false) {
        $user = User::findFirst($id);
        $email = $user->getEmail();
        if ($email && $code) {

            if ($user) {
                $smtp_sunucu = Settings::findFirst('name="smtp_sunucu"');
                $smtp_port = Settings::findFirst('name="smtp_port"');
                $smtp_gonderim_tipi = Settings::findFirst('name="smtp_gonderim_tipi"');
                $smtp_kullaniciadi = Settings::findFirst('name="smtp_kullaniciadi"');
                $smtp_sifre = Settings::findFirst('name="smtp_sifre"');

                $logo = Images::findFirst('meta_key="theme_content/logo" and status=1');
                $firma = Settings::findFirst('name="sirket_adi"');
                $firma_adi = '';
                if ($firma) {
                    $firma_adi = $firma->getValue();
                }

                $site_url = Settings::findFirst('name="site_url"');
                $url = '';
                if ($site_url) {
                    $url = $site_url->getValue();
                }

                $random = new \Phalcon\Security\Random();
                $rand12 = $random->base64(12);

                $security = new Security();
                $yeni_sifre = $security->hash($rand12);

                if ($smtp_sunucu && $smtp_port && $smtp_gonderim_tipi && $smtp_kullaniciadi && $smtp_sifre) {
                    require '../vendor/autoload.php';



                    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                              <title>ÖDEME ONAY</title>
                              <style>body {background-color: #FFFFFF; padding: 0; margin: 0;}</style>
                            </head>
                            <body style="background-color: #FFFFFF; padding: 0; margin: 0;">
                            <table border="0" cellpadding="0" cellspacing="10" height="100%" bgcolor="#FFFFFF" width="100%" style="max-width: 650px;" id="bodyTable">
                              <tr>
                                <td align="center" valign="top">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="font-family:Arial; color: #333333;">
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">
                                        <img alt=  alt="' . $firma_adi . '" border="0" src="' . $url . '/media/theme_content/logo/' . $logo->getMetaValue() . '" title="Oyos" class="sitelogo" width="60%" style="max-width:250px;" />
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                                        <span style="font-size: 18px; font-weight: normal;">Merhaba ' . $user->getName() . ',</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="padding-top: 10px;">
                                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">
                                         ' . $code . '  takip numaralı siparişiniz için ödemeniz  onaylandı.
                                            <br/><br/>
                                        Girşi yapmak için tıklayınız <a href="' . $url . '">' . $url . '</a>
                                            <br/><br/>
                                            ' . $firma_adi . ' Müşteri Hizmetleri
                                        </span>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            </body>
                            </html>';

                    $transport = (new Swift_SmtpTransport($smtp_sunucu->getValue(), $smtp_port->getValue()))
                        ->setUsername($smtp_kullaniciadi->getValue())
                        ->setPassword($smtp_sifre->getValue());
                    $mailer = new Swift_Mailer($transport);
                    $message = (new Swift_Message('Odeme Onay'))
                        ->setFrom([$smtp_kullaniciadi->getValue() => $firma_adi])
                        ->setTo([$email => $user->getName()])
                        ->setBody($html);
                    $message->setContentType("text/html");
                    $result = $mailer->send($message);
                    if ($result){

                    }

                } else {
                    return 'nosmtp';
                }
            } else {
                echo 'nouser';
            }
        }
    }

    public static function sifre($email = false, $pass) {
        if ($email) {
            $user = User::findFirst('email="' . $email . '"');
            if ($user) {
                $smtp_sunucu = Settings::findFirst('name="smtp_sunucu"');
                $smtp_port = Settings::findFirst('name="smtp_port"');
                $smtp_gonderim_tipi = Settings::findFirst('name="smtp_gonderim_tipi"');
                $smtp_kullaniciadi = Settings::findFirst('name="smtp_kullaniciadi"');
                $smtp_sifre = Settings::findFirst('name="smtp_sifre"');

                $logo = Images::findFirst('meta_key="theme_content/logo" and status=1');
                $firma = Settings::findFirst('name="sirket_adi"');
                $firma_adi = '';
                if ($firma) {
                    $firma_adi = $firma->getValue();
                }

                $site_url = Settings::findFirst('name="site_url"');
                $url = '';
                if ($site_url) {
                    $url = $site_url->getValue();
                }

                $random = new \Phalcon\Security\Random();
                $rand12 = $random->base64(12);

                $security = new Security();


                if ($smtp_sunucu && $smtp_port && $smtp_gonderim_tipi && $smtp_kullaniciadi && $smtp_sifre) {
                    require '../vendor/autoload.php';

                    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                              <title>Sifre</title>
                              <style>body {background-color: #FFFFFF; padding: 0; margin: 0;}</style>
                            </head>
                            <body style="background-color: #FFFFFF; padding: 0; margin: 0; ">
                            <table border="0" cellpadding="0" cellspacing="10" height="100%" bgcolor="#FFFFFF" width="100%" style="max-width: 650px;" id="bodyTable">
                              <tr>
                                <td align="center" valign="top">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="font-family:Arial; color: #333333;">
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">
                                        <img alt="' . $firma_adi . '" border="0" src="' . $url . '/media/theme_content/logo/' . $logo->getMetaValue() . '" title="Oyos" class="sitelogo" width="60%" style="max-width:250px;" />
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                                        <span style="font-size: 18px; font-weight: normal;">Merhaba ' . $user->getName() . ',</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="padding-top: 10px;">
                                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">
                                           
                                           <br/><br/>
                                          Yeni Sifreniz: <b>' . $pass . '</b>
                                          <br/><br/>
                                            Giris yapmak icin tiklayiniz <a href="' . $url . '">' . $url . '</a>
                                            <br/><br/>
                                            ' . $firma_adi . ' Musteri Hizmetleri
                                        </span>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            </body>
                            </html>';

                    $transport = (new Swift_SmtpTransport($smtp_sunucu->getValue(), $smtp_port->getValue()))
                        ->setUsername($smtp_kullaniciadi->getValue())
                        ->setPassword($smtp_sifre->getValue());
                    $mailer = new Swift_Mailer($transport);
                    $message = (new Swift_Message('Yeni-Sifreniz '.$firma_adi))
                        ->setFrom([$smtp_kullaniciadi->getValue() => $firma_adi])
                        ->setTo([$email => $user->getName()])
                        ->setBody($html);
                    $message->setContentType("text/html");
                    $result = $mailer->send($message);
                    if ($result){
                    }
                } else {
                    return 'nosmtp';
                }
            } else {
                echo 'nouser';
            }
        }
    }

    public static function product($product = false) {
        if ($product) {
            $request = Request::find('product_id=' . $product . " and status=1");
            foreach ($request as $request) {
                $user = User::findFirst($request->getUserId());
                $email = $user->getEmail();
                $pro = Product::findFirst($product);
                $smtp_sunucu = Settings::findFirst('name="smtp_sunucu"');
                $smtp_port = Settings::findFirst('name="smtp_port"');
                $smtp_gonderim_tipi = Settings::findFirst('name="smtp_gonderim_tipi"');
                $smtp_kullaniciadi = Settings::findFirst('name="smtp_kullaniciadi"');
                $smtp_sifre = Settings::findFirst('name="smtp_sifre"');

                $logo = Images::findFirst('meta_key="theme_content/logo" and status=1');
                $firma = Settings::findFirst('name="sirket_adi"');
                $firma_adi = '';
                if ($firma) {
                    $firma_adi = $firma->getValue();
                }

                $site_url = Settings::findFirst('name="site_url"');
                $url = '';
                if ($site_url) {
                    $url = $site_url->getValue();
                }
                if ($smtp_sunucu && $smtp_port && $smtp_gonderim_tipi && $smtp_kullaniciadi && $smtp_sifre) {
                    require '../vendor/autoload.php';

                    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                              <title>Beklediğiniz ürün stoklarımıza geldi-' . $firma_adi . '</title>
                              <style>body {background-color: #FFFFFF; padding: 0; margin: 0;}</style>
                            </head>
                            <body style="background-color: #FFFFFF; padding: 0; margin: 0; ">
                            <table border="0" cellpadding="0" cellspacing="10" height="100%" bgcolor="#FFFFFF" width="100%" style="max-width: 650px;" id="bodyTable">
                              <tr>
                                <td align="center" valign="top">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="font-family:Arial; color: #333333;">
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">
                                        <img alt="' . $firma_adi . '" border="0" src="' . $url . '/media/theme_content/logo/' . $logo->getMetaValue() . '" title="Oyos" class="sitelogo" width="60%" style="max-width:250px;" />
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                                        <span style="font-size: 18px; font-weight: normal;">Merhaba ' . $user->getName() . ',</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" colspan="2" style="padding-top: 10px;">
                                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">
                                           
                                           <br/><br/>
                                          Ürün talebinde bulunduğunuz ' . $pro->getName() . ' ürünü artık stoklarımızda. Tükenmeden hemen inceleyin.
                                          <br/><br/>
                                            Ürünü incelemek icin tiklayiniz <a href="' . $url . "/urun/" . $pro->getSef() . '">' . $url . "/urun/" . $pro->getSef() . '</a>
                                            <br/><br/>
                                            ' . $firma_adi . ' Musteri Hizmetleri
                                        </span>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            </body>
                            </html>';

                    $transport = (new Swift_SmtpTransport($smtp_sunucu->getValue(), $smtp_port->getValue()))
                        ->setUsername($smtp_kullaniciadi->getValue())
                        ->setPassword($smtp_sifre->getValue());
                    $mailer = new Swift_Mailer($transport);
                    $message = (new Swift_Message('Beklediğiniz ürün stoklarımıza geldi-' . $firma_adi))
                        ->setFrom([$smtp_kullaniciadi->getValue() => $firma_adi])
                        ->setTo([$email => $user->getName()])
                        ->setBody($html);
                    $message->setContentType("text/html");
                    $result = $mailer->send($message);
                    if ($result) {
                        $request->setStatus(2);
                        $request->save();
                    }

                } else {
                    return 'nosmtp';
                }
            }
        } else {
            echo 'nouser';
        }
    }
}