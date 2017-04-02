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
    public static function createNewAnimal(array $animalData){
        $animal = R::dispense('animal');
        foreach($animalData as $key => $value){
            $animal->$key = $value;
        }
        return R::store($animal);
    }
}
