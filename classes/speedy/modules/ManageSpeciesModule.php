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
        
        $response->setValue('all_species', \speedy\controller\SpeciesController::getAllSpecies());
        $response->addScript('species.js');
        $response->addTemplateName("list_species.htpl");
        $response->addTemplateName("list_races.htpl");
        return $response;
    }
}
