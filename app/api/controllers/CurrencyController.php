<?php

namespace Yabasi\Api\Controllers;

use Yabasi\Currency;

class CurrencyController extends ControllerBase {

    public function indexAction() {

        $connect_web = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');

        foreach ($connect_web->Currency as $key) {
            $return="false";
            $kur      = mb_strtolower($key->attributes()->Kod);
            $buy      = get_object_vars($key->ForexBuying);
            $sell     = get_object_vars($key->ForexSelling);
            $unit     = get_object_vars($key->Unit);
            $currency = get_object_vars($key->Isim);

            $arr[] = array(
                'Kur' => mb_strtolower($key->attributes()->Kod),
                'Birim'=>implode($unit),
                'Cinsi'=>implode($currency),
                'kurAlis' => implode($buy),
                'kurSatis' => implode($sell)

            );

            $cur = Currency::findFirstByKur($kur);
            if ($cur){
                $cur->setKur($kur);
                $cur->setUnit(implode($unit));
                $cur->setName(implode($currency));
                $cur->setForexBuying(implode($buy));
                $cur->setForexSelling(implode($sell));
                $cur->setCreatedAt(time());
                $cur->setUpdatedAt(time());
                if ($cur->update()){
                    $return= "ok";
                }
            } else {
                $insert = new Currency();
                $insert->setKur($kur);
                $insert->setUnit(implode($unit));
                $insert->setName(implode($currency));
                $insert->setForexBuying(implode($buy));
                $insert->setForexSelling(implode($sell));
                $insert->setCreatedAt(time());
                $insert->setUpdatedAt(time());
                if ( $insert->save()){
                    $return= "ok";
                }else
                {
                    $key=$insert->getMessages();
                    foreach ($key as $a){
                        echo $a;
                    }

                }
            }
        }
        echo $return;

    }

    public function currencyAction($to = false, $from = false, $id = false) {

        $connect_web = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');

        foreach ($connect_web->Currency as $key) {

            $kur = mb_strtolower($key->attributes()->Kod);

            if ( $to == $kur && $from==false) {

                $buy = get_object_vars($key->ForexBuying);
                $sell = get_object_vars($key->ForexSelling);
                $unit =get_object_vars($key->Unit);
                $currency=get_object_vars($key->Isim);

                    $arr[] = array(
                        'from' => mb_strtolower($key->attributes()->Kod),
                        'to'=>'tl',
                        'Kur' => mb_strtolower($key->attributes()->Kod),
                        'Birim'=>implode($unit),
                        'Cinsi'=>implode($currency),
                        'kurAlis' => implode($buy),
                        'kurSatis' => implode($sell)
                    );

                    echo json_encode($arr);
            }

            if ($to == 'tl' && $from == $kur) {
                $buy = get_object_vars($key->ForexBuying)[0];
                $sell = get_object_vars($key->ForexSelling)[0];
                $unit =get_object_vars($key->Unit);
                $currency=get_object_vars($key->Isim);

                if (is_numeric($id)) {
                    echo "Alış:".$id * $buy ."  Satiş:".$id*$sell ;
                } else {

                    $arr[] = array(
                        'from'=>'tl',
                        'to' => mb_strtolower($key->attributes()->Kod),
                        'Kur' => mb_strtolower($key->attributes()->Kod),
                        'Birim'=>implode($unit),
                        'Cinsi'=>implode($currency),
                        'kurAlis' => $buy,
                        'kurSatis' => $sell


                    );
                    echo json_encode($arr);

                }
            }

            if ($to == $kur && $from == 'tl') {
                $buy = get_object_vars($key->ForexBuying)[0];
                $sell = get_object_vars($key->ForexSelling)[0];
                $unit =get_object_vars($key->Unit);
                $currency=get_object_vars($key->Isim);

                if (is_numeric($id)) {
                    echo "Alış:".$id / $buy ."  Satiş:".$id/$sell ;
                } else {

                    $arr[] = array(
                        'to'=>'tl',
                        'From' => mb_strtolower($key->attributes()->Kod),
                        'Kur' => mb_strtolower($key->attributes()->Kod),
                        'Birim'=>implode($unit),
                        'Cinsi'=>implode($currency),
                        'kurAlis' => $buy,
                        'kurSatis' => $sell


                    );
                    echo json_encode($arr);

                }
            }

        }

        if ($from == false && $to == false){

            foreach ($connect_web->Currency as $key) {

                $kur=mb_strtolower($key->attributes()->Kod);
                $buy = get_object_vars($key->ForexBuying);
                $sell = get_object_vars($key->ForexSelling);
                $unit =get_object_vars($key->Unit);
                $currency=get_object_vars($key->Isim);
                $arr[] = array(
                    'Kur' => mb_strtolower($key->attributes()->Kod),
                    'Birim'=>implode($unit),
                    'Cinsi'=>implode($currency),
                    'kurAlis' => implode($buy),
                    'kurSatis' => implode($sell)

                );
            }

            $insert=new Currency();
            $insert->setKur($kur);
            $insert->setUnit($unit);
            $insert->setName($currency);
            $insert->setForexBuying($buy);
            $insert->setForexSelling($sell);
            $insert->setCreatedAt(time());
            $insert->setUpdatedAt(time());
            $insert->save();
            echo json_encode($arr);
        }


    }

}
