<?php

namespace findus\modules\admission;

use \RedBeanPHP\R;

/**
 * Description of SwitchAdmissionTypeStateModule
 *
 * @author tierhilfe
 */
class SwitchAdmissionTypeStateModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $admissionTypeId = filter_input(INPUT_POST, 'admissionType_id', FILTER_VALIDATE_INT);
        if(!$admissionTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        \findus\controller\AdmissionTypeController::switchAdmissionTypeState([
            'admissionType_id' => $admissionTypeId
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
