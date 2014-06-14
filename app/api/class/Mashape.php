<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '\\app\\unirest\\Unirest.php');
Unirest::verifyPeer(false);
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
class Mashape {
    const API_KEY = "STnCoinygNP4euJjfOsrGRsg5tRecI9p";
    private static $schools;
    
    public static function retrieveSchools()
    {
        $response = Unirest::get(
            "https://community-local-school-database.p.mashape.com/schools.json",
            array(
              "X-Mashape-Authorization" => self::API_KEY
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
        if(strcmp($str,"") === 0)
            return self::$schools;
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
    
    public static function convertFile($filename, $data, $format = "pdf")
    {
        $user = User::current();
        if(!is_null($user))
            $user = $user->get('Email');
        else
            $user = "SERVER";
        $filename = $user . " " . $filename;
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "\\app\\files\\temp_" . $filename, $data);
        $response = Unirest::post(
            "https://community-docverter.p.mashape.com/convert",
            array(
              "X-Mashape-Authorization" => self::API_KEY
            ),
            array(
              "from" => "html",
              "to" => $format,
              "input_files[]" => "@" . $_SERVER['DOCUMENT_ROOT'] . "\\app\\files\\temp_" . $filename
            )
        );
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "\\app\\files\\" . $filename . "." . $format, $response->raw_body);
        unlink($_SERVER['DOCUMENT_ROOT'] . "\\app\\files\\temp_" . $filename);
        header($_SERVER['DOCUMENT_ROOT'] . "\\app\\files\\" . $filename . "." . $format);
        return "/app/files/" . $filename . "." . $format; 
    }
}
