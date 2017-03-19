<?php

namespace findus\controller;

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
    
    public static function getUserByUsername($username){
         $matches = R::find('user', 'username = ?', [$username]);
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
            throw new ControllerException('Bitte ein Passwort angeben.');
        }
        $password = trim($userData['user_password']);
        $role = trim($userData['user_role']);
        $newUser['username'] = $name;
        $newUser['password'] = $password;
        $newUser['role'] = $role;
        $newUser['displayname'] = 'Mitarbeiter';
        R::store($newUser);
    }
    
    public static function updateUser(array $userData){
        if(!isset($userData['user_id']) || trim($userData['user_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($userData['user_name']) || trim($userData['user_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $name = trim($userData['user_name']);
        $id = trim($userData['user_id']);
        if(!isset($userData['user_password']) || trim($userData['user_password']) == ''){
            throw new ControllerException('Bitte ein Passwort angeben.');
        }
        $user = R::findOne('user', 'id = ?', [$id]);
        if(!$user){
            throw new ControllerException("Kein Benutzer mit der id ". $id . " gefunden.");
        }
        $password = trim($userData['user_password']);
        $role = trim($userData['user_role']);
        $user['username'] = $name;
        $user['password'] = $password;
        $user['role'] = $role;
        $user['displayname'] = 'Mitarbeiter';
        R::store($user);
    }
    
}

