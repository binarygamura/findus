<?php

namespace findus\modules\veterinarian;

/**
 * Description of AddVeterinarianModule
 *
 * @author tierhilfe
 */
class AddVeterinarianModule implements \findus\common\Module{
    
    public function execute() {
//        try{
        $veterinarianName = filter_input(INPUT_POST, 'veterinarian_name');
        if(!$veterinarianName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\VeterinarianController::createNewVeterinarian([
            'veterinarian_name' => filter_input(INPUT_POST, 'veterinarian_name'),
            'veterinarian_description' => filter_input(INPUT_POST, 'veterinarian_description')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
