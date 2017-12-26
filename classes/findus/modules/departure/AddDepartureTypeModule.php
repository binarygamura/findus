<?php

namespace findus\modules\departure;

/**
 * Description of AddDepartureTypeModule
 *
 * @author tierhilfe
 */
class AddDepartureTypeModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $departureTypeName = filter_input(INPUT_POST, 'departureType_name');
        if(!$departureTypeName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\DepartureTypeController::createNewDepartureType([
            'departureType_name' => filter_input(INPUT_POST, 'departureType_name'),
            'departureType_description' => filter_input(INPUT_POST, 'departureType_description')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
