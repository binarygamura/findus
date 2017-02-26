<?php
//use the nice classloader provided by composer.
$classLoader = require_once './vendor/autoload.php';
$classLoader->add('speedy', "./classes");



use speedy\common\Util;
use \RedBeanPHP\R;

//always create a session.
session_start();
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
    R::freeze( TRUE );
    
    //add user object to session. if none is set, we create a "visitor".
    if(!isset($_SESSION['user'])){
        
        $_SESSION['user'] = speedy\controller\UserController::getGuestUser();
    }
    
    $moduleName = filter_input(INPUT_GET, 'module');
    $subModuleName = filter_input(INPUT_GET, 'subModule');
    if($subModuleName){
        $moduleName = $subModuleName;
    }
    if(!$moduleName){
        $moduleName = "Home";
    }
    
    //create the module loader.
    $moduleLoader = new \speedy\common\ModuleLoader($classLoader);
    $loadedModule = $moduleLoader->loadModule($moduleName);
    
    //important -> execute the loaded module.
    $response = $loadedModule->execute();
    
    //create the Engine to handle the response the module created.
    $engine = new \speedy\common\Engine($config);
    $engine->sendResponseToClient($response, $_SESSION['user']->box());
    
}
catch(Exception $ex){
    //TODO: show fancy error page.
    print_r($ex);
    $logger->err($ex->getMessage()."::".$ex->getTraceAsString());
}

