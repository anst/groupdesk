<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacebookManager
 *
 * @author Miguel
 */
class FacebookManager {
    public static function addRoutes($app) {
        $app->route("/api/facebook/redirect", function($app) {
            header('Location: ' . Facebook::getLoginUrl("http://sohacks-dev0.rhcloud.com/api/facebook/receive"));
        });
        
        $app->route("/api/facebook/receive", function($app) {
            Facebook::receiveLogin();
        });
        
        $app->route("/api/facebook/postlink", function($app) {
            Facebook::postLink();
        });
    }
}
