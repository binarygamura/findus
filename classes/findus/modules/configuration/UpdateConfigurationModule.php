<?php

namespace findus\modules\configuration;

use \RedBeanPHP\R;

/**
 * Description of UpdateConfigurationModule
 *
 * @author tierhilfe
 */
class UpdateConfigurationModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::ADMIN;
    }
    
    public function execute() {
        $configurationSpinnerTime = filter_input(INPUT_POST, 'configuration_spinnerTime', FILTER_VALIDATE_INT);
        $configurationSpinnerDays = filter_input(INPUT_POST, 'configuration_spinnerDays', FILTER_VALIDATE_INT);
        $configurationSpinnerMax = filter_input(INPUT_POST, 'configuration_spinnerMax', FILTER_VALIDATE_INT);
        $configurationSpinnerMin = filter_input(INPUT_POST, 'configuration_spinnerMin', FILTER_VALIDATE_INT);
        $configurationContactLine1 = filter_input(INPUT_POST, 'configuration_contactLine1');
        $configurationContactLine2 = filter_input(INPUT_POST, 'configuration_contactLine2');
        $configurationContactLine3 = filter_input(INPUT_POST, 'configuration_contactLine3');
        $configurationContactLine4 = filter_input(INPUT_POST, 'configuration_contactLine4');
        $configurationContactLine5 = filter_input(INPUT_POST, 'configuration_contactLine5');
        
        $configuration = R::findOne('configuration', 'id = 1');
        if(!$admissionType){
            
            throw new \findus\controller\ControllerException("Es wurde keine Eingangsart mit der ID ".$admissionTypeId." gefunden.");
        }
        
        \findus\controller\ConfigurationController::updateConfiguration([
            'configuration_spinnerTime' => $configurationSpinnerTime,
            'configuration_spinnerDays' => $configurationSpinnerDays,
            'configuration_spinnerMin' => $configurationSpinnerMin,
            'configuration_spinnerMax' => $configurationSpinnerMax,
            'configuration_contactLine1' => $configurationContactLine1,
            'configuration_contactLine2' => $configurationContactLine2,
            'configuration_contactLine3' => $configurationContactLine3,
            'configuration_contactLine4' => $configurationContactLine4,
            'configuration_contactLine5' => $configurationContactLine5,
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
