<?php

namespace speedy\modules;

/**
 * Description of LoginModule
 *
 * @author binary
 */
class LoginModule implements \speedy\common\Module {
    
    public function execute() {
        if(!filter_input(INPUT_POST, "login_button")){
            $response = new \speedy\common\TemplateResponse();        
            $response->addTemplateName("login.htpl");
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
                $loaded = \speedy\controller\UserController::getUserByUsernameAndPassword($username, $password);
                if(!$loaded){
                    $errors[] = "Benutzer nicht gefunden.";
                }
                else {
                    $_SESSION['user'] = $loaded;
                }
            }
            
            if(count($errors) > 0){
                $response = new \speedy\common\TemplateResponse();        
                $response->addTemplateName("login.htpl");
                $response->addTemplateName("errors.htpl");
                $response->setValue('errors', $errors);
            }
            else {
                $response = new \speedy\common\RedirectResponse("index.php");
            }
        }
        return $response;
    }
}
