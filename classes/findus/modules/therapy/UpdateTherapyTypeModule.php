<?php

namespace findus\modules\therapy;

use \RedBeanPHP\R;

/**
 * Description of UpdateTherapyTypeModule
 *
 * @author tierhilfe
 */
class UpdateTherapyTypeModule implements \findus\common\Module {
    
    public function execute() {
        $therapyTypeId = filter_input(INPUT_POST, 'therapyType_id', FILTER_VALIDATE_INT);
        $therapyTypeName = filter_input(INPUT_POST, 'therapyType_name');
        $therapyTypeDescription = filter_input(INPUT_POST, 'therapyType_description');
        if(!$therapyTypeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $therapyType = R::findOne('therapyType', 'id = ?', [$therapyTypeId]);
        if(!$therapyType){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$therapyTypeId." gefunden.");
        }
        \findus\controller\TherapyTypeController::updateTherapyType([
            'therapyType_id' => $therapyTypeId,
            'therapyType_name' => $therapyTypeName,
            'therapyType_description' => $therapyTypeDescription
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
