<?php

class EmployeeController extends BaseController {


	public function login() {
		if(Request::isMethod('post')) {

			$data = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			if(Auth::attempt($data))
				return Redirect::to('employee/index');
			else
				return Redirect::to('login');
		}

		return View::make('login');
	}


	public function logout() {
		Auth::logout();
		return View::make('login');
	}


	public function index()	{
		$accessLevel = Auth::user()->access_level;

		if(Request::isMethod('post')) {
			$employee = Input::has('id') ? Employee::find(Input::get('id')) : new Employee;

			$employee->first_name = Input::get('first_name');
			$employee->last_name = Input::get('last_name');
			$employee->email = Input::get('email');
			$employee->skype_name = Input::get('skype_name');
			$employee->department = Input::get('department') == "" ? null : Input::get('department');
			$employee->job_title = Input::get('job_title') == "" ? null : Input::get('job_title');

			$employee->save();
		}

		$employees = Employee::where('is_active', '=', '1');

		if($accessLevel === 'admin')
			$employees = $employees->get();
		else
			$employees = $employees->where('department', '=', Auth::user()->getDepartment()->id)->get();

		$departments = Department::where('is_active', '=', '1')->get();
		$jobTitles = JobTitle::where('is_active', '=', '1')->get();

		return View::make('employee/employee', array(
			'employees' => $employees,
			'departments' => $departments,
			'jobTitles' => $jobTitles,
			'accessLevel' => $accessLevel
		));
	}


	public function removeEmployee() {
		$employee = Employee::find(Input::get('id'));
		$employee->is_active = 0;

		echo $employee->save() ? "success" : "fail";
	}


	public function searchEmployees() {
		$accessLevel = Auth::user()->access_level;
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

		if($jobTitleCriteria !== "")
				$employees = $employees->where('job_title', '=', $jobTitleCriteria);

		// can only see employees from all departments if you're an admin
		if($accessLevel === 'admin') {
			if($departmentCritera !== "")
				$employees = $employees->where('department', '=', $departmentCritera);
		} else {
			$employees = $employees->where('department', '=', Auth::user()->getDepartment()->id);
		}

		$employees = $employees->where('is_active', '=', 1);

		$employees = $employees->get();

		return View::make('employee/employee', array(
			'employees' => $employees,
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all()
		));
	}


	public function autocomplete($name) {
		$accessLevel = Auth::user()->access_level;
		$nameArr = explode(" ", $name);
		$retval = "";

		$query = "SELECT first_name, last_name FROM employees WHERE ";

		if(sizeof($nameArr) == 1)
			$query .= "(first_name LIKE '%" . $nameArr[0] . "%' OR last_name LIKE '%" . $nameArr[0] . "%') ";
		elseif(sizeof($nameArr) == 2)
			$query .= "first_name LIKE '%" . $nameArr[0] . "%' AND last_name LIKE '%" . $nameArr[1] . "%' ";

		if($accessLevel !== 'admin')
			$query .= "AND department = '" . Auth::user()->getDepartment()->id . "' ";
			
		$query .= "AND is_active = '1' ";

		$results = DB::select($query);

		foreach($results as $result)
			$retval .= $result->first_name . " " . $result->last_name . ",";

		echo $retval;
		exit;
	}


	public function profile() {
		$user = Auth::user();

		if(Request::isMethod('post')) {
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
			$user->skype_name = Input::get('skype_name');
			$user->department = Input::get('department') == "" ? null : Input::get('department');
			$user->job_title = Input::get('job_title') == "" ? null : Input::get('job_title');

			$user->save();
		}

		return View::make('employee/profile', array(
			'user' => $user,
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all(),
			'accessLevel' => $user->access_level
		));
	}



}
