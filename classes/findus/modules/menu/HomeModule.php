<?php

namespace findus\modules\menu;


/**
 * Description of HomeModule
 *
 * @author binary
 */
class HomeModule extends \findus\common\AbstractModule {

    function __construct() {
        $this->requiredRole = \findus\model\User::VISITOR;
    }

    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("home.htpl");
        return $response;
    }

}
