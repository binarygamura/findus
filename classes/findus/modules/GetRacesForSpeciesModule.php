<?php

namespace findus\modules;

use \RedBeanPHP\R;

/**
 * Description of GetRacesForSpeciesModule
 *
 * @author binary gamura
 */
class GetRacesForSpeciesModule implements \findus\common\Module {
    
    public function execute() {
        $speciesId = filter_input(INPUT_GET, 'species_id', FILTER_VALIDATE_INT);        
        if(!$speciesId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $response = new \findus\common\JsonResponse();
        $species = R::findOne('species', 'id = ? AND state = \'ACTIVE\'', [$speciesId]);
        if(!$species){
            throw new \findus\controller\ControllerException("Es konnte keine Tierrasse mit der ID gefunden werden.");
        }
        $response->setJson(\findus\controller\RacesController::getAllRacesFor($species->box()));
        return $response;
    }
}
