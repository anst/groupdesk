<?php

/*
 * A definition for a singleton instance of a database.
 * @author blacksmithgu
 */
class Database {
    private static $conn;
    private static $user = "root";
    private static $pass = "password";
    private static $db = "schollab";
    private static $host = "localhost";
    
    private static $query = null;
    
    private static function connect()
    {
        if(self::$conn != null) return;
        
        $con = mysqli_connect(self::$host, self::$user, self::$pass, self::$db);
        if(mysqli_connect_errno($con))
            return null;
        else
        {
            self::$conn = $con;
            return $con;
        }
    }
    
    public static function isAlive()
    {
        if(self::$conn == null) return false;
        return mysqli_ping(self::$conn);
    }
    
    public static function query($query)
    {
        if(self::$conn == null)
            if(self::connect() == null) return false;
        
        static::$query = $query;
            
        return mysqli_query(self::$conn, $query);
    }
    
    public static function last() {
        return static::$query;
    }
    
    public static function id() {
        return mysqli_insert_id(self::$conn);
    }
    
    public static function sanitize($str)
    {
        $str = stripslashes($str);
        if(self::$conn == null)
            if(self::connect() == null) return false;
            
        return mysqli_escape_string(self::$conn, $str);
    }
    
    public static function rtfSanitize($str)
    {
        return str_replace("'", "''", $str);
    }
}


?>
