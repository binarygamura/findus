<?php

namespace findus\modules\therapy;

/**
 * Description of ManageTherapyTypesModule
 *
 * @author Tierhilfe
 */
class ManageTherapyTypesModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \findus\controller\TherapyTypeController::createNewTherapyType([
                    'therapyType_name' => filter_input(INPUT_POST, 'therapyType_name'),
                    'therapyType_description' => filter_input(INPUT_POST, 'therapyType_description')
                    ]);
            }
        }
        catch(\findus\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("page/errors.htpl");
        }
        
        $response->setValue('all_therapyTypes', \findus\controller\TherapyTypeController::getAllTherapyTypes());
        $response->addScript('therapyType.js');
        $response->addTemplateName("therapy\list_therapyTypes.htpl");
        return $response;
    }

}
