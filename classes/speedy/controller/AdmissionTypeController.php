<?php

namespace speedy\controller;

use \RedBeanPHP\R;

/**
 * Description of AdmissionTypeControlle
 *
 * @author tierhilfe
 */
class AdmissianTypeController {
    
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
    
    public static function createAdmissionType(array $admissionTypeData){
        $newAdmissionType = R::dispense('admissionType');
        if(!isset($admissionTypeData['admissionType_name']) || trim($admissionTypeData['admissionType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        if(!isset($admissionTypeData['admissionType_description']) || trim($admissionTypeData['person_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
 
        $name = trim($admissionTypeData['admissionType_name']);
        
        $admissionType = R::findOne('admissionType', 'name = ?', [$name]);
        if($admissionType){
            throw new ControllerException("Diese Tierrasse ist bereits vorhanden.");
        }

        $newAdmissionType['name'] = $name;
        $newAdmissionType['description'] = $admissionTypeData['admissionType_description'];
        R::store($newAdmissionType);
    }
}
