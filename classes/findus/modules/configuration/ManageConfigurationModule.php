<?php

namespace findus\modules\configuration;

/**
 * Description of ManageConfigurationModule
 *
 * @author Tierhilfe
 */
class ManageConfigurationModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::ADMIN;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        $response->setValue('configuration', \findus\controller\ConfigurationController::getConfiguration());
        $response->addTemplateName('configuration\edit_configuration.htpl');
        $response->addScript("edit_configuration.js");
        return $response;
    }

}
