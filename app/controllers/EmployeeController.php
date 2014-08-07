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
			$employee->department = Input::get('department');
			$employee->job_title = Input::get('job_title');

			$employee->save();
		}

		return View::make('employee/employee', array(
			'employees' => Employee::all(),
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all()
		));
	}

	public function removeEmployee() {
		echo Input::get('id');
		exit;
	}

	public function test() {
		echo "test";
		exit;
	}



}
