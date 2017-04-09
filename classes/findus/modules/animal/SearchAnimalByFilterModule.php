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

        if ($speciesId && $speciesId > -1) {
            $filter[] = array('field' => 'species', 
                      'value'   => $speciesId);
        }
        if ($raceId && $raceId > -1) {
            $filter[] = array('field' => 'race_id', 
                      'value'   => $raceId);
        }
        if ($sex && $sex != "#animal\\[sex\\]") {
            $filter[] = array('field' => 'sex', 
                      'value'   => $sex);
        }
        if ($color) {
            $filter[] = array('field' => 'color', 
                      'value'   => $color);
        }
        

        $response = new \findus\common\JsonResponse();
        $response->setJson(["data" => \findus\controller\AnimalController::getAnimalsByFilter($filter)]);
        return $response;
    }

}
