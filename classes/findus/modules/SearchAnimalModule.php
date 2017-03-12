<?php

namespace findus\modules;

/**
 * Description of SearchAnimalModule
 *
 * @author binary gamura
 */
class SearchAnimalModule implements \findus\common\Module {

    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->addTemplateName("search_animal.htpl");
        return $response;
    }

}
