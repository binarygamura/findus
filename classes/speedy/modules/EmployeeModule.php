<?php

namespace speedy\modules;

/**
 * Description of EmployeeModel
 *
 * @author binary gamura
 */
class EmployeeModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("admin.htpl");
        return $response;
    }
}
