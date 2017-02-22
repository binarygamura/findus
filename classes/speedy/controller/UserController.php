<?php

namespace speedy\controller;

use \RedBeanPHP\R;

class UserController{
    
    /**
     * TODO: salt the password and store the hash!
     * 
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public static function getUserByUsernameAndPassword($username, $password){
         $matches = R::find("user", "username = ? AND password = ?", [$username, $password]);
         if(count($matches) == 0 || count($matches) > 1){
             return false;
         }
         return $matches[1];
    }
}
