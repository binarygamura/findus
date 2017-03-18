<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of TherapyTypeControlle
 *
 * @author tierhilfe
 */
class TherapyTypeController {
    
    public static function getAllTherapyTypes(){
        return R::findAll('therapytype');
    }
    
    public static function getTherapyTypeById($therapyTypeId){
        $therapyType = R::findOne('therapytype', 'id = ?', [$therapyTypeId]);
        if(!$therapyType){
            throw new ControllerException("Es existiert keine Behandlungsart mit der ID ".$therapyTypeId);
        }
        return $therapyType;
    }
    
    public static function createNewTherapyType(array $therapyTypeData){
        $newTherapyType = R::dispense('therapytype');
        if(!isset($therapyTypeData['therapyType_name']) || trim($therapyTypeData['therapyType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
 
        $name = trim($therapyTypeData['therapyType_name']);
        
        $therapyType = R::findOne('therapytype', 'name = ?', [$name]);
        if($therapyType){
            throw new ControllerException("Diese Behandlungsart ist bereits vorhanden.");
        }

        $newTherapyType['name'] = $name;
        $newTherapyType['description'] = $therapyTypeData['therapyType_description'];
        R::store($newTherapyType);
    }
    
    public static function updateTherapyType(array $therapyTypeData){
        if(!isset($therapyTypeData['therapyType_id']) || trim($therapyTypeData['therapyType_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($therapyTypeData['therapyType_name']) || trim($therapyTypeData['therapyType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        if(!isset($therapyTypeData['therapyType_description']) || trim($therapyTypeData['therapyType_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
 
        $id = $therapyTypeData['therapyType_id'];
        $name = trim($therapyTypeData['therapyType_name']);
        
        $therapyType = R::findOne('therapytype', 'id = ?', [$id]);
        if(!$therapyType){
            throw new ControllerException("Keine Behandlungsart mit der id "+ $id + " gefunden.");
        }

        $therapyType['name'] = $name;
        $therapyType['description'] = $therapyTypeData['therapyType_description'];
        R::store($therapyType);
    } 
}
