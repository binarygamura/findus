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
    
    private static $SEX = array('UNKNOWN', 'MALE', 'FEMALE');
    
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
    
    
    public static function isValidSex($sex){
        $sex = trim($sex);
        return array_search($sex, self::$SEX) !== false;
    }
}
