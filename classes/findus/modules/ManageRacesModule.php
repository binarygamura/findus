<?php
//
///*
// * To change this license header, choose License Headers in Project Properties.
// * To change this template file, choose Tools | Templates
// * and open the template in the editor.
// */
//
//namespace findus\modules;
//
///**
// * Description of ManageRacesModule
// *
// * @author binary gamura
// */
//class ManageRacesModule implements \findus\common\Module {
//
//    public function execute() {
//        $response = new \findus\common\TemplateResponse();
//        
//        try{
//            if(filter_input(INPUT_POST, 'create_button')){
//                \findus\controller\RacesController::createNewRace([
//                    'species' => filter_input(INPUT_POST, 'species'),
//                    'name' => filter_input(INPUT_POST, 'race_name')
//                    ]);
//            }
//        }
//        catch(\findus\controller\ControllerException $ex){
//            $response->setValue('errors', [$ex->getMessage()]);
//            $response->addTemplateName("errors.htpl");
//            
//        }
//        
//        $allSpecies = \findus\controller\SpeciesController::getAllSpecies();
//        $response->setValue('all_species', $allSpecies);
//        
//        $response->addTemplateName("add_race.htpl");
//        $response->addTemplateName("list_races.htpl");
//        return $response;
//    }
//
//}
