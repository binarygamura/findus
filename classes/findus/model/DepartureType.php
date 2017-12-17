<?php
namespace findus\model;

use RedBeanPHP\SimpleModel;

/**
 * Description of departure type
 *
 * @author tierhilfe
 */
class DepartureType extends SimpleModel {
    
     public function isActive(){
        return ($this->bean->state == 'ACTIVE');
    }
  
}
