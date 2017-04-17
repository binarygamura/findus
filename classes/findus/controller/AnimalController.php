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
        $sql = "";
        $valueArray = array();
        foreach ($searchFilter as $nr => $inhalt)
        {            
            if (($inhalt['field'] == 'color') || ($inhalt['field'] == 'tatoo')) {
                $sql .= strtolower($inhalt['field']) ." like ? " ." and ";
                $valueArray[] = "%" .strtolower($inhalt['value']) ."%";
            } else {
                $sql .= strtolower($inhalt['field']) ." = ? " ." and ";
                $valueArray[] = $inhalt['value'];
            }
        }
        
        $result = R::find('animal', substr($sql,0,-4), $valueArray);
        $data = [];
        foreach($result as $value){
            $data[] = $value;
        }
        return $data;
    }

    public static function getAnimalById($id){
        return R::findOne("animal", "id = ?", [$id]);
    }


    public static function createNewAnimal(array $animalData){
        $animal = R::dispense('animal');
        foreach($animalData as $key => $value){
            $animal->$key = $value;
        }
        if($animal->bundle_id > 0){
            $bundle = R::findOne("imagebundle", "id = ?", [$animal->bundle_id]);
            if(isset($animal->portrait) && $animal->portrait != ""){
                foreach($bundle->ownImageList as $image){
                    if($animal->portrait == $image->name){
                        $image->isPortrait = true;
                        break;
                    }
                }
            }
            else{
                foreach($bundle->ownImageList as $image){
                    $image->isPortrait = true;
                    break;
                }
            }
            R::store($bundle);
            $animal->bundle = $bundle;
            
            count($animal->bundle->ownImageList);
        }
        return R::store($animal);
    }
    
    public static function updateAnimal(array $animalData){
        $animalId = $animalData['id'];
        $animal = R::findOne("animal", "id = ?", [$animalId]);
        
        foreach($animalData as $key => $value){
            $animal->$key = $value;
        }
        R::store($animal);
        return $animal;
    }

    public static function getLatestFoundAnimals($limit = 5){
        $animals = R::find("animal", "bundle_id != 0 ORDER BY id LIMIT ?", [$limit]);
        $result = [];
        foreach($animals as $animal){
            $animal->bundle = R::findOne("imageBundle", "id = ?", [$animal->bundle_id]);
            count($animal->bundle->ownImageList);
            $result[] = $animal;
        }
        return $result;
    }
}
