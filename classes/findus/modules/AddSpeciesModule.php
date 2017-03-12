<?php

namespace findus\modules;

/**
 * Description of AddSpeciesModule
 *
 * @author boreas
 */
class AddSpeciesModule implements \findus\common\Module{
    
    public function execute() {
        $speciesName = filter_input(INPUT_POST, 'species_name');
        if(!$speciesName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\SpeciesController::createNewSpecies(['species_name' => filter_input(INPUT_POST, 'species_name')]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
