<?php

namespace findus\modules\admission;

use \RedBeanPHP\R;

/**
 * Description of DeleteAdmissionTypeModule
 *
 * @author tierhilfe
 */
class DeleteAdmissionTypeModule implements \findus\common\Module {
    
    public function execute() {
        $admissionTypeId = filter_input(INPUT_POST, 'admissionType_id', FILTER_VALIDATE_INT);
        if(!$admissionTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $admissionType = R::findOne('admissionType', 'id = ?', [$admissionTypeId]);
        if(!$admissionType){
            throw new \findus\controller\ControllerException("Es wurde keine Eingangsart mit der ID ".$admissionTypeId." gefunden.");
        }
        R::trash($admissionType);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
