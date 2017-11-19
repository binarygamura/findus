<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of AdmissionTypeControlle
 *
 * @author tierhilfe
 */
class AdmissionTypeController {
    
    public static function getAllAdmissionTypes(){
        return R::findAll('admissiontype');
    }
    
    public static function getAllActiveAdmissionTypes(){
        return R::find('admissiontype','state = \'ACTIVE\' ORDER BY name ASC');
    }

    public static function getAdmissionTypeById($admissionTypeId){
        if(!$admissionTypeId){
            throw new ControllerException('Es wurde keine Zugangstyp-ID angegeben.');
        }
        $admissionType = R::findOne('admissiontype', 'id = ?', [$admissionTypeId]);
        if(!$admissionType){
            throw new ControllerException("Es existiert keine Zugangsart mit der ID ".$admissionTypeId);
        }
        return $admissionType;
    }
    
    public static function createNewAdmissionType(array $admissionTypeData){
        $newAdmissionType = R::dispense('admissiontype');
        if(!isset($admissionTypeData['admissionType_name']) || trim($admissionTypeData['admissionType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
 
        
        $name = trim($admissionTypeData['admissionType_name']);
        
        if(!isset($admissionTypeData['admissionType_description']) || trim($admissionTypeData['admissionType_description']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $description = trim($admissionTypeData['admissionType_description']);
        
        $admissionType = R::findOne('admissiontype', 'name = ?', [$name]);
        if($admissionType){
            throw new ControllerException("Diese Eingangsart ist bereits vorhanden.");
        }

        $newAdmissionType['name'] = $name;
        $newAdmissionType['description'] = $description;
        $newAdmissionType['spinner'] = $admissionTypeData['admissionType_spinner'];
        $newAdmissionType['state'] = 'ACTIVE';
        R::store($newAdmissionType);
    }
    
    public static function updateAdmissionType(array $admissionTypeData){
        if(!isset($admissionTypeData['admissionType_id']) || trim($admissionTypeData['admissionType_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($admissionTypeData['admissionType_description']) || trim($admissionTypeData['admissionType_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
        if(!isset($admissionTypeData['admissionType_description']) || trim($admissionTypeData['admissionType_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
 
        $id = $admissionTypeData['admissionType_id'];
        $name = trim($admissionTypeData['admissionType_name']);
        
        $admissionType = R::findOne('admissiontype', 'id = ?', [$id]);
        if(!$admissionType){
            throw new ControllerException("Keine Eingangsart mit der id ". $id . " gefunden.");
        }

        $admissionType['name'] = $name;
        $admissionType['state'] = 'ACTIVE';
        $admissionType['description'] = $admissionTypeData['admissionType_description'];
        $admissionType['spinner'] = $admissionTypeData['admissionType_spinner'];
        R::store($admissionType);
    } 

    public static function switchAdmissionTypeState(array $admissionTypeData){
        if(!isset($admissionTypeData['admissionType_id']) || trim($admissionTypeData['admissionType_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        $id = $admissionTypeData['admissionType_id'];
        
        $admissionType = R::findOne('admissiontype', 'id = ?', [$id]);
        if(!$admissionType){
            throw new ControllerException("Keine Eingangsart mit der id ". $id . " gefunden.");
        }

        if ($admissionType['state']==='ACTIVE') {
            $admissionType['state'] = 'DEACTIVE';
        } else {
            $admissionType['state'] = 'ACTIVE';
        }
        R::store($admissionType);
    } 
    
}
