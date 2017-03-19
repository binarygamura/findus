<?php

namespace findus\modules\species;

use \RedBeanPHP\R;

/**
 * Description of UpdateRaceModule
 *
 * @author tierhilfe
 */
class UpdateRaceModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        $raceId = filter_input(INPUT_POST, 'race_id', FILTER_VALIDATE_INT);
        $raceName = filter_input(INPUT_POST, 'race_name');
        if(!$raceId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $race = R::findOne('race', 'id = ?', [$raceId]);
        if(!$race){
            throw new \findus\controller\ControllerException("Es wurde keine Rasse mit der ID ".$raceId." gefunden.");
        }
        \findus\controller\RaceController::updateRace([
            'race_id' => $raceId,
            'race_name' => $raceName
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
