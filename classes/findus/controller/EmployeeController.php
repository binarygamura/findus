<?php

namespace findus\controller;

use \RedBeanPHP\R;

/**
 * Description of EmployeeControlle
 *
 * @author tierhilfe
 */
class EmployeeController {
    
    public static function getAllEmployees(){
        return R::findAll('employee');
    }

    public static function getAllActiveEmployees(){
        return R::find('employee','state=\'ACTIVE\' ORDER BY name, first_name ASC');
    }
    
    public static function getEmployeeById($employeeId){
        $employee = R::findOne('employee', 'id = ?', [$employeeId]);
        if(!$employee){
            throw new ControllerException("Es existiert kein Vereinsmitglied mit der ID ".$employeeId);
        }
        return $employee;
    }
    
    public static function createNewEmployee(array $employeeData){
        $newEmployee = R::dispense('employee');
        if(!isset($employeeData['employee_name']) || trim($employeeData['employee_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        if(!isset($employeeData['employee_firstName']) || trim($employeeData['employee_firstName']) == ''){
            throw new ControllerException('Bitte einen Vornamen angeben.');
        }
 
        $name = trim($employeeData['employee_name']);
        $firstName = trim($employeeData['employee_firstName']);
        
        $employee = R::findOne('employee', 'name = ? and firstname = ?', [$name, $firstName]);
        if($employee){
            throw new ControllerException("Dieses Vereinsmitglied ist bereits vorhanden.");
        }

        $newEmployee['name'] = $name;
        $newEmployee['firstName'] = $employeeData['employee_firstName'];
        $newEmployee['state'] = 'ACTIVE';
        R::store($newEmployee);
    }
    
    public static function updateEmployee(array $employeeData){
        if(!isset($employeeData['employee_id']) || trim($employeeData['employee_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
        if(!isset($employeeData['employee_name']) || trim($employeeData['employee_name']) == ''){
            throw new ControllerException('Bitte einen Namen angeben.');
        }
        if(!isset($employeeData['employee_firstName']) || trim($employeeData['employee_firstName']) == ''){
            throw new ControllerException('Bitte einen Vornamen angeben.');
        }
 
        $id = $employeeData['employee_id'];
        $name = trim($employeeData['employee_name']);
        $firstName = trim($employeeData['employee_firstName']);
        
        $employee = R::findOne('employee', 'id = ?', [$id]);
        if(!$employee){
            throw new ControllerException("Kein Vereinsmitglied mit der id "+ $id + " gefunden.");
        }

        $employee['name'] = $name;
        $employee['firstName'] = $firstName;
        R::store($employee);
    } 
    
    public static function switchEmployeeState(array $employeeData){
        if(!isset($employeeData['employee_id']) || trim($employeeData['employee_id']) == ''){
            throw new ControllerException('Bitte eine Id angeben.');
        }
 
        $id = $employeeData['employee_id'];
        
        $employee = R::findOne('employee', 'id = ?', [$id]);
        if(!$employee){
            throw new ControllerException("Kein Vereinsmitglied mit der id "+ $id + " gefunden.");
        }

        if ($employee['state']==='ACTIVE') {
            $employee['state'] = 'DEACTIVE';
        } else {
            $employee['state'] = 'ACTIVE';
        }
        R::store($employee);
    } 
}
