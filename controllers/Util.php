<?php
 class Util
 {
    public static function isFieldEmpty($tab)
    {
        foreach ($tab as $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
    public static function isFielSet($source, $keys)
    {
        foreach ($keys as $value) {
            if(!isset($source[$value]))
                return false;
        }
        return true;
    }
    public static function isLoggedIn()
    {
        return isset($_SESSION["telephone"])  ;
    }


 }