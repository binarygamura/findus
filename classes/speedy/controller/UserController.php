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
         $matches = R::find('user', 'username = ? AND password = ?', [$username, $password]);
         if(count($matches) == 0 || count($matches) > 1){
             return false;
         }
         return array_pop($matches);
    }
    
    public static function getGuestUser(){
        $matches = R::find('user', 'id = 1');
        if(count($matches) == 0 || count($matches) > 1){
             return false;
         }
         return array_pop($matches);
    }
    
    public static function getAllUsers(){
    	return R::findAll('users');
    }
    
}
