<?php namespace speedy\modules;

/**
 * Description of AddAnimalModule
 *
 * @author binary gamura
 */
class AddAnimalModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("add_animal.htpl");
        return $response;
    }

}
