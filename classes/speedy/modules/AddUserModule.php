<?php

namespace speedy\modules;

/**
 * Description of AddUserModule
 *
 * @author tierhilfe
 */
class AddUserModule implements \speedy\common\Module{
    
    public function execute() {
//        try{
        $userName = filter_input(INPUT_POST, 'user_name');
        if(!$userName){
            throw new \speedy\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        $userPassword = filter_input(INPUT_POST, 'user_password');
        if(!$userPassword){
            throw new \speedy\controller\ControllerException("Bitte geben Sie ein Passwort an.");
            
        }
        \speedy\controller\UserController::createNewUser([
            'user_name' => filter_input(INPUT_POST, 'user_name'),
            'user_password' => filter_input(INPUT_POST, 'user_password'),
            'user_role' => filter_input(INPUT_POST, 'user_role')
            ]);
        $resonse = new \speedy\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
