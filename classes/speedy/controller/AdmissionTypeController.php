<?php

namespace speedy\controller;

use \RedBeanPHP\R;

/**
 * Description of AdmissionTypeControlle
 *
 * @author tierhilfe
 */
class AdmissionTypeController {
    
    public static function getAllAdmissionTypes(){
        return R::findAll('admissionType');
    }
    
    public static function getAdmissionTypeById($admissionTypeId){
        $admissionType = R::findOne('admissionType', 'id = ?', [$admissionTypeId]);
        if(!$admissionType){
            throw new ControllerException("Es existiert keine Behandlungsart mit der ID ".$admissionTypeId);
        }
        return $admissionType;
    }
    
    public static function createNewAdmissionType(array $admissionTypeData){
        $newAdmissionType = R::dispense('admissiontype');
        if(!isset($admissionTypeData['admissionType_name']) || trim($admissionTypeData['admissionType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
 
        $name = trim($admissionTypeData['admissionType_name']);
        
        $admissionType = R::findOne('admissiontype', 'name = ?', [$name]);
        if($admissionType){
            throw new ControllerException("Diese Eingangsart ist bereits vorhanden.");
        }

        $newAdmissionType['name'] = $name;
        $newAdmissionType['description'] = $admissionTypeData['admissionType_description'];
        R::store($newAdmissionType);
    }
    
    public static function updateAdmissionType(array $admissionTypeData){
        if(!isset($admissionTypeData['admissionType_id']) || trim($admissionTypeData['admissionType_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($admissionTypeData['admissionType_name']) || trim($admissionTypeData['admissionType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        if(!isset($admissionTypeData['admissionType_description']) || trim($admissionTypeData['person_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
 
        $id = trim($admissionTypeData['admissionType_id']);
        $name = trim($admissionTypeData['admissionType_name']);
        
        $admissionType = R::findOne('admissionType', 'id = ?', [$id]);
        if($admissionType){
            throw new ControllerException("Keine Eingangsart mit der id "+ $id + " gefunden.");
        }

        $admissionType['name'] = $name;
        $admissionType['description'] = $admissionTypeData['admissionType_description'];
        R::store($admissionType);
    } 
}
