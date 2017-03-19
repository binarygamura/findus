<?php

namespace findus\modules\user;

use \RedBeanPHP\R;

/**
 * Description of UpdateUserModule
 *
 * @author tierhilfe
 */
class UpdateUserModule implements \findus\common\Module {
    
    public function execute() {
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if(!$userId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $user = R::findOne('user', 'id = ?', [$userId]);
        if(!$user){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$userId." gefunden.");
        }
                \findus\controller\UserController::updateUser([
            'user_id' => $userId,
            'user_name' => filter_input(INPUT_POST, 'user_name'),
            'user_password' => filter_input(INPUT_POST, 'user_password'),
            'user_role' => filter_input(INPUT_POST, 'user_role')
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
