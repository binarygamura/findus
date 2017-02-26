<?php


namespace speedy\controller;

/**
 * Description of ControllerException
 *
 * @author binary gamura
 */
class ControllerException extends \Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}
