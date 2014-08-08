<?php

class EmployeeController extends BaseController {

	public function index()	{
		if(Request::isMethod('post')) {

			$employee = null;

			if(Input::has('id'))
				$employee = Employee::find(Input::get('id'));
			else
				$employee = new Employee;

			$employee->first_name = Input::get('first_name');
			$employee->last_name = Input::get('last_name');
			$employee->email = Input::get('email');
			$employee->skype_name = Input::get('skype_name');
			$employee->department = Input::get('department') == "" ? null : Input::get('department');
			$employee->job_title = Input::get('job_title') == "" ? null : Input::get('job_title');

			$employee->save();
		}


		return View::make('employee/employee', array(
			'employees' => Employee::where('is_active', '=', '1')->get(),
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all()
		));
	}


	public function removeEmployee() {
		$employee = Employee::find(Input::get('id'));
		$employee->is_active = 0;

		echo $employee->save() ? "success" : "fail";
	}


	public function searchEmployees() {
		$nameCriteria = Input::get('name');
		$departmentCritera = Input::get('department');
		$jobTitleCriteria = Input::get('jobTitle');

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

		if($departmentCritera !== "")
			$employees = $employees->where('department', '=', $departmentCritera);

		if($jobTitleCriteria !== "")
			$employees = $employees->where('job_title', '=', $jobTitleCriteria);

		$employees = $employees->where('is_active', '=', 1);

		$employees = $employees->get();

		return View::make('employee/employee', array(
			'employees' => $employees,
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all()
		));
	}


	public function autocomplete($name) {
		$nameArr = explode(" ", $name);
		$retval = "";

		$employees = new Employee;

		if(sizeof($nameArr) == 1) {
			$employees = $employees->where('first_name', 'LIKE', '%' . $nameArr[0] . '%');
			$employees = $employees->orWhere('last_name', 'LIKE', '%' . $nameArr[0] . '%');
		}
		elseif(sizeof($nameArr) == 2) {
			$employees = $employees->where('first_name', 'LIKE', '%' . $nameArr[0] . '%');
			$employees = $employees->where('last_name', 'LIKE', '%' . $nameArr[1] . '%');
		}

		$employees = $employees->where('is_active', '=', 1);

		$employees = $employees->get();

		foreach($employees as $employee) {
			$retval .= $employee->first_name . " " . $employee->last_name .  ",";
		}

		echo $retval;
		exit;
	}



}
