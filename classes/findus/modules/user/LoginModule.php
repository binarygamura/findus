<?php

namespace findus\modules\user;

/**
 * Description of LoginModule
 *
 * @author binary
 */
class LoginModule implements \findus\common\Module {
    
    public function execute() {
        if(!filter_input(INPUT_POST, "login_button")){
            $response = new \findus\common\TemplateResponse();        
            $response->addTemplateName("page/login.htpl");
        }
        else {
            $errors = [];
            $username = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);
            if(!$username){
                $errors[] = "Es wurde kein Benutzername angegeben.";
            }
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            if(!$password){
                $errors[] = "Bitte Passwort angeben.";
            }
            
            if(count($errors) == 0){
                $loaded = \findus\controller\UserController::getUserByUsernameAndPassword($username, $password);
                if(!$loaded){
                    $errors[] = "Benutzer nicht gefunden.";
                }
                else {
                    $_SESSION['user'] = $loaded;
                }
            }
            
            if(count($errors) > 0){
                $response = new \findus\common\TemplateResponse();        
                $response->addTemplateName("page/login.htpl");
                $response->addTemplateName("page/errors.htpl");
                $response->setValue('errors', $errors);
            }
            else {
                $response = new \findus\common\RedirectResponse("index.php");
            }
        }
        return $response;
    }
}
