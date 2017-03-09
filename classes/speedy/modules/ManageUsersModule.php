<?php

namespace speedy\modules;

/**
 * Description of ManageUsersModule
 *
 * @author Tierhilfe
 */
class ManageUsersModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \speedy\controller\UsersController::createNewUser(['user_name' => filter_input(INPUT_POST, 'user_name')]);
            }
        }
        catch(\speedy\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("errors.htpl");
        }
        
        $response->setValue('all_users', \speedy\controller\UserController::getAllUsers());
        $response->addTemplateName("add_user.htpl");
        $response->addTemplateName("list_users.htpl");
        return $response;
    }

}
