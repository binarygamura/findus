<?php

namespace speedy\modules;

/**
 * Description of LoginModule
 *
 * @author binary
 */
class LoginModule implements \speedy\common\Module{
    
    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->setTemplateName("login.htpl");
        return $response;
    }
}
