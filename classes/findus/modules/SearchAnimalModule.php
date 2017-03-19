<?php

namespace findus\modules;

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
        $response->addTemplateName("search_animal.htpl");
        return $response;
    }

}
