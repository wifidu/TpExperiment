<?php


namespace app\common;


class Md5
{
    protected  static $salt = 'wifi';

    public static function Make($value,$addSalt = null){
        $salt = isset($addSalt) ? $addSalt : self::$salt;
        return md5(md5($value) . $salt);
    }

    public static function Check($value,$hashedValue,$addSalt = null){
        if (strlen($hashedValue) === 0) {
            return false;
        }
        $salt = isset($addSalt) ? $addSalt : self::$salt;
        return md5(md5($value) . $salt) == $hashedValue;
    }
}