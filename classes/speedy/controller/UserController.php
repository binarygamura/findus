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
        if(!isset($userData['user_name']) || trim($userData['user_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $name = trim($userData['user_name']);
        if(!isset($userData['user_password']) || trim($userData['user_password']) == ''){
            throw new ControllerException('Bitte eine Passwort angeben.');
        }
        if(!isset($userData['user_password']) || trim($userData['user_password']) == ''){
            throw new ControllerException('Bitte ein Passwort angeben.');
        }
        $password = trim($userData['user_password']);
        $newUser['username'] = $name;
        $newUser['password'] = $password;
        R::store($newUser);
    }
    
}

