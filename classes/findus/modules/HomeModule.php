<?php

namespace findus\modules;


/**
 * Description of HomeModule
 *
 * @author binary
 */
class HomeModule implements \findus\common\Module {

    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("home.htpl");
        return $response;
    }

}
