<?php

namespace findus\modules\user;

/**
 * Description of LogoutModule
 *
 * @author binary gamura
 */
class LogoutModule extends \findus\common\AbstractModule  {

    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
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
