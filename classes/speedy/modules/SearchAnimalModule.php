<?php

namespace speedy\modules;

/**
 * Description of SearchAnimalModule
 *
 * @author binary gamura
 */
class SearchAnimalModule implements \speedy\common\Module {

    public function execute() {
        $response = new \speedy\common\TemplateResponse();
        $response->addTemplateName("search_animal.htpl");
        return $response;
    }

}
