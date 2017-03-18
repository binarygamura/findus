<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of VeterinarianControlle
 *
 * @author tierhilfe
 */
class VeterinarianController {
    
    public static function getAllVeterinarians(){
        return R::findAll('veterinarian');
    }
    
    public static function getVeterinarianById($veterinarianId){
        $veterinarian = R::findOne('veterinarian', 'id = ?', [$veterinarianId]);
        if(!$veterinarian){
            throw new ControllerException("Es existiert keine Behandlungsart mit der ID ".$veterinarianId);
        }
        return $veterinarian;
    }
    
    public static function createNewVeterinarian(array $veterinarianData){
        $newVeterinarian = R::dispense('veterinarian');
        if(!isset($veterinarianData['veterinarian_name']) || trim($veterinarianData['veterinarian_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
 
        $name = trim($veterinarianData['veterinarian_name']);
        
        $veterinarian = R::findOne('veterinarian', 'name = ?', [$name]);
        if($veterinarian){
            throw new ControllerException("Dieser Tierarzt ist bereits vorhanden.");
        }

        $newVeterinarian['name'] = $name;
        $newVeterinarian['description'] = $veterinarianData['veterinarian_description'];
        R::store($newVeterinarian);
    }
    
    public static function updateVeterinarian(array $veterinarianData){
        if(!isset($veterinarianData['veterinarian_id']) || trim($veterinarianData['veterinarian_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($veterinarianData['veterinarian_name']) || trim($veterinarianData['veterinarian_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
 
        $id = $veterinarianData['veterinarian_id'];
        $name = trim($veterinarianData['veterinarian_name']);
        
        $veterinarian = R::findOne('veterinarian', 'id = ?', [$id]);
        if(!$veterinarian){
            throw new ControllerException("Kein Tierarzt mit der id ". $id . " gefunden.");
        }

        $veterinarian['name'] = $name;
        $veterinarian['description'] = $veterinarianData['veterinarian_description'];
        R::store($veterinarian);
    } 
}
