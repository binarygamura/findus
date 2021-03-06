<?php

namespace findus\modules\employee;

use \RedBeanPHP\R;

/**
 * Description of DeleteEmployeeModule
 *
 * @author tierhilfe
 */
class SwitchEmployeeStateModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $employeeId = filter_input(INPUT_POST, 'employee_id', FILTER_VALIDATE_INT);
        if(!$employeeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        \findus\controller\EmployeeController::switchEmployeeState([
            'employee_id' => $employeeId
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
