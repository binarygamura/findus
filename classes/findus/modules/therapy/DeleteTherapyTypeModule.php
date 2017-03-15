<?php

namespace findus\modules\therapy;

use \RedBeanPHP\R;

/**
 * Description of DeleteTherapyTypeModule
 *
 * @author tierhilfe
 */
class DeleteTherapyTypeModule implements \findus\common\Module {
    
    public function execute() {
        $therapyTypeId = filter_input(INPUT_POST, 'therapyType_id', FILTER_VALIDATE_INT);
        if(!$therapyTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $therapyType = R::findOne('therapyType', 'id = ?', [$therapyTypeId]);
        if(!$therapyType){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$therapyTypeId." gefunden.");
        }
        R::trash($therapyType);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
