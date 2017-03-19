<?php
namespace findus\modules\menu;

class ContactModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::VISITOR;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("page/contact.htpl");
        return $response;
    }
}
