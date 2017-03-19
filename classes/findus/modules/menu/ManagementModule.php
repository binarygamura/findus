<?php

namespace findus\modules\menu;

/**
 * Description of ManagementModule
 *
 * @author binary gamura
 */
class ManagementModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        $templateResponse = new \findus\common\TemplateResponse();
        $templateResponse->addTemplateName('management.htpl');
        return $templateResponse;
    }
}
