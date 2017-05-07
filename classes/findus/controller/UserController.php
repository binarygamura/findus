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
            //TODO: move this to the installer script.
            // create default guest and admin
            $newGuestUser = R::dispense('user');
            $newGuestUser['username'] = 'Gast';
            $newGuestUser['password'] = 'Gast';
            $newGuestUser['role'] = 1;
            $newGuestUser['displayname'] = 'Gast';
            R::store($newGuestUser);
            $newAdminUser = R::dispense('user');
            $newAdminUser['username'] = 'admin';
            $newAdminUser['password'] = 'admin';
            $newAdminUser['role'] = 15;
            $newAdminUser['displayname'] = 'Admin';
            R::store($newAdminUser);
            
            $matches = R::find('user', 'id = 1');
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
    
    public static function setPassword(array $userData){
        if(!isset($userData['user_id']) || trim($userData['user_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        //TODO: implement some kind of password policy?
        if(!isset($userData['user_password']) || trim($userData['user_password']) == ''){
            throw new ControllerException('Bitte ein Passwort an.');
        }
        
        $user = R::findOne('user', 'id = ?', [$userData['user_id']]);
        if(!$user){
            throw new ControllerException("Es existiert kein Benutzer mit der ID ".$userData['user_id']);
        }
        $user['password'] = $userData['user_password'];
        R::store($user);
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
        $user = R::findOne('user', 'id = ?', [$id]);
        if(!$user){
            throw new ControllerException("Kein Benutzer mit der id ". $id . " gefunden.");
        }
        $role = trim($userData['user_role']);
        //TODO: display name is hard coded.
        $user['username'] = $name;
        $user['role'] = $role;
        $user['displayname'] = 'Mitarbeiter';
        R::store($user);
    }
}

