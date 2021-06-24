<?php

use Yabasi\Backend\Controllers\ControllerBase;
use Yabasi\Log;

class Logs extends ControllerBase {

    function log($user_id,$table_id,$table_name,$process) {
        $tables = array(
            'address',
            'settings',
            'bank',
            'content',
            'contentcats',
            'district',
            'cargo',
            'cats',
            'user',
            'usergroup',
            'quarter',
            'brand',
            'pnotification',
            'feature',
            'city',
            'town',
            'country',
            'variant',
            'comment',
            'auth',
            'product',
            'order',
            'tags'
        );

        if (in_array($table_name, $tables)) {
                if ($table_name && $table_id && $user_id && $process){

                    $insert = new Log();
                    $insert->setUserId($user_id);
                    $insert->setTableName($table_name);
                    $insert->setTableId($table_id);
                    $insert->setProcess($process);
                    $insert->setCreatedAt(self::getnow());
                    $insert->setUpdatedAt(self::getnow());

                    if ($insert->save()) {
                        $this->view->disable();
                    }

                }
        }
    }

}
