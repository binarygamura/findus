<?php

namespace findus\modules\menu;

/**
 * Description of AdminModule
 *
 * @author binary gamura
 */
class AdminModule implements \findus\common\Module {

    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("admin.htpl");
        return $response;
    }

}
