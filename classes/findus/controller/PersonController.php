<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of SpeciesController
 *
 * @author tierhilfe
 */
class PersonController {
    
    public static function getAllPersons(){
        return R::findAll('person');
    }
    
    public static function getPersonById($personId){
        $person = R::findOne('person', 'id = ?', [$personId]);
        if(!$person){
            throw new ControllerException("Es existiert keine Person mit der ID ".$personId);
        }
        return $person;
    }
    
    public static function getPersonsByName($personName){
        $result = R::find('person', 'name = ?', [$personName]);
        if(!$result){
            throw new ControllerException("Es existiert keine Person mit dem Namen ".$personName);
        }
        $data = [];
        foreach($result as $key => $value){
            $data[] = $value;
        }
        return $data;
    }

    public static function createNewPerson(array $personData){
        $newPerson = R::dispense('person');
        if(!isset($personData['person_name']) || trim($personData['person_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        if(!isset($personData['person_street']) || trim($personData['person_street']) == ''){
            throw new ControllerException('Bitte eine Straße angeben.');
        }
        if(!isset($personData['person_city']) || trim($personData['person_city']) == ''){
            throw new ControllerException('Bitte einen Ort angeben.');
        }
 
        $name = trim($personData['person_name']);
        $street = trim($personData['person_street']);
        
        $matches = R::find('person', 'name = ? and street = ? ', [$name, $street]);
        if(count($matches) > 0){
            throw new ControllerException('Diese Person ist bereits vorhanden.');
        }
        $newPerson['name'] = $name;
        $newPerson['street'] = $street;
        $newPerson['postcode'] = $personData['person_postcode'];
        $newPerson['city'] = $personData['person_city'];
        $newPerson['mobilePhone'] = $personData['person_mobilePhone'];
        $newPerson['organisation'] = $personData['person_organisation'];
        R::store($newPerson);
    }
}
