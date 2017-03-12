<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of RacesController
 *
 * @author boreas
 */
class RacesController {
    
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
        $newRace->species = $species;
        $species->races[] = $newRace;
        
        R::store($newRace);
        R::store($species);
    }
}
