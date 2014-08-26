<?php

class EmployeeController extends BaseController {


	public function login() {
		if(Request::isMethod('post')) {

			$data = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			return (Auth::attempt($data)) ? Redirect::to('employee/index') : Redirect::to('login');
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

		$employees = ($accessLevel === 'admin') ? $employees->get() : $employees->where('department', '=', Auth::user()->getDepartment()->id)->get();

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


		print_r($_POST);
		exit;
		$employee = Employee::find(Input::get('id'));
		$employee->is_active = 0;

		echo $employee->save() ? "success" : "fail";
	}


	public function searchEmployees() {
		$accessLevel = Auth::user()->access_level;
		$nameCriteria = Input::get('name');
		$departmentCritera = Input::get('department');
		$jobTitleCriteria = Input::get('jobTitle');

		$employees = Employee::getEmployeesBySearchCriteria($accessLevel, $nameCriteria, $departmentCritera, $jobTitleCriteria);

		return View::make('employee/employee', array(
			'employees' => $employees,
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all(),
			'accessLevel' => $accessLevel
		));
	}


	public function autocomplete($name) {
		$accessLevel = Auth::user()->access_level;
		$retval = "";

		$results = Employee::getAutocompleteResults($accessLevel, $name);

		foreach($results as $result)
			$retval .= $result->first_name . " " . $result->last_name . ",";

		echo $retval;
		exit;
	}


	public function profile() {
		$user = Auth::user();

		if(Request::isMethod('post')) {
			if(Input::hasFile('photo')) {
				if(strcasecmp(Input::file('photo')->getClientOriginalExtension(), 'jpg') || strcasecmp(Input::file('photo')->getClientOriginalExtension(), 'png')) {
					Input::file('photo')->move(Config::get('global.profilePicturePath'), $user->id . "-profile.jpg");
					$user->profile_picture = Config::get('global.profilePictureURL') . "/" . $user->id . "-profile.jpg";
				} else {
					echo "Only .jpg and .png allowed (do better verification later).";
					exit;
				}
			}

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
