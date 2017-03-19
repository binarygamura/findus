<?php
namespace findus\model;

use RedBeanPHP\SimpleModel;

/**
 * Description of admission type
 *
 * @author tierhilfe
 */
class AdmissionType extends SimpleModel {
    
     public function isActive(){
         return true;
        return ($this->bean->state == 'ACTIVE');
    }
  
}
