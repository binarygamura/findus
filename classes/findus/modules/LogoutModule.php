<?php

namespace findus\modules;

/**
 * Description of LogoutModule
 *
 * @author binary gamura
 */
class LogoutModule implements \findus\common\Module {

    public function execute() {
        if(filter_input(INPUT_POST, 'yes_button') || filter_input(INPUT_POST, 'no_button')){
            if(filter_input(INPUT_POST, 'yes_button')){
                session_destroy();
            }
            return new \findus\common\RedirectResponse("index.php");
        }
        else {
            $response = new \findus\common\TemplateResponse();
            $response->addTemplateName("page/logout.htpl");
            return $response;
        }
    }
}
