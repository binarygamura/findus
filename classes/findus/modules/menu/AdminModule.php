<?php

namespace findus\modules\menu;

/**
 * Description of AdminModule
 *
 * @author binary gamura
 */
class AdminModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::ADMIN;
    }
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("admin.htpl");
        return $response;
    }

}
