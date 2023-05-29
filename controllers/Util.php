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
    public static function checkEmpty($val)
    {
        return !empty($val);
    }
    public static function checkAnnee($annee) {
        if (!preg_match('/^\d{4}-\d{4}$/', $annee)) {
            return 0;
        }
        $annees = explode('-', $annee);
    
       
        if ($annees[1] - $annees[0] !== 1) {
            return 1;
        }
        return 2;
    }


 }