<?php

namespace speedy\modules;

use \RedBeanPHP\R;

/**
 * Description of GetRacesForSpeciesModule
 *
 * @author boreas
 */
class GetRacesForSpeciesModule implements \speedy\common\Module {
    
    public function execute() {
        $speciesId = filter_input(INPUT_GET, 'species_id', FILTER_VALIDATE_INT);        
        if(!$speciesId){
            throw new \speedy\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $response = new \speedy\common\JsonResponse();
        $species = R::findOne('species', 'id = ?', [$speciesId]);
        if(!$species){
            throw new \speedy\controller\ControllerException("Es konnte keine Tierrasse mit der ID gefunden werden.");
        }
        $response->setJson(\speedy\controller\RacesController::getAllRacesFor($species->box()));
        return $response;
    }
}
