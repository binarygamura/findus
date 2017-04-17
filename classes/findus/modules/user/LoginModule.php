<?php

namespace findus\modules\user;


/**
 * Description of LoginModule
 *
 * @author binary
 */
class LoginModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::VISITOR;
    }
    
    public function execute() {

        global $config;
        
        if(!filter_input(INPUT_POST, "login")){
            $response = new \findus\common\TemplateResponse();    
            if($config['login']['enableRecaptcha'] === true){
                $response->addScript("https://www.google.com/recaptcha/api.js", false);
            }
            $response->addTemplateName("page/login.htpl");
        }
        else {
            if($config['login']['enableRecaptcha'] === true){
                if (!function_exists('curl_init')){
                    throw new \findus\common\ModuleException("curl is not installed. login is not functional!");
                }

                $queryString = http_build_query([
                    "secret" => $config['login']['secret'],
                    "response" => filter_input(INPUT_POST, 'g-recaptcha-response')
                ]);
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $queryString);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($curl);
                if($result === false){
                    //TODO: does the exception message expose sensitive data?
                    throw new \findus\common\ModuleException(curl_error($curl));
                }
                $response = json_decode($result);
                if($response->success === false){
                    throw new \findus\common\ModuleException("sorry, looks like you are a bot.");
                }
            }
            
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
