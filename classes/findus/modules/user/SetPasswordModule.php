<?php

/*
 * Copyright 2017 boreas.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace findus\modules\user;

/**
 * Description of SetPasswordModule
 *
 * @author binary gamura
 */
class SetPasswordModule extends \findus\common\AbstractModule {
    
    public function __construct() {
        $this->requiredRole = \findus\model\User::ADMIN;
    }

    
    public function execute() {
        if(isset($_POST)){
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            if(!$userId){
                throw new \findus\common\ModuleException('Es wurde keine ID angegeben.');
            }
            $password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING);
            if(!$password){
                throw new \findus\common\ModuleException('Es wurde kein Passwort angegeben.');
            }
            $passwordRepeat = filter_input(INPUT_POST, 'user_password_repeat', FILTER_SANITIZE_STRING);
            if(!$passwordRepeat){
                throw new \findus\common\ModuleException('Bitte wiederholen Sie das Passwort.');
            }
            if($password != $passwordRepeat){
                throw new \findus\common\ModuleException('Passwort und Wiederholung stimmen nicht überein.');
            }
            \findus\controller\UserController::setPassword([
                'user_id' => $userId, 
                'user_password' => $password]);
            return new \findus\common\JsonResponse(['status' => 'okay']);
        }
        else {
            throw new \findus\common\ModuleException('Verb nicht erlaubt.');
        }
    }
}
