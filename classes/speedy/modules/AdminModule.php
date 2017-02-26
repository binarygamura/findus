<?php

namespace speedy\modules;

/**
 * Description of AdminModule
 *
 * @author binary gamura
 */
class AdminModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("admin.htpl");
        return $response;
    }

}
