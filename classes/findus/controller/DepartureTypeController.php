<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of DepartureTypeControlle
 *
 * @author tierhilfe
 */
class DepartureTypeController {
    
    public static function getAllDepartureTypes(){
        return R::findAll('departuretype');
    }
    
    public static function getAllActiveDepartureTypes(){
        return R::find('departuretype','state = \'ACTIVE\' ORDER BY name ASC');
    }

    public static function getDepartureTypeById($departureTypeId){
        if(!$departureTypeId){
            throw new ControllerException('Es wurde keine Abgangtyp-ID angegeben.');
        }
        $departureType = R::findOne('departuretype', 'id = ?', [$departureTypeId]);
        if(!$departureType){
            throw new ControllerException("Es existiert keine Abgangart mit der ID ".$departureTypeId);
        }
        return $departureType;
    }
    
    public static function createNewDepartureType(array $departureTypeData){
        $newDepartureType = R::dispense('departuretype');
        if(!isset($departureTypeData['departureType_name']) || trim($departureTypeData['departureType_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
 
        
        $name = trim($departureTypeData['departureType_name']);
        
        if(!isset($departureTypeData['departureType_description']) || trim($departureTypeData['departureType_description']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $description = trim($departureTypeData['departureType_description']);
        
        $departureType = R::findOne('departuretype', 'name = ?', [$name]);
        if($departureType){
            throw new ControllerException("Diese Eingangsart ist bereits vorhanden.");
        }

        $newDepartureType['name'] = $name;
        $newDepartureType['description'] = $description;
        $newDepartureType['state'] = 'ACTIVE';
        R::store($newDepartureType);
    }
    
    public static function updateDepartureType(array $departureTypeData){
        if(!isset($departureTypeData['departureType_id']) || trim($departureTypeData['departureType_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($departureTypeData['departureType_description']) || trim($departureTypeData['departureType_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
        if(!isset($departureTypeData['departureType_description']) || trim($departureTypeData['departureType_description']) == ''){
            throw new ControllerException('Bitte eine Beschreibung angeben.');
        }
 
        $id = $departureTypeData['departureType_id'];
        $name = trim($departureTypeData['departureType_name']);
        
        $departureType = R::findOne('departuretype', 'id = ?', [$id]);
        if(!$departureType){
            throw new ControllerException("Keine Eingangsart mit der id ". $id . " gefunden.");
        }

        $departureType['name'] = $name;
        $departureType['state'] = 'ACTIVE';
        $departureType['description'] = $departureTypeData['departureType_description'];
        R::store($departureType);
    } 

    public static function switchDepartureTypeState(array $departureTypeData){
        if(!isset($departureTypeData['departureType_id']) || trim($departureTypeData['departureType_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        $id = $departureTypeData['departureType_id'];
        
        $departureType = R::findOne('departuretype', 'id = ?', [$id]);
        if(!$departureType){
            throw new ControllerException("Keine Eingangsart mit der id ". $id . " gefunden.");
        }

        if ($departureType['state']==='ACTIVE') {
            $departureType['state'] = 'DEACTIVE';
        } else {
            $departureType['state'] = 'ACTIVE';
        }
        R::store($departureType);
    } 
    
}
