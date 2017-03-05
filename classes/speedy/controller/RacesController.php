<?php

namespace speedy\controller;

use \RedBeanPHP\R;

/**
 * Description of RacesController
 *
 * @author boreas
 */
class RacesController {
    
    public static function getAllRacesFor(\speedy\model\Species $species){
        $result = R::find('race', 'species_id = ?', [$species->id]);
        $data = [];
        foreach($result as $key => $value){
            $data[] = $value;
        }
        return $data;
    }    
    
    public static function createNewRace(array $raceData){
        
        if(!isset($raceData['name']) || trim($raceData['name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $raceName = trim($raceData['name']);
        if(!isset($raceData['species'])){
            throw new ControllerException("Bitte eine Tierart auswählen.");
        }
        
        
        
        $speciesId = intval(trim($raceData['species']));
        
        $species = R::findOne('race', 'name = ? and species_id = ? ', [$raceName, $speciesId]);
        if($species){
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
        echo("DONE!!!");
    }
}
