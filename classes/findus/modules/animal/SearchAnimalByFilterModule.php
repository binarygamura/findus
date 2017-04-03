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
        $speciesId = filter_input(INPUT_GET, 'species_id', FILTER_VALIDATE_INT);        
        $raceId = filter_input(INPUT_GET, 'race_id', FILTER_VALIDATE_INT);        
        $sex = filter_input(INPUT_GET, 'sex');        
        $age = filter_input(INPUT_GET, 'age');        

        if ($speciesId) {
            $filter[] = array('field' => 'species_id', 
                      'value'   => $speciesId);
        }
        if ($raceId) {
            $filter[] = array('field' => 'race_id', 
                      'value'   => $raceId);
        }
        if ($sex) {
            $filter[] = array('field' => 'sex', 
                      'value'   => $sex);
        }
        if ($age) {
            $filter[] = array('field' => 'age', 
                      'value'   => $age);
        }
        
        $response = new \findus\common\TemplateResponse();
        $response->setValue('all_animals', \findus\controller\AnimalController::getAnimalsByFilter($filter));
        return $response;
    }

}
