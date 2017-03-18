<?php

namespace findus\modules\veterinarian;

/**
 * Description of ManageVeterinariansModule
 *
 * @author Tierhilfe
 */
class ManageVeterinariansModule implements \findus\common\Module {

    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \findus\controller\VeterinarianController::createNewVeterinarian([
                    'veterinarian_name' => filter_input(INPUT_POST, 'veterinarian_name'),
                    'veterinarian_description' => filter_input(INPUT_POST, 'veterinarian_description')
                    ]);
            }
        }
        catch(\findus\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("page/errors.htpl");
        }
        
        $response->setValue('all_veterinarians', \findus\controller\VeterinarianController::getAllVeterinarians());
        $response->addScript('veterinarian.js');
        $response->addTemplateName("veterinarian\list_veterinarians.htpl");
        return $response;
    }

}
