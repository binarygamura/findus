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

    public static function getPersonsByFilter(array $searchFilter){
        $sql = "";
        $valueArray = array();
        foreach ($searchFilter as $nr => $inhalt)
        {            
            if (($inhalt['field'] == 'name') || ($inhalt['field'] == 'city') || ($inhalt['field'] == 'street')) {
                $sql .= strtolower($inhalt['field']) ." like ? " ." and ";
                $valueArray[] = "%" .strtolower($inhalt['value']) ."%";
            } else {
                $sql .= strtolower($inhalt['field']) ." = ? " ." and ";
                $valueArray[] = $inhalt['value'];
            }
        }
        
        $result = R::find('person', substr($sql,0,-4), $valueArray);
        $data = [];
        foreach($result as $value){
            $data[] = $value;
        }
        return $data;
    }

    public static function updatePerson(array $personData){
        $personId = $personData['id'];
        $person = R::findOne("person", "id = ?", [$personId]);
        
        foreach($personData as $key => $value){
            $person->$key = $value;
        }

        R::store($person);
        return $person;
    }
    
    public static function createNewPerson(array $personData){
        $person = R::dispense('person');
        
        foreach($personData as $key => $value){
            $person->$key = $value;
        }

        R::store($person);
        return $person;
    }

}
