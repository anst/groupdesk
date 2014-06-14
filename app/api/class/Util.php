<?php
/**
 * Provides utility methods for all files.
 *
 * @author blacksmithgu
 */
class Util {
    // Default definition of getRandomString() valid characters.
    public static $defaultValidChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    // Variables we can let people see.
    public static $safeMemberVariables = array("id", "user", "pc2password", "name", "phone", "email", "rank");
    // Variabels we can let people edit
    public static $editMemberVariables = array("user", "password", "pc2password", "name", "phone", "email", "rank");
    
    public static function createSalt()
    {
        return strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
    }
    
    public static function encrypt($str)
    {
        return crypt($str, '$2y$07$' . Util::createSalt()) ;
    }
    
    public static function verify($this,$against)
    {
        return crypt($this, $against) == $against;
    }
    
    public static function getRandomString($valid_chars, $length)
    {
        $random_string = "";
        $num_valid_chars = strlen($valid_chars);
        for ($i = 0; $i < $length; $i++)
        {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick-1];
            $random_string .= $random_char;
        }
        return $random_string;
    }
    
    public static function isSafeMemberVariable($str)
    {
        foreach(self::$safeMemberVariables as $check)
            if(strcmp($check, $str) == 0) return true;
        return false;
    }
    
    public static function isEditableMemberVariable($str)
    {
        foreach(self::$editMemberVariables as $check)
            if(strcmp($check, $str) == 0) return true;
        return false;
    }
    
    public static function regex($pattern, $str)
    {
        return preg_match("/^$pattern$/", $str);
    }
    
    public static function isNonNegativeInteger($str)
    {
        return self::regex("[0-9]+", $str);
    }
    
    public static function isInteger($str)
    {
        return self::regex("-?[0-9]+", $str);
    }
    
    public static function containsAll($arr, $search)
    {
        foreach($search as $val)
            if(!array_key_exists($val, $arr)) return false;
        return true;
    }
    
    public static function rankString($rankid)
    {
        switch($rankid)
        {
            case 0: return "Guest";
            case 1: return "Member";
            case 2: return "VIP";
            case 3: return "Officer";
            case 4: return "Moderator";
            case 5: return "Sponsor";
            case 6: return "Administrator";
        }
        return "Undefined";
    }
    
    public static function equals($arr, $key, $val)
    {
        if(!isset($arr[$key])) return false;
        return strcmp($arr[$key], $val) == 0;
    }
}

?>
