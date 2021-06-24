<?php

namespace Yabasi;

class Functions extends \Phalcon\Mvc\Model {
    public static function country($key) {
        $return = '';

        if (isset(self::$_phrases[$key]))
        {
            $return = self::$_phrases[$key];
        }

        return $return;
    }
}