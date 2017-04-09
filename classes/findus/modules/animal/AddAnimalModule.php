<?php namespace findus\modules\animal;



/**
 * Description of AddAnimalModule
 *
 * @author binary gamura
 */
class AddAnimalModule extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::USER;
    }
    
    public function execute() {
        
        if(filter_input(INPUT_POST, 'create_button')){
            $errors = [];
            $animalData = $_POST['animal'];
            
            //TODO: the following code looks very repetitive. perhaps we should refactor things here
            //and put code into functions.
            $animalData['name'] = isset($animalData['name']) ? trim($animalData['name']) : "";
            if($animalData['name'] == ""){
                $errors['name'] = "Bitte geben Sie einen Namen an. (".$animalData['name'].")";
            }
            
            $animalData['species'] = isset($animalData['species']) ? intval(trim($animalData['species'])) : 0;
            if($animalData['species'] <= 0){
                $errors['species'] = "Bitte geben Sie die Tierart an.";
            }            
            
            $animalData['race'] = isset($animalData['race']) ? intval(trim($animalData['race'])) : 0;
            if($animalData['race'] <= 0){
                $errors['race'] = "Bitte geben Sie die Tierrasse an.";
            }
            
            $animalData['color'] = isset($animalData['color']) ? trim($animalData['color']) : "";
            if($animalData <= 0){
                $errors['color'] = "Bitte geben Sie die Färbung des Tieres an.";
            } else {
                $animalData['color'] = tolower($animalData['color']);
            }
            
            $animalData['attributes'] = isset($animalData['attributes']) ? trim($animalData['attributes']) : "";
            $animalData['chip'] = isset($animalData['chip']) ? trim($animalData['chip']) : "";            
            $animalData['tatoo'] = isset($animalData['tatoo']) ? trim($animalData['tatoo']) : "";
            $animalData['vaccinationCard'] = isset($animalData['vaccinationCard']) ? 1 : 0;
            $animalData['age'] = isset($animalData['age']) ? intval(trim($animalData['age'])) : 0;
            $animalData['sex'] = isset($animalData['sex']) ? trim($animalData['sex']) : "";
            if(!\findus\common\Util::isValidSex($animalData['sex'])){
                $errors['sex'] = "Bitte geben Sie das Geschlecht des Tieres an.";
            }
            
            $animalData['knownDiseases'] = isset($animalData['knownDiseases']) ? trim($animalData['knownDiseases']) : "";
            $animalData['generalState'] = isset($animalData['generalState']) ? trim($animalData['generalState']) : "";
            $animalData['behaviour'] = isset($animalData['behaviour']) ? trim($animalData['behaviour']) : "";
            $animalData['notes'] = isset($animalData['notes']) ? trim($animalData['notes']) : "";
            
            if(count($errors) > 0){
                $response = new \findus\common\JsonResponse($errors, 400);
            }
            else {
                $id = \findus\controller\AnimalController::createNewAnimal($animalData);
                $response = new \findus\common\JsonResponse(["id" => $id]);
            }
        }
        else {
            $response = new \findus\common\TemplateResponse();
            $response->setValue('all_species', \findus\controller\SpeciesController::getAllSpecies());
            $response->addScript("add_animal.js");
            $response->addTemplateName("animal\add_animal.htpl");
        }
        return $response;
    }
}
