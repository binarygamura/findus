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
        $admissionTypeName = filter_input(INPUT_POST, 'admissionType_name');
        $admissionTypeDescription = filter_input(INPUT_POST, 'admissionType_description');
        if(!$admissionTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $admissionType = R::findOne('admissionType', 'id = ?', [$admissionTypeId]);
        if(!$admissionType){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$admissionTypeId." gefunden.");
        }
        \findus\controller\AdmissionTypeController::updateAdmissionType([
            'admissionType_id' => $admissionTypeId,
            'admissionType_name' => $admissionTypeName,
            'admissionType_description' => $admissionTypeDescription
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
