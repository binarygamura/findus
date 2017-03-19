<?php

namespace findus\modules\employee;

/**
 * Description of AddEmployeeModule
 *
 * @author tierhilfe
 */
class AddEmployeeModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
//        try{
        $employeeName = filter_input(INPUT_POST, 'employee_name');
        if(!$employeeName){
            throw new \findus\controller\ControllerException("Bitte geben Sie einen Namen an.");
            
        }
        \findus\controller\EmployeeController::createNewEmployee([
            'employee_name' => filter_input(INPUT_POST, 'employee_name'),
            'employee_firstName' => filter_input(INPUT_POST, 'employee_firstName')
            ]);
        $resonse = new \findus\common\JsonResponse();
        $resonse->setBody("{}");
        return $resonse;
    }
}
