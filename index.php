<?php
$classLoader = require_once './vendor/autoload.php';
$classLoader->add('speedy', "./classes");

//always create a session.
session_start();

//include the global config.
require_once './config/config.php';
require './config/custom_config.php';

$config = array_merge($config, $customConfig);

use speedy\common\Util;


$logger = Util::createLogger("main", $config);

try {
    //add user object to session. if none is set, we create a "visitor".
    if(!isset($_SESSION['user'])){
        $_SESSION['user'] = new \speedy\common\User();
    }
    
    //lets figure out which module we should load.
//    if($_SESSION['user']->isOnlyVisitor()){
//        $moduleName = "Login";
//    }
//    else {
        $moduleName = filter_input(INPUT_GET, 'module');
        if(!$moduleName){
            $moduleName = "Home";
        }
//    }
    
    //create the module loader.
    $moduleLoader = new \speedy\common\ModuleLoader($classLoader);
    $loadedModule = $moduleLoader->loadModule($moduleName, $_SESSION['user']);
    
    //important -> execute the loaded module.
    $response = $loadedModule->execute();
    
    //create the Engine to handle the response the module created.
    $engine = new \speedy\common\Engine($config);
    $engine->sendResponseToClient($response, $_SESSION['user']);
    
}
catch(Exception $ex){
    //TODO: show fancy error page.
    print_r($ex);
    $logger->err($ex->getMessage()."::".$ex->getTraceAsString());
}

