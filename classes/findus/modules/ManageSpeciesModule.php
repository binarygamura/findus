<?php

namespace findus\modules;

/**
 * Description of ManageSpeciesModule
 *
 * @author binary gamura
 */
class ManageSpeciesModule implements \findus\common\Module {

    public function execute() {
        $response = new \findus\common\TemplateResponse();
        
        $response->setValue('all_species', \findus\controller\SpeciesController::getAllSpecies());
        $response->addScript('species.js');
        $response->addTemplateName("list_species.htpl");
        $response->addTemplateName("list_races.htpl");
        return $response;
    }
}
