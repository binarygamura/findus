<?php

namespace speedy\modules;

/**
 * Description of AddRaceModule
 *
 * @author boreas
 */
class AddRaceModule implements \speedy\common\Module{
    public function execute() {
        $raceName = filter_input(INPUT_POST, 'race_name');
        if(!$raceName){
            throw new \speedy\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \speedy\controller\RacesController::createNewRace([
            'race_name' => filter_input(INPUT_POST, 'race_name'),
            'species_id' => filter_input(INPUT_POST, 'species_id')
            ]);
        $resonse = new \speedy\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
