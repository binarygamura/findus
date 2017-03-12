<?php

namespace findus\modules\admission;

use \RedBeanPHP\R;

/**
 * Description of UpdateAdmissionTypeModule
 *
 * @author tierhilfe
 */
class UpdateAdmissionTypeModule implements \findus\common\Module {
    
    public function execute() {
        $admissionTypeId = filter_input(INPUT_POST, 'admissionType_id', FILTER_VALIDATE_INT);
        $admissionTypeName = filter_input(INPUT_POST, 'admissionType_name', FILTER_VALIDATE_INT);
        if(!$admissionTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $admissionType = R::findOne('admissionType', 'id = ?', [$admissionTypeId]);
        if(!$admissionType){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$admissionTypeId." gefunden.");
        }
        \findus\controller\AdmissionTypeController::updateAdmissionType([
            admissionTypeId,
            'admissionType_name' => filter_input(INPUT_POST, 'admissionType_name'),
            'admissionType_password' => filter_input(INPUT_POST, 'admissionType_password'),
            'admissionType_role' => filter_input(INPUT_POST, 'admissionType_role')
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
