<?php

namespace speedy\model;

use RedBeanPHP\SimpleModel;

/**
 * Class representing a user of the app. 
 *
 * @author binary
 */
class User extends SimpleModel {
    /**
     * Visitor of the Page. He should at least see the login page. 
     * Nothing more.
     */
    const VISITOR = 1;
    /**
     * Some regular user of the application. Can use most of the app but
     * is unable for example to create new accounts.
     */
    const USER = 3;
    /**
     * This role has the the same permissions as the user role, but can
     * also create statistics and other stuff.
     */
    const MANAGEMENT = 7;
    /**
     * The admin can do everything.... everything!!!
     */
    const ADMIN = 15;

    
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->bean->username;
    }
  
        
    public function isA($role){
        return ($this->bean->role & $role) == $role;
    }
    
    public function isOnlyVisitor(){
        return ($this->bean->role ^ 1) == 0;
    }

    public function open() {
        $this->password = "";
    }
}
