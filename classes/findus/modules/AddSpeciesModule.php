<?php

namespace findus\modules;

/**
 * Description of AddSpeciesModule
 *
 * @author binary gamura
 */
class AddSpeciesModule implements \findus\common\Module{
    
    public function execute() {
        $speciesName = filter_input(INPUT_POST, 'species_name');
        if(!$speciesName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        $id = \findus\controller\SpeciesController::createNewSpecies(['species_name' => filter_input(INPUT_POST, 'species_name')]);
        return new \findus\common\JsonResponse(["id" => $id]);
    }
}
