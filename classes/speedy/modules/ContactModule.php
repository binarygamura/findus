<?php
namespace speedy\modules;

class ContactModule implements \speedy\common\Module {
    
    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("page/contact.htpl");
        return $response;
    }
}
