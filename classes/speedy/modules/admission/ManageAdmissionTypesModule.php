<?php

namespace speedy\modules\admission;

/**
 * Description of ManageAdmissionTypesModule
 *
 * @author Tierhilfe
 */
class ManageAdmissionTypesModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
       
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \speedy\controller\AdmissionTypeController::createNewAdmissionType([
                    'admissionType_name' => filter_input(INPUT_POST, 'admissionType_name'),
                    'admissionType_description' => filter_input(INPUT_POST, 'admissionType_description')
                    ]);
            }
        }
        catch(\speedy\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("page/errors.htpl");
        }
        
        $response->setValue('all_admissionTypes', \speedy\controller\AdmissionTypeController::getAllAdmissionTypes());
        $response->addScript('admissionType.js');
        $response->addTemplateName("admission\list_admissionTypes.htpl");
        return $response;
    }

}
