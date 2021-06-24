<?php


use Yabasi\Frontend\Controllers\ControllerBase;
use Yabasi\Log;

class Kayit extends ControllerBase {
    function log($user_id,$table_id,$table_name,$process) {
        $tables = array(
            'user',
            'order'
        );

        if (in_array($table_name, $tables)) {
            if ($table_name && $process){

                $insert = new Log();
                $insert->setUserId($user_id);
                $insert->setTableName($table_name);
                $insert->setTableId($table_id);
                $insert->setProcess($process);
                $insert->setCreatedAt(self::getnow());
                $insert->setUpdatedAt(self::getnow());

                if ($insert->save()) {

                }

            }
        }
    }
}