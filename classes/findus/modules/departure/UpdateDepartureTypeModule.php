<?php

namespace findus\modules\departure;

use \RedBeanPHP\R;

/**
 * Description of UpdateDepartureTypeModule
 *
 * @author tierhilfe
 */
class UpdateDepartureTypeModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $departureTypeId = filter_input(INPUT_POST, 'departureType_id', FILTER_VALIDATE_INT);
        $departureTypeName = filter_input(INPUT_POST, 'departureType_name');
        $departureTypeDescription = filter_input(INPUT_POST, 'departureType_description');
        $departureTypeSpinner = filter_input(INPUT_POST, 'departureType_spinner', FILTER_VALIDATE_BOOLEAN);
        if(!$departureTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        
        $departureType = R::findOne('departuretype', 'id = ?', [$departureTypeId]);
        if(!$departureType){
            
            throw new \findus\controller\ControllerException("Es wurde keine Eingangsart mit der ID ".$departureTypeId." gefunden.");
        }
        
        \findus\controller\DepartureTypeController::updateDepartureType([
            'departureType_id' => $departureTypeId,
            'departureType_name' => $departureTypeName,
            'departureType_description' => $departureTypeDescription,
            'departureType_spinner' => $departureTypeSpinner
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
