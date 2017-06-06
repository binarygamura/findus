<?php namespace findus\modules\person;



/**
 * Description of UpdatePersonModule
 *
 * @author tierhilfe
 */
class UpdatePersonModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        
        if(isset($_POST)){
            $errors = [];
            $personData = $_POST['person'];
            
            $personData['id'] = isset($personData['id']) ? intval(trim($personData['id'])) : 0;
            if($personData['id'] <= 0){
                $errors['id'] = "Bitte den Datensatz erst anlegen.";
            }
            $personData['person_name'] = isset($personData['name']) ? trim($personData['name']) : "";
            if($personData['name'] == ""){
                $errors['name'] = "Bitte geben Sie einen Namen an. (".$personData['name'].")";
            }
            $personData['street'] = isset($personData['street']) ? trim($personData['street']) : "";
            if($personData['street'] == ""){
                $errors['street'] = "Bitte geben Sie eine Straße an. (".$personData['street'].")";
            }
            $personData['city'] = isset($personData['city']) ? trim($personData['city']) : "";
            if($personData['city'] == ""){
                $errors['city'] = "Bitte geben Sie einen Ort an. (".$personData['city'].")";
            }
            
            $personData['organization'] = isset($personData['organization']) ? 1 : 0;
            $personData['postalcode'] = isset($personData['postalcode']) ? trim($personData['postalcode']) : "";
            $personData['remarks'] = isset($personData['remarks']) ? trim($personData['remarks']) : "";
            $personData['phone'] = isset($personData['phone']) ? trim($personData['phone']) : "";
            
            if(count($errors) > 0){
                $response = new \findus\common\JsonResponse($errors, 400);
            }
            else {
                $id = \findus\controller\PersonController::updatePerson($personData);
                $response = new \findus\common\JsonResponse(["id" => $id]);
            }
        }
        else {
            
            $personId = filter_input(INPUT_GET, 'person_id', FILTER_VALIDATE_INT);
            if($personId === false){
                throw new \findus\common\ModuleException('Es wurde keine ID angegeben.');
            }
            $person = \findus\controller\PersonController::getPersonById($personId);
            $response = new \findus\common\TemplateResponse();
            $response->setValue('person', $person);
            $response->addScript('add_person.js');
            $response->addTemplateName("person\add_person.htpl");
        }
        return $response;
    }
}
