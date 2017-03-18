<?php

namespace findus\modules\veterinarian;

use \RedBeanPHP\R;

/**
 * Description of UpdateVeterinarianModule
 *
 * @author tierhilfe
 */
class UpdateVeterinarianModule implements \findus\common\Module {
    
    public function execute() {
        $veterinarianId = filter_input(INPUT_POST, 'veterinarian_id', FILTER_VALIDATE_INT);
        $veterinarianName = filter_input(INPUT_POST, 'veterinarian_name');
        $veterinarianDescription = filter_input(INPUT_POST, 'veterinarian_description');
        if(!$veterinarianId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        
        $veterinarian = R::findOne('veterinarian', 'id = ?', [$veterinarianId]);
        if(!$veterinarian){
            
            throw new \findus\controller\ControllerException("Es wurde kein Tierarzt mit der ID ".$veterinarianId." gefunden.");
        }
        
        \findus\controller\VeterinarianController::updateVeterinarian([
            'veterinarian_id' => $veterinarianId,
            'veterinarian_name' => $veterinarianName,
            'veterinarian_description' => $veterinarianDescription
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
