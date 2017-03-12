<?php

namespace findus\modules\admission;

/**
 * Description of AddAdmissionTypeModule
 *
 * @author tierhilfe
 */
class AddAdmissionTypeModule implements \findus\common\Module{
    
    public function execute() {
//        try{
        $admissionTypeName = filter_input(INPUT_POST, 'admissionType_name');
        if(!$admissionTypeName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\AdmissionTypeController::createNewAdmissionType([
            'admissionType_name' => filter_input(INPUT_POST, 'admissionType_name'),
            'admissionType_description' => filter_input(INPUT_POST, 'admissionType_description')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
