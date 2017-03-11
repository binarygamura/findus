<?php namespace speedy\modules;

/**
 * Description of AddAnimalModule
 *
 * @author binary gamura
 */
class AddAnimalModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->setValue('all_species', \speedy\controller\SpeciesController::getAllSpecies());
        if(filter_input(INPUT_POST, 'create_button')){
            print_r($_POST);
        }
        else {
            
        }
        $response->addScript("add_animal.js");
        $response->addTemplateName("add_animal.htpl");
        return $response;
    }

}
