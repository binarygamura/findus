<?php

namespace speedy\modules;

/**
 * Description of ManageSpeciesModule
 *
 * @author binary gamura
 */
class ManageSpeciesModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \speedy\controller\SpeciesController::createNewSpecies(['species_name' => filter_input(INPUT_POST, 'species_name')]);
            }
        }
        catch(\speedy\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("errors.htpl");
        }
        
        $response->setValue('all_species', \speedy\controller\SpeciesController::getAllSpecies());
        $response->addScript('species.js');
//        $response->addTemplateName("add_species.htpl");
        $response->addTemplateName("list_species.htpl");
        $response->addTemplateName("list_races.htpl");
        return $response;
    }

}
