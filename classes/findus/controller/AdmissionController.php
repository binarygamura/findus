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
 * Description of AdmissionController
 *
 * @author boreas
 */
class AdmissionController {
    
    public static function addAdmission(array $admissionData, $animalBean = null){
        $admission = R::dispense('admission');
        $admission->date = $admissionData['date'];
        $admission->employee = EmployeeController::getEmployeeById($admissionData['employee_id']);
        if($admissionData['finder_id']>0) {
            $admission->finder = PersonController::getPersonById($admissionData['finder_id']);
        }
        if($admissionData['owner_id']>0) {
            $admission->owner = PersonController::getPersonById($admissionData['owner_id']);
        }        
        $admission->notes = trim($admissionData['notes']);
        $admission->reasons = trim($admissionData['reasons']);
        $admission->type = AdmissionTypeController::getAdmissionTypeById($admissionData['type_id']);        
        if($animalBean != null){
            $admission->animal = $animalBean;
        }
        $admission->id = R::store($admission);
        return $admission;
    }
    
    public static function getAdmissionsByAnimalId($animalId){
        return R::find('admission', 'animal_id = ? ORDER BY admission_inserted DESC', [$animalId]);
    }
    
    public static function editAdmission(array $admissionData){
        //TODO: later...
    }
}
