<?php

namespace findus\modules\employee;

/**
 * Description of ManageEmployeesModule
 *
 * @author Tierhilfe
 */
class ManageEmployeesModule  extends \findus\common\AbstractModule {
    
    function __construct() {
        $this->requiredRole = \findus\model\User::MANAGEMENT;
    }
    
    public function execute() {
        $response = new \findus\common\TemplateResponse();
       
        try{
            if(filter_input(INPUT_POST, 'create_button')){
                \findus\controller\EmployeeController::createNewEmployee([
                    'employee_name' => filter_input(INPUT_POST, 'employee_name'),
                    'employee_firstName' => filter_input(INPUT_POST, 'employee_firstName')
                    ]);
            }
        }
        catch(\findus\controller\ControllerException $ex){
            $response->setValue('errors', [$ex->getMessage()]);
            $response->addTemplateName("page/errors.htpl");
        }
        
        $response->setValue('all_employees', \findus\controller\EmployeeController::getAllEmployees());
        $response->addScript('employee.js');
        $response->addTemplateName("employee\list_employees.htpl");
        return $response;
    }

}
