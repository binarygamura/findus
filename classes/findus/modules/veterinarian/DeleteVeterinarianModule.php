<?php

namespace findus\modules\veterinarian;

use \RedBeanPHP\R;

/**
 * Description of DeleteVeterinarianModule
 *
 * @author tierhilfe
 */
class DeleteVeterinarianModule implements \findus\common\Module {
    
    public function execute() {
        $veterinarianId = filter_input(INPUT_POST, 'veterinarian_id', FILTER_VALIDATE_INT);
        if(!$veterinarianId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $veterinarian = R::findOne('veterinarian', 'id = ?', [$veterinarianId]);
        if(!$veterinarian){
            throw new \findus\controller\ControllerException("Es wurde kein Tierarzt mit der ID ".$veterinarianId." gefunden.");
        }
        R::trash($veterinarian);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
