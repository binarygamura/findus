<?php

namespace findus\modules\veterinarian;

/**
 * Description of AddVeterinarianModule
 *
 * @author tierhilfe
 */
class AddVeterinarianModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
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
