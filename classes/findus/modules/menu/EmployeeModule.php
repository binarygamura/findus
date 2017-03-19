<?php
namespace findus\modules\menu;
/**
 * Description of EmployeeModel
 *
 * @author binary gamura
 */
class EmployeeModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("admin.htpl");
        return $response;
    }
}
