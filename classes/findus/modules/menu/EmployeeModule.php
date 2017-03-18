<?php
namespace findus\modules\menu;
/**
 * Description of EmployeeModel
 *
 * @author binary gamura
 */
class EmployeeModule implements \findus\common\Module {
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("admin.htpl");
        return $response;
    }
}
