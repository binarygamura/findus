<?php

namespace findus\modules;

/**
 * Description of AddRaceModule
 *
 * @author boreas
 */
class AddRaceModule implements \findus\common\Module{
    public function execute() {
        $raceName = filter_input(INPUT_POST, 'race_name');
        if(!$raceName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\RacesController::createNewRace([
            'race_name' => filter_input(INPUT_POST, 'race_name'),
            'species_id' => filter_input(INPUT_POST, 'species_id')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
