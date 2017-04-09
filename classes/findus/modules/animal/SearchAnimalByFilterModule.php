<?php

namespace findus\modules\animal;

/**
 * Description of SearchAnimalModule
 *
 * @author binary gamura
 */
class SearchAnimalByFilterModule  extends \findus\common\AbstractModule {
     
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    public function execute() {
        $speciesId = filter_input(INPUT_GET, 'species_id', FILTER_VALIDATE_INT);        
        $raceId = filter_input(INPUT_GET, 'race_id', FILTER_VALIDATE_INT);        
        $sex = filter_input(INPUT_GET, 'sex');        
        $color = filter_input(INPUT_GET, 'color');        
        $chip = filter_input(INPUT_GET, 'color');        
        $tatoo = filter_input(INPUT_GET, 'color');        

        if ($speciesId && $speciesId > -1) {
            $filter[] = array('field' => 'species', 
                      'value'   => $speciesId);
        }
        if ($raceId && $raceId > -1) {
            $filter[] = array('field' => 'race', 
                      'value'   => $raceId);
        }
        if ($sex) {
            $filter[] = array('field' => 'sex', 
                      'value'   => $sex);
        }
        if ($chip) {
            $filter[] = array('field' => 'chip', 
                      'value'   => $chip);
        }
        if ($tatoo) {
            $filter[] = array('field' => 'tatoo', 
                      'value'   => $tatoo);
        }
        

        $response = new \findus\common\JsonResponse();
        $response->setJson(["data" => \findus\controller\AnimalController::getAnimalsByFilter($filter)]);
        return $response;
    }

}
