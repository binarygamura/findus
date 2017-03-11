<?php

namespace speedy\modules;

/**
 * Description of LogoutModule
 *
 * @author binary gamura
 */
class LogoutModule implements \speedy\common\Module {

    public function execute() {
        if(filter_input(INPUT_POST, 'yes_button') || filter_input(INPUT_POST, 'no_button')){
            if(filter_input(INPUT_POST, 'yes_button')){
                session_destroy();
            }
            return new \speedy\common\RedirectResponse("index.php");
        }
        else {
            $response = new \speedy\common\TemplateResponse();
            $response->addTemplateName("page/logout.htpl");
            return $response;
        }
    }
}
