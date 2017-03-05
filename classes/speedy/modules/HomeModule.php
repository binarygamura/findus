<?php

namespace speedy\modules;


/**
 * Description of HomeModule
 *
 * @author binary
 */
class HomeModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("home.htpl");
        return $response;
    }

}