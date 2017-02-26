<?php

namespace speedy\controller;

use \RedBeanPHP\R;

/**
 * Description of SpeciesController
 *
 * @author binary gamura
 */
class SpeciesController {
    
    public static function getAllSpecies(){
        return R::findAll('species');
    }
    
    public static function createNewSpecies(array $speciesData){
        $newSpecies = R::dispense('species');
        if(!isset($speciesData['species_name']) || trim($speciesData['species_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        $name = trim($speciesData['species_name']);
        $matches = R::find('species', 'LOWER(name) = ?', [strtolower($name)]);
        if(count($matches) > 0){
            throw new ControllerException('Diese Tierart ist bereits vorhanden.');
        }
        $newSpecies['name'] = $speciesData['species_name'];
        R::store($newSpecies);
    }
}
