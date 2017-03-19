<?php

namespace findus\modules\therapy;

use \RedBeanPHP\R;

/**
 * Description of SwitchTherapyTypeStateModule
 *
 * @author tierhilfe
 */
class SwitchTherapyTypeStateModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $therapyTypeId = filter_input(INPUT_POST, 'therapyType_id', FILTER_VALIDATE_INT);
        if(!$therapyTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        \findus\controller\TherapyTypeController::switchTherapyTypeState([
            'therapyType_id' => $therapyTypeId
            ]);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
