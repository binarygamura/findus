<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace speedy\modules;

/**
 * Description of ManageRacesModule
 *
 * @author binary gamura
 */
class ManageRacesModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \speedy\controller\RacesController::createNewRace([
                    'species' => filter_input(INPUT_POST, 'species'),
                    'name' => filter_input(INPUT_POST, 'race_name')
                    ]);
            }
        }
        catch(\speedy\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("errors.htpl");
            
        }
        
        $allSpecies = \speedy\controller\SpeciesController::getAllSpecies();
        $response->setValue('all_species', $allSpecies);
        
        $response->addTemplateName("add_race.htpl");
        $response->addTemplateName("list_races.htpl");
        return $response;
    }

}
