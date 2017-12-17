<?php

namespace findus\modules\departure;

/**
 * Description of ManageDepartureTypesModule
 *
 * @author Tierhilfe
 */
class ManageDepartureTypesModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        $response->setValue('all_departureTypes', \findus\controller\DepartureTypeController::getAllDepartureTypes());
        $response->addScript('departureType.js');
        $response->addTemplateName("departure\list_departureTypes.htpl");
        return $response;
    }

}
