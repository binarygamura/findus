<?php

/*
 * Copyright 2017 boreas.
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

//error_reporting(0);
//use the nice classloader provided by composer.
$classLoader = require_once './vendor/autoload.php';
$classLoader->add('findus', "./classes");

use findus\common\Util;
use \RedBeanPHP\R;


R::setup("mysql:host=localhost;dbname=findus", "root", "");
R::ext('preload');

$admissionData = [
    "employee_id" => 1,
    "notes" => "einige notizen",
    "reasons" => "Gründe",
    "finder_id" => 1,
    "owner_id" => 1,
    "type_id" => 1,
    "date" => "2017-11-20"
];

$animal = \findus\controller\AnimalController::getAnimalById(4);
print_r($animal);

//print_r(\findus\controller\AdmissionController::addAdmission($admissionData));




//$room1 = R::dispense("shop");
//$room1->location = "test1";
//R::store($room1);
//
//$room2 = R::dispense("shop");
//$room2->location = "test2";
//R::store($room2);
//
//
//$house = R::dispense("house");
//$house->ownShopList[] = $room1;
//$house->ownShopList[] = $room2;
//$house->name = "test-house #1";
//$id = R::store($house);
//
//echo("house ".$id);
//
//
//$loaded = R::findOne("house", "id = ?", [$id]);
//foreach($loaded->ownShopList  as $room){
//    echo(">>".$room->location);
//}