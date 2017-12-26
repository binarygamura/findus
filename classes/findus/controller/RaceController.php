<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of RacesController
 *
 * @author binary gamura
 */
class RaceController {
    
    public static function getAllRacesFor(\findus\model\Species $species){
        $result = R::find('race', 'species_id = ? AND state = \'ACTIVE\'', [$species->id]);
        $data = [];
        foreach($result as $key => $value){
            $data[] = $value;
        }
        return $data;
    }    
    
    public static function createNewRace(array $raceData){
        
        if(!isset($raceData['race_name']) || trim($raceData['race_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $raceName = trim($raceData['race_name']);
        if(!isset($raceData['species_id'])){
            throw new ControllerException("Bitte eine Tierart auswählen.");
        }
        
        $speciesId = intval(trim($raceData['species_id']));
        
        $race = R::findOne('race', 'name = ? and species_id = ? ', [$raceName, $speciesId]);
        if($race){
            throw new ControllerException("Diese Tierrasse ist bereits vorhanden.");
        }
        
        $species = R::findOne('species', 'id = ?', [$speciesId]);
        if(!$species){
            throw new ControllerException("Die Tierspezies mit der ID ".$speciesId." wurde nicht gefunden.");
        }
        $newRace = R::dispense('race');
        $newRace->name = $raceName;
        $newRace->state = 'ACTIVE';
        $newRace->species = $species;
//        $species->races[] = $newRace;
        
        R::store($species);
        return R::store($newRace);
    }
    public static function updateRace(array $raceData){
        if(!isset($raceData['race_id']) || trim($raceData['race_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($raceData['race_name']) || trim($raceData['race_name']) == ''){
            throw new ControllerException('Bitte eine Bezeichnung angeben.');
        }
 
        $id = $raceData['race_id'];
        $name = trim($raceData['race_name']);
        
        $race = R::findOne('race', 'id = ?', [$id]);
        if(!$race){
            throw new ControllerException("Keine Rasse mit der id "+ $id + " gefunden.");
        }

        $race['name'] = $name;
        R::store($race);
    } 
}
