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
       
        $response->setValue('all_admissionTypes', \findus\controller\AdmissionTypeController::getAllAdmissionTypes());
        $response->addScript('admissionType.js');
        $response->addTemplateName("admission\list_admissionTypes.htpl");
        return $response;
    }

}
