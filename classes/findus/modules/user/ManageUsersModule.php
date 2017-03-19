<?php

namespace findus\modules\user;

/**
 * Description of ManageUsersModule
 *
 * @author Tierhilfe
 */
class ManageUsersModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::ADMIN;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \findus\controller\UserController::createNewUser([
                    'user_name' => filter_input(INPUT_POST, 'user_name'),
                    'user_password' => filter_input(INPUT_POST, 'user_password'),
                    'user_role' => filter_input(INPUT_POST, 'user_role')]);
            }
        }
        catch(\findus\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("page/errors.htpl");
        }
        
        $response->setValue('all_users', \findus\controller\UserController::getAllUsers());
        $response->addScript('user.js');
        $response->addTemplateName("user\list_users.htpl");
        return $response;
    }

}
