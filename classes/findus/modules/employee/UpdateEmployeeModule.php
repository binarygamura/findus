<?php

namespace findus\modules\employee;

use \RedBeanPHP\R;

/**
 * Description of UpdateEmployeeModule
 *
 * @author tierhilfe
 */
class UpdateEmployeeModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $employeeId = filter_input(INPUT_POST, 'employee_id', FILTER_VALIDATE_INT);
        $employeeName = filter_input(INPUT_POST, 'employee_name');
        $employeeFirstName = filter_input(INPUT_POST, 'employee_firstName');
        if(!$employeeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $employee = R::findOne('employee', 'id = ?', [$employeeId]);
        if(!$employee){
            throw new \findus\controller\ControllerException("Es wurde kein Mitarbeiter mit der ID ".$employeeId." gefunden.");
        }
        \findus\controller\EmployeeController::updateEmployee([
            'employee_id' => $employeeId,
            'employee_name' => $employeeName,
            'employee_firstName' => $employeeFirstName
            ]);

        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
