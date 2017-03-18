<?php

namespace findus\modules\species;

/**
 * Description of AddRaceModule
 *
 * @author binary gamura
 */
class AddRaceModule implements \findus\common\Module{
    public function execute() {
        $raceName = filter_input(INPUT_POST, 'race_name');
        if(!$raceName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        $id = \findus\controller\RaceController::createNewRace([
            'race_name' => filter_input(INPUT_POST, 'race_name'),
            'species_id' => filter_input(INPUT_POST, 'species_id')
            ]);
        return new \findus\common\JsonResponse(["id" => $id]);
    }
}
