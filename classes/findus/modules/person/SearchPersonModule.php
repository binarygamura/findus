<?php

namespace findus\modules\person;

/**
 * Description of SearchPersonModule
 *
 * @author tierhilfe
 */
class SearchPersonModule  extends \findus\common\AbstractModule {
     
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    public function execute() {
        $response = new \findus\common\TemplateResponse();
        $response->setValue('all_persons', \findus\controller\PersonController::getAllPersons());
        $response->addScript('search_person.js');
        $response->addTemplateName("person\search_person.htpl");
        $response->addTemplateName("person\list_persons.htpl");
        return $response;
    }

}
