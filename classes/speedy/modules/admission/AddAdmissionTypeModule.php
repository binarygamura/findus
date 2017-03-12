<?php

namespace speedy\modules\admission;

/**
 * Description of AddAdmissionTypeModule
 *
 * @author tierhilfe
 */
class AddAdmissionTypeModule implements \speedy\common\Module{
    
    public function execute() {
//        try{
        $admissionTypeName = filter_input(INPUT_POST, 'admissionType_name');
        if(!$admissionTypeName){
            throw new \speedy\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \speedy\controller\AdmissionTypeController::createNewAdmissionType([
            'admissionType_name' => filter_input(INPUT_POST, 'admissionType_name'),
            'admissionType_description' => filter_input(INPUT_POST, 'admissionType_description')
            ]);
        $resonse = new \speedy\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
