<?php

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

namespace findus\controller;

use \RedBeanPHP\R;
/**
 * Description of DepartureController
 *
 * @author boreas
 */
class DepartureController {
    
    public static function addDeparture(array $departureData, $animalBean = null){
        $departure = R::dispense('departure');
        $departure->date = $departureData['date'];
        
        $departure->employee = EmployeeController::getEmployeeById($departureData['employee_id']);
        if(!$departure->employee){
            throw new ControllerException("Es existiert kein Mitarbeiter mit der ID ".$departureData['employee_id']);
        }
        if($departureData['finder_id'] > 0) {
            $departure->finder = PersonController::getPersonById($departureData['finder_id']);
            if(!$departure->finder){
                throw new ControllerException("Es existiert keine Person (Finder) mit der ID ".$departureData['finder_id']);
            }
        }
        if($departureData['owner_id'] > 0) {
            $departure->owner = PersonController::getPersonById($departureData['owner_id']);
            if(!$departure->owner){
                throw new ControllerException("Es existiert keine Person (Besitzer) mit der ID ".$departureData['owner_id']);
            }
        }        
        $departure->notes = trim($departureData['notes']);
        $departure->reasons = trim($departureData['reasons']);
        print_r($departureData);
        $departure->type = DepartureTypeController::getDepartureTypeById($departureData['type_id']);        
        if(!$departure->type){
            throw new ControllerException("Es existiert kein Zugangstyp mit der ID ".$departureData['type_id']);
        }
        if($animalBean != null){
            $departure->animal = $animalBean;
        }
        $departure->id = R::store($departure);
        return $departure;
    }
    
    
    public static function getDeparturesByAnimalId($animalId){
        return R::find('departure', 'animal_id = ? ORDER BY date DESC', [$animalId]);
    }
    
    public static function editDeparture(array $departureData){
        //TODO: later...
    }
}
