<?php

namespace findus\modules\admission;

/**
 * Description of ManageAdmissionTypesModule
 *
 * @author Tierhilfe
 */
class ManageAdmissionTypesModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \findus\controller\AdmissionTypeController::createNewAdmissionType([
                    'admissionType_name' => filter_input(INPUT_POST, 'admissionType_name'),
                    'admissionType_description' => filter_input(INPUT_POST, 'admissionType_description')
                    ]);
            }
        }
        catch(\findus\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("page/errors.htpl");
        }
        
        $response->setValue('all_admissionTypes', \findus\controller\AdmissionTypeController::getAllAdmissionTypes());
        $response->addScript('admissionType.js');
        $response->addTemplateName("admission\list_admissionTypes.htpl");
        return $response;
    }

}
