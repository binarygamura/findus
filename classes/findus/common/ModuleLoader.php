<?php

namespace findus\common;

/**
 * The ModuleLoaders job is to load a valid Module
 * from the filesystem. To do so, it tries to load
 * a fitting class with the help of a ClassLoader 
 * and performs some checks on it to ensure it is a valid one.
 *
 * @author binary
 */
class ModuleLoader {
    
    private $classLoader;
    
    public function __construct(\Composer\Autoload\ClassLoader $classLoader){
        $this->classLoader = $classLoader;        
    }
    
    /**
     * Load a Module denoted by its name.
     * @param type $moduleName
     * @return \findus\common\Module
     * @throws Exception
     */
    public function loadModule($moduleName, \findus\model\User $user){
        $className = $moduleName."Module";
        $fullClassName = "findus\\modules\\".$className;
        if(!$this->classLoader->loadClass($fullClassName)){
            throw new \Exception("Failed to load class.");
        }
        if(!class_exists($fullClassName)){
            //TODO: throw a ModuleNotFoundException
            throw new \Exception('Module does not exist.');
        }
        $instance = new $fullClassName();
        if(! ($instance instanceof Module)){
            throw new \Exception($fullClassName.' is not a valid Module.');
        }
        if(!$instance->canAccess($user)){
            throw new \Exception("you are not allowed to execute this module.");
        }
        return $instance;
    }
}
