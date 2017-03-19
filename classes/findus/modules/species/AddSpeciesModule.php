<?php

namespace findus\modules\species;

/**
 * Description of AddSpeciesModule
 *
 * @author binary gamura
 */
class AddSpeciesModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        $speciesName = filter_input(INPUT_POST, 'species_name');
        if(!$speciesName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        $id = \findus\controller\SpeciesController::createNewSpecies(['species_name' => filter_input(INPUT_POST, 'species_name')]);
        return new \findus\common\JsonResponse(["id" => $id]);
    }
}
