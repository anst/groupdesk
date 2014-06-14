<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/api/autoloader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/facebook/Facebook/FacebookSession.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/facebook/Facebook/FacebookRedirectLoginHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/facebook/Facebook/FacebookRequest.php';
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facebook
 *
 * @author Miguel
 */
class Facebook {
    
    private static $session;
    
    public static function getLoginUrl($url)
    {
        FacebookSession::setDefaultApplication('570031006442862', 'b5df7174129718449f9db92719f435fd');
        $helper = new FacebookRedirectLoginHelper($url);
        $loginUrl = $helper->getLoginUrl() . "email,publish_stream,read_stream";
        return $loginUrl;
    }
    
    public static function receiveLogin()
    {
        $helper = new FacebookRedirectLoginHelper();
        try {
          self::$session = $helper->getSessionFromRedirect();
        } catch(FacebookRequestException $ex) {
          // When Facebook returns an error
        } catch(\Exception $ex) {
          // When validation fails or other local issues
        }
    }
    
    public static function postLink()
    {
        if(self::$session) {
            try {
              $response = (new FacebookRequest(
                $session, 'POST', '/me/feed', array(
                  'link' => 'www.facebook.com',
                  'message' => 'This is a test of Schollab or Groupdesk please ignore'
                )
              ))->execute()->getGraphObject();

              echo "Posted with id: " . $response->getProperty('id');

            } catch(FacebookRequestException $e) {

              echo "Exception occured, code: " . $e->getCode();
              echo " with message: " . $e->getMessage();

            }   
        }
    }
}
