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
            $animalData['id'] = isset($animalData['id']) ? intval(trim($animalData['id'])) : 0;
            $id = $animalData['id'];

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
                $animalData['color'] = strtolower($animalData['color']);
            }
            
            
            $animalData['temp_admission']['type_id'] = isset($animalData['temp_admission']['type_id']) ? intval($animalData['temp_admission']['type_id']) : 0;
            if($animalData['temp_admission']['type_id'] <= 0){
                $errors['owner_id'] = "Bitte wählen sie den Zugangstyp aus.";
            }

            $animalData['temp_admission']['owner_id'] = isset($animalData['temp_admission']['owner_id']) ? intval($animalData['temp_admission']['owner_id']) : 0;
            $animalData['temp_admission']['finder_id'] = isset($animalData['temp_admission']['finder_id']) ? intval($animalData['temp_admission']['finder_id']) : 0;
            
            $animalData['temp_admission']['employee_id'] = isset($animalData['temp_admission']['employee_id']) ? intval($animalData['temp_admission']['employee_id']) : 0;
            if($animalData['temp_admission']['employee_id'] <= 0){
                $errors['owner_id'] = "Bitte geben sie den Mitarbeiter an.";
            }
            
            $animalData['temp_admission']['date'] = isset($animalData['temp_admission']['date']) ? trim($animalData['temp_admission']['date']) : '';
            if(!$animalData['temp_admission']['date'] || $animalData['temp_admission']['date'] == ''){
//                $errors['date'] = "Bitte geben Sie das Datum des Zugangs an! (".print_r($animalData['temp_admission'], true).")";
                $errors['date'] = "Bitte geben Sie das Datum des Zugangs an!";
            }
            $animalData['temp_admission']['date'] = \DateTime::createFromFormat('d.m.Y', $animalData['temp_admission']['date']);
            
            
            $animalData['temp_departure']['type_id'] = isset($animalData['temp_departure']['type_id']) ? intval($animalData['temp_departure']['type_id']) : 0;
            $animalData['temp_departure']['owner_id'] = isset($animalData['temp_departure']['owner_id']) ? intval($animalData['temp_departure']['owner_id']) : 0;
            $animalData['temp_departure']['employee_id'] = isset($animalData['temp_departure']['employee_id']) ? intval($animalData['temp_departure']['employee_id']) : 0;
            $animalData['temp_departure']['date'] = isset($animalData['temp_departure']['date']) ? trim($animalData['temp_departure']['date']) : '';
            $animalData['temp_departure']['date'] = \DateTime::createFromFormat('d.m.Y', $animalData['temp_departure']['date']);
            $animalData['temp_departure']['notes'] = isset($animalData['temp_departure']['notes']) ? trim($animalData['temp_departure']['notes']) : '';
 
            $animalData['attributes'] = isset($animalData['attributes']) ? trim($animalData['attributes']) : "";
            $animalData['chip'] = isset($animalData['chip']) ? trim($animalData['chip']) : "";            
            $animalData['tatoo'] = isset($animalData['tatoo']) ? trim($animalData['tatoo']) : "";
            $animalData['vaccinationCard'] = isset($animalData['vaccinationCard']) ? 1 : 0;
            $animalData['age'] = isset($animalData['age']) ? intval(trim($animalData['age'])) : 0;
            $animalData['sex'] = isset($animalData['sex']) ? trim($animalData['sex']) : "";
            if(!\findus\common\Util::isValidSex($animalData['sex'])){
                $errors['sex'] = "Bitte geben Sie das Geschlecht des Tieres an.";
            }
            
            $animalData['knownDiseases'] = isset($animalData['knownDiseases']) ? trim($animalData['knownDiseases']) : '';
            $animalData['generalState'] = isset($animalData['generalState']) ? trim($animalData['generalState']) : '';
            $animalData['behaviour'] = isset($animalData['behaviour']) ? trim($animalData['behaviour']) : '';
            $animalData['notes'] = isset($animalData['notes']) ? trim($animalData['notes']) : '';            
            $animalData['temp_admission']['reasons'] = isset($animalData['temp_admission']['reasons']) ? trim($animalData['temp_admission']['reasons']) : '';
            $animalData['temp_admission']['notes'] = isset($animalData['temp_admission']['notes']) ? trim($animalData['temp_admission']['notes']) : '';
            
            if(count($errors) > 0){
                $response = new \findus\common\JsonResponse($errors, 400);
            }
            else if ($id > 0) {
                \findus\controller\AnimalController::updateAnimal($animalData);
                $response = new \findus\common\JsonResponse(["id" => $id]);
            } else {
                $id = \findus\controller\AnimalController::createNewAnimal($animalData);
                $response = new \findus\common\JsonResponse(['id' => $id]);
            }
        }
        else {
            $response = new \findus\common\TemplateResponse();
            $response->setValue('all_species', \findus\controller\SpeciesController::getAllSpecies());
            $response->setValue('all_employees', \findus\controller\EmployeeController::getAllActiveEmployees());
            $response->setValue('all_admission_types', \findus\controller\AdmissionTypeController::getAllActiveAdmissionTypes());
            $response->setValue('all_departure_types', \findus\controller\DepartureTypeController::getAllActiveDepartureTypes());
            $response->addScript('add_animal.js');
            $response->addTemplateName('animal\add_animal.htpl');
        }
        return $response;
    }
}
