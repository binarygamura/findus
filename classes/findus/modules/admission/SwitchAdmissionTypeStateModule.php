<?php

namespace findus\modules\admission;

use \RedBeanPHP\R;

/**
 * Description of DeleteAdmissionTypeModule
 *
 * @author tierhilfe
 */
class SwitchAdmissionTypeStateModule implements \findus\common\Module {
    
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
