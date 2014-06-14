<?php
require_once '../unirest/Unirest.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of School
 *
 * @author Miguel
 */
class School {
    private static $schools;
    
    public static function retrieve()
    {
        Unirest::verifyPeer(false);
        $response = Unirest::get(
            "https://community-local-school-database.p.mashape.com/schools.json",
            array(
              "X-Mashape-Authorization" => "STnCoinygNP4euJjfOsrGRsg5tRecI9p"
            ),
            null
          );
        
        $objs = $response->body->{'schools'};
        self::$schools = array();
        foreach ($objs as $key => $value)
        {
            self::$schools[$key] = $value->name; 
        }
    }
    
    public static function getMatchingSchools($str)
    {
        $match = array();
        foreach(self::$schools as $key => $value)
        {
            if(strpos($value,$str) === 0)
            {
                $match[$key] = $value;
            }
        }
        return $match;
    }
    
    
}
