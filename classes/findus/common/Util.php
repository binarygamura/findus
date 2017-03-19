<?php

namespace findus\common;

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

/**
 * Handy class for utility function.
 *
 * @author binary
 */
class Util {
    
    /**
     *
     * @var type List of all Sexes the application knows about.
     */
    private static $SEX = array('UNKNOWN', 'MALE', 'FEMALE');
    
    /**
     * Util-Function to simplyfy the process of creating a logger.
     * @param type $name
     * @param array $config
     * @return Logger
     */
    public static function createLogger($name, array $config){
        $stage = $config['general']['stage'];
        $logger = new Logger($name);
        switch($stage){
            case STAGE_DEV:
                $logger->pushHandler(new StreamHandler($config['logging']['logfile'], Logger::DEBUG));
                break;
            case STAGE_PROD:
            default:
                $logger->pushHandler(new StreamHandler($config['logging']['logfile'], Logger::WARNING));
                break;
        }
        return $logger;
    }
    
    
    /**
     * Check if a string is equal to one of the following values
     * 'UNKNOWN','MALE' or 'FEMALE'. 
     * 
     * @param type $sex
     * @return type
     */
    public static function isValidSex($sex){
        $sex = trim($sex);
        return array_search($sex, self::$SEX) !== false;
    }
    
    
    /**
     * Create the filename with a specific suffix within a given directory.
     * 
     * @param type $directory
     * @param type $suffix
     * @return mixed false if option failed, or the filename of the unique file.
     */
    public static function getUniqueFilename($directory, $suffix){
        $filename = false;
        //wow... do-while finally makes sense... this time...
        do {
            //to we really need more entropy?
            $filename = uniqid('Findus', true) . $suffix;            
        }
        while(file_exists($directory.$filename));
        return $filename;
    }
}
