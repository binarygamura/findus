<?php

namespace findus\modules\admission;

/**
 * Description of AddAdmissionTypeModule
 *
 * @author tierhilfe
 */
class AddAdmissionTypeModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
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
