<?php

namespace findus\modules\departure;

use \RedBeanPHP\R;

/**
 * Description of SwitchDepartureTypeStateModule
 *
 * @author tierhilfe
 */
class SwitchDepartureTypeStateModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $departureTypeId = filter_input(INPUT_POST, 'departureType_id', FILTER_VALIDATE_INT);
        if(!$departureTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        \findus\controller\DepartureTypeController::switchDepartureTypeState([
            'departureType_id' => $departureTypeId
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
