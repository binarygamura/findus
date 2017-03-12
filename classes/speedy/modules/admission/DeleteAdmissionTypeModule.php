<?php

namespace speedy\modules\admission;

use \RedBeanPHP\R;

/**
 * Description of DeleteAdmissionTypeModule
 *
 * @author tierhilfe
 */
class DeleteAdmissionTypeModule implements \speedy\common\Module {
    
    public function execute() {
        $admissionTypeId = filter_input(INPUT_POST, 'admissionType_id', FILTER_VALIDATE_INT);
        if(!$admissionTypeId){
            throw new \speedy\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $admissionType = R::findOne('admissionType', 'id = ?', [$admissionTypeId]);
        if(!$admissionType){
            throw new \speedy\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$admissionTypeId." gefunden.");
        }
        R::trash($admissionType);
        $response = new \speedy\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
