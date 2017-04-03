<?php

namespace findus\modules\animal;

/**
 * Description of SearchAnimalModule
 *
 * @author binary gamura
 */
class SearchAnimalModule  extends \findus\common\AbstractModule {
     
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->setValue('all_animals', \findus\controller\AnimalController::getAllAnimals());
        $response->setValue('all_species', \findus\controller\SpeciesController::getAllSpecies());
        $response->addScript('search_animal.js');
        $response->addTemplateName("animal\search_animal.htpl");
        $response->addTemplateName("animal\list_animals.htpl");
        return $response;
    }

}
