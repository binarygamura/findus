<?php

namespace speedy\modules;

use \RedBeanPHP\R;

/**
 * Description of DeleteRaceModule
 *
 * @author boreas
 */
class DeleteRaceModule implements \speedy\common\Module {
    
    public function execute() {
        $raceId = filter_input(INPUT_POST, 'race_id', FILTER_VALIDATE_INT);
        if(!$raceId){
            throw new \speedy\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $race = R::findOne('race', 'id = ? and state = \'ACTIVE\'', [$raceId]);
        if(!$race){
            throw new \speedy\controller\ControllerException("Es keine Rasse mit der ID ".$raceId." gefunden.");
        }
        $race->state = 'DELETED';
        R::store($race);
        $response = new \speedy\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
