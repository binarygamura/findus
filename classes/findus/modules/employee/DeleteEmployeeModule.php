<?php

namespace findus\modules\employee;

use \RedBeanPHP\R;

/**
 * Description of DeleteEmployeeModule
 *
 * @author tierhilfe
 */
class DeleteEmployeeModule implements \findus\common\Module {
    
    public function execute() {
        $employeeId = filter_input(INPUT_POST, 'employee_id', FILTER_VALIDATE_INT);
        if(!$employeeId){
            throw new \findus\controller\ControllerException("Es wurde keine ID angegeben.");
        }
        $employee = R::findOne('employee', 'id = ?', [$employeeId]);
        if(!$employee){
            throw new \findus\controller\ControllerException("Es wurde kein Benutzer mit der ID ".$employeeId." gefunden.");
        }
        R::trash($employee);
        $response = new \findus\common\JsonResponse();
        $response->setBody("{}");
        return $response;
    }
}
