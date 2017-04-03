<?php
namespace findus\controller;


/*
 * Copyright 2017 binary gamura.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


use \RedBeanPHP\R;
/**
 * Description of AnimalController
 *
 * @author binary gamura
 */
class AnimalController {
    
    public static function getAllAnimals(){
        return R::findAll('animal');
    }
    
    public static function getAnimalsByFilter($searchFilter){
        foreach ($searchFilter as $nr => $inhalt)
        {
            $sql .= strtolower($inhalt['field']) ." = ?, ";
            $values .= $inhalt['value'] .", ";
        }
        
        $result = R::find('person', substr($sql,0,-2), substr($values,0,-2));
        if(!$result){
            throw new ControllerException("Es existiert kein Tier mit den Parametern ".$searchFilter);
        }
        $data = [];
        foreach($result as $key => $value){
            $data[] = $value;
        }
        return $data;
    }

    public static function createNewAnimal(array $animalData){
        $animal = R::dispense('animal');
        foreach($animalData as $key => $value){
            $animal->$key = $value;
        }
        return R::store($animal);
    }
}
