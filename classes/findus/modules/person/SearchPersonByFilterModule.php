<?php

namespace findus\modules\person;

/**
 * Description of SearchPersonModule
 *
 * @author tierhilfe
 */
class SearchPersonByFilterModule  extends \findus\common\AbstractModule {
     
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    public function execute() {
        $organization = filter_input(INPUT_GET, 'organization', FILTER_VALIDATE_INT);        
        $name = filter_input(INPUT_GET, 'name');        
        $street = filter_input(INPUT_GET, 'street');        
        $city = filter_input(INPUT_GET, 'city');        

        if ($organization && $organization > -1) {
            $filter[] = array('field' => 'organization', 
                      'value'   => $organization);
        }
        if ($name) {
            $filter[] = array('field' => 'name', 
                      'value'   => $name);
        }
        if ($city) {
            $filter[] = array('field' => 'city', 
                      'value'   => $city);
        }
        if ($street) {
            $filter[] = array('field' => 'street', 
                      'value'   => $street);
        }
        

        $response = new \findus\common\JsonResponse();
        $response->setJson(["data" => \findus\controller\PersonController::getPersonsByFilter($filter)]);
        return $response;
    }

}
