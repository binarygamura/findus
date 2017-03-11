<?php

namespace speedy\modules;

use \RedBeanPHP\R;

/**
 * Description of DeleteRaceModule
 *
 * @author boreas
 */
class DeleteUserModule implements \speedy\common\Module {
    
    public function execute() {
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if(!$userId){
            throw new \speedy\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $user = R::findOne('user', 'id = ?', [$userId]);
        if(!$user){
            throw new \speedy\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$userId." gefunden.");
        }
        R::trash($user);
        $response = new \speedy\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
