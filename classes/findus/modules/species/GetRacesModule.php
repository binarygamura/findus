<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace findus\modules\species;

/**
 * Description of GetRacesModule
 *
 * @author binary gamura
 */
class GetRacesModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        $speciesId = filter_input(INPUT_GET, 'species_id', FILTER_VALIDATE_INT);
        if(!$speciesId){
            throw new \findus\controller\ControllerException("Bitte eine ID angeben.");
        }
        $species = \findus\controller\SpeciesController::getSpeciesById($speciesId);
        
        
        $response = new \findus\common\JsonResponse();
        $response->setJson(["data" => \findus\controller\RaceController::getAllRacesFor($species->box())]);
        return $response;
    }
}
