<?php

namespace speedy\modules;

use \RedBeanPHP\R;

/**
 * Description of UpdateUserModule
 *
 * @author tierhilfe
 */
class UpdateUserModule implements \speedy\common\Module {
    
    public function execute() {
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $userName = filter_input(INPUT_POST, 'user_name', FILTER_VALIDATE_INT);
        if(!$userId){
            throw new \speedy\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $user = R::findOne('user', 'id = ?', [$userId]);
        if(!$user){
            throw new \speedy\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$userId." gefunden.");
        }
                \speedy\controller\UserController::updateUser([
            userId,
            'user_name' => filter_input(INPUT_POST, 'user_name'),
            'user_password' => filter_input(INPUT_POST, 'user_password'),
            'user_role' => filter_input(INPUT_POST, 'user_role')
            ]);

        $response = new \speedy\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
