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
    	return R::findAll('user');
    }

    public static function createNewUser(array $userData){
        $newUser = R::dispense('user');
        if(!isset($speciesData['user_name']) || trim($speciesData['user_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $name = trim($speciesData['user_name']);
        $matches = R::find('user', 'LOWER(username) = ?', [strtolower($name)]);
        if(count($matches) > 0){
            throw new ControllerException('Dieser Benutzer ist bereits vorhanden.');
        }
        $newSpecies['username'] = $speciesData['user_name'];
        R::store($newSpecies);
    }
    
}
