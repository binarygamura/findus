<?php

namespace findus\modules\user;

use \RedBeanPHP\R;

/**
 * Description of DeleteRaceModule
 *
 * @author binary gamura
 */
class DeleteUserModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::ADMIN;
    }
    
    public function execute() {
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if(!$userId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $user = R::findOne('user', 'id = ?', [$userId]);
        if(!$user){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$userId." gefunden.");
        }
        R::trash($user);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
