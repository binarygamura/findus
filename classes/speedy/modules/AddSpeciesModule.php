<?php

namespace speedy\modules;

/**
 * Description of AddSpeciesModule
 *
 * @author boreas
 */
class AddSpeciesModule implements \speedy\common\Module{
    
    public function execute() {
//        try{
        $speciesName = filter_input(INPUT_POST, 'species_name');
        if(!$speciesName){
            throw new \speedy\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \speedy\controller\SpeciesController::createNewSpecies(['species_name' => filter_input(INPUT_POST, 'species_name')]);
        $resonse = new \speedy\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
