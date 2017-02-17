<?php

namespace speedy\common;

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

/**
 * Handy class for utility function.
 *
 * @author binary
 */
class Util {
    
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
}
