<?php

namespace findus\modules\species;

use \RedBeanPHP\R;

/**
 * Description of DeleteRaceModule
 *
 * @author binary gamura
 */
class DeleteRaceModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        $raceId = filter_input(INPUT_POST, 'race_id', FILTER_VALIDATE_INT);
        if(!$raceId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $race = R::findOne('race', 'id = ? and state = \'ACTIVE\'', [$raceId]);
        if(!$race){
            throw new \findus\controller\ControllerException("Es keine Rasse mit der ID ".$raceId." gefunden.");
        }
        $race->state = 'DELETED';
        R::store($race);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
