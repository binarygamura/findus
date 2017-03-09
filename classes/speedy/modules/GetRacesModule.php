<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace speedy\modules;

/**
 * Description of GetRacesModule
 *
 * @author boreas
 */
class GetRacesModule implements \speedy\common\Module {
    
    public function execute() {
        $speciesId = filter_input(INPUT_GET, 'species_id', FILTER_VALIDATE_INT);
        if(!$speciesId){
            throw new \speedy\controller\ControllerException("Bitte eine ID angeben.");
        }
        $species = \speedy\controller\SpeciesController::getSpeciesById($speciesId);
        $response = new \speedy\common\JsonResponse();
        $response->setJson(["data" => \speedy\controller\RacesController::getAllRacesFor($species->box())]);
        return $response;
    }
}
