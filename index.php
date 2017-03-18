<?php
//use the nice classloader provided by composer.
$classLoader = require_once './vendor/autoload.php';
$classLoader->add('findus', "./classes");

use findus\common\Util;
use \RedBeanPHP\R;

//always create a session.
session_start();

//TODO: remove me before deployment.
if(isset($_GET['kill'])){
    session_destroy();
}

//include the global config.
require_once './config/config.php';
require './config/custom_config.php';

//merge your custom config with the global one.
$config = array_replace($config, $customConfig);

$logger = Util::createLogger("main", $config);

try {
    
    R::setup($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
    //TODO: freeze db-structure when deployed on productive stage.
//    R::freeze( TRUE );
    
    //add user object to session. if none is set, we create a "visitor".
    if(!isset($_SESSION['user'])){
        $user = findus\controller\UserController::getGuestUser();
        if(!$user){
            throw new Exception("Es konnte kein Gast-User erzeugt werden. Bitte DB prüfen.");
        }
        $_SESSION['user'] = $user;
    }
    
    $moduleName = filter_input(INPUT_GET, 'module');
    $subModuleName = filter_input(INPUT_GET, 'subModule');
    if($subModuleName){
        $moduleName = $subModuleName;
    }
    if(!$moduleName){
        $moduleName = "menu\\Home";
    }
    
    //create the module loader.
    $moduleLoader = new \findus\common\ModuleLoader($classLoader);
    $loadedModule = $moduleLoader->loadModule($moduleName);
    
    //important -> execute the loaded module.
    $response = $loadedModule->execute();
    
    //create the Engine to handle the response the module created.
    $engine = new \findus\common\Engine($config);
    $engine->sendResponseToClient($response, $_SESSION['user']->box());
    
}
catch(Exception $ex){
    //TODO: show (more or less) fancy error page.
    http_response_code(500);
    echo(json_encode(["message" => $ex->getMessage()]));
    $logger->err($ex->getMessage()."::".$ex->getTraceAsString());
}

