<?php

use Yabasi\Frontend\Controllers\ControllerBase;
use Yabasi\Points;
use Yabasi\Settings;
use Yabasi\User;

class Point extends ControllerBase {

    public static function set($user_id = false, $operation = false) {
        if (is_numeric($user_id) && $operation) {
            $operations = array('comment', 'register', 'advice', 'shopping');
            if (in_array($operation, $operations)) {

                $pointlist = Settings::findFirst('name="point"');
                if ($pointlist) {
                    $parse = json_decode($pointlist->getValue());
                    $settablepoint = 0;
                    if ($operation == 'comment') {
                        $settablepoint = $parse->comment_point;
                    } else if ($operation == 'register') {
                        $settablepoint = $parse->register_point;
                    } else if ($operation == 'advice') {
                        $settablepoint = $parse->advice_point;
                    } else if ($operation == 'shopping') {
                        $settablepoint = $parse->shopping_point;
                    }

                    $user = User::findFirst($user_id);
                    if ($user) {
                        $set = new Points();
                        $set->setUserId($user_id);
                        $set->setOperation($operation);
                        $set->setPoint($settablepoint);
                        $set->setCreatedAt((new Point)->getnow());
                        $set->setUpdatedAt((new Point)->getnow());
                        $set->setStatus(1);
                        $set->save();
                    }
                }

            }
        }
    }
}