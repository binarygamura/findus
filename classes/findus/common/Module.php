<?php

namespace findus\common;

/**
 * Description of Module
 *
 * @author binary
 */
interface Module {
    public function execute();
    
    public function canAccess(\findus\model\User $user);
}
