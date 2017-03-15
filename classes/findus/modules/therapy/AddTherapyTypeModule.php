<?php

namespace findus\modules\therapy;

/**
 * Description of AddTherapyTypeModule
 *
 * @author tierhilfe
 */
class AddTherapyTypeModule implements \findus\common\Module{
    
    public function execute() {
//        try{
        $therapyTypeName = filter_input(INPUT_POST, 'therapyType_name');
        if(!$therapyTypeName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\TherapyTypeController::createNewTherapyType([
            'therapyType_name' => filter_input(INPUT_POST, 'therapyType_name'),
            'therapyType_description' => filter_input(INPUT_POST, 'therapyType_description')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
