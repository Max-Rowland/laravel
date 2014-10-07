<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Employee extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $primaryKey = 'id';
	protected $table = 'employees';
	protected $hidden = array('password', 'remember_token');
	public $timestamps = false;


	public function department() {
		return $this->hasOne('Department', 'id', 'department_id');
	}


	public function jobTitle() {
		return $this->hasOne('JobTitle', 'id', 'job_title_id');
	}


	public function getFullName() {
		return $this->last_name . ", " . $this->first_name;
	}


	public static function getEmployeesBySearchCriteria($accessLevel, $nameCriteria = null, $departmentCritera = null, $jobTitleCriteria = null) {
		$employees = new Employee;

		if($nameCriteria !== "") {
			$nameArr = explode(" ", $nameCriteria);
			if(sizeof($nameArr) == 1) {
				$employees = $employees->where('first_name', '=', $nameArr[0]);
			}
			elseif(sizeof($nameArr) == 2) {
				$employees = $employees->where('first_name', '=', $nameArr[0]);
				$employees = $employees->where('last_name', '=', $nameArr[1]);
			}
		}

		if($jobTitleCriteria !== "")
			$employees = $employees->where('job_title_id', '=', $jobTitleCriteria);

		// can only see employees from all departments if you're an admin
		if($accessLevel === 'admin') {
			if($departmentCritera !== "")
				$employees = $employees->where('department_id', '=', $departmentCritera);
		} else {
			$employees = $employees->where('department_id', '=', Auth::user()->department->id);
		}

		$employees = $employees->where('is_active', '=', 1);

		$employees = $employees->get();

		return $employees;
	}


	public static function getAutocompleteResults($accessLevel, $name) {
		$nameArr = explode(" ", $name);

		$query = "SELECT first_name, last_name FROM employees WHERE ";

		if(sizeof($nameArr) == 1)
			$query .= "(first_name LIKE '%" . $nameArr[0] . "%' OR last_name LIKE '%" . $nameArr[0] . "%') ";
		elseif(sizeof($nameArr) == 2)
			$query .= "first_name LIKE '%" . $nameArr[0] . "%' AND last_name LIKE '%" . $nameArr[1] . "%' ";

		if($accessLevel !== 'admin')
			$query .= "AND department = '" . Auth::user()->getDepartment()->id . "' ";
			
		$query .= "AND is_active = '1' ";

		$results = DB::select($query);

		return $results;
	}
}

?>