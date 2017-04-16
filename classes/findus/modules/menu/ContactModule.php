<?php
namespace findus\modules\menu;

class ContactModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::VISITOR;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->setValue('configuration', \findus\controller\ConfigurationController::getConfiguration());
        $response->addTemplateName('contact\show_contact.htpl');
        $response->addScript("show_contact.js");
        return $response;
    }
}
