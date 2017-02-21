<?php

namespace speedy\modules;

/**
 * Description of LoginModule
 *
 * @author binary
 */
class LoginModule implements \speedy\common\Module{
    
    public function execute() {
        if(filter_input(INPUT_POST, "login_button") === false){
            $response = new \speedy\common\TemplateResponse();        
            $response->addTemplateName("login.htpl");
        }
        else {
            $errors = [];
            $username = filter_input(INPUT_POST, "username");
            if(!$username){
                $errors[] = "Es wurde kein Passwort angegeben.";
            }
            $password = filter_input(INPUT_POST, "password");
            if(!$password){
                $errors[] = "Bitte Benutzername angeben.";
            }
            
            if(count($errors) > 0){
                $response = new \speedy\common\TemplateResponse();        
                $response->addTemplateName("login.htpl");
                $response->addTemplateName("errors.htpl");
                $response->setValue('errors', $errors);
            }
            else {
                //TODO: redirect to home module!
            }
        }
        return $response;
    }
}
