<?php

namespace findus\modules\veterinarian;

use \RedBeanPHP\R;

/**
 * Description of SwitchVeterinarianStateModule
 *
 * @author tierhilfe
 */
class SwitchVeterinarianStateModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $veterinarianId = filter_input(INPUT_POST, 'veterinarian_id', FILTER_VALIDATE_INT);
        if(!$veterinarianId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        \findus\controller\VeterinarianController::switchVeterinarianState([
            'veterinarian_id' => $veterinarianId
            ]);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
