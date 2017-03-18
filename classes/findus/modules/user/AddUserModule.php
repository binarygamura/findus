<?php

namespace findus\modules\user;

/**
 * Description of AddUserModule
 *
 * @author tierhilfe
 */
class AddUserModule implements \findus\common\Module{
    
    public function execute() {
//        try{
        $userName = filter_input(INPUT_POST, 'user_name');
        if(!$userName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        $userPassword = filter_input(INPUT_POST, 'user_password');
        if(!$userPassword){
            throw new \findus\controller\ControllerException("Bitte geben Sie ein Passwort an.");
            
        }
        \findus\controller\UserController::createNewUser([
            'user_name' => filter_input(INPUT_POST, 'user_name'),
            'user_password' => filter_input(INPUT_POST, 'user_password'),
            'user_role' => filter_input(INPUT_POST, 'user_role')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
