<?php

class EmployeeController extends BaseController {

	public function login() {
		if(Request::isMethod('post')) {

			$data = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			return (Auth::attempt($data)) ? Redirect::to('employee/index') : Redirect::to('login')->withErrors(['Email or password were incorrect.']);
		}

		return View::make('login');
	}


	public function logout() {
		Auth::logout();
		return View::make('login');
	}


	public function index()	{

		$accessLevel = Auth::user()->access_level;

		if($accessLevel == 'admin')
			$employees = Employee::where('is_active', '=', '1')->with('department', 'jobTitle')->get();
		else
			$employees = Employee::where('is_active', '=', '1')->where('department_id', '=', Auth::user()->department_id)->with('department', 'jobTitle')->get();

		$departments = Department::where('is_active', '=', '1')->get();
		$jobTitles = JobTitle::where('is_active', '=', '1')->get();

		return View::make('employee/employee', array(
			'employees' => $employees,
			'departments' => $departments,
			'jobTitles' => $jobTitles,
			'accessLevel' => $accessLevel
		));
	}


	public function postEmployee() {
		if(Input::has('id')) {
			$employee = Employee::find(Input::get('id'));
			$message = "Successfully updated employee.";
		} else {
			$employee = new Employee;
			$message = "Successfully created new employee.";
		}


		$employee->first_name = Input::get('first_name');
		$employee->last_name = Input::get('last_name');
		$employee->email = Input::get('email');
		$employee->skype_name = Input::get('skype_name');
		$employee->department_id = Input::get('department') == "" ? null : Input::get('department');
		$employee->job_title_id = Input::get('job_title') == "" ? null : Input::get('job_title');

		$employee->save();

		return Redirect::to('employee/')->with('postMessage', $message);
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
			
		}

		return View::make('employee/profile', array(
			'user' => $user,
			'departments' => Department::all(),
			'jobTitles' => JobTitle::all(),
			'accessLevel' => $user->access_level
		));
	}


	public function postProfile() {
		$user = Auth::user();

		if(Input::hasFile('photo')) {
			// Check if the file is a jpg or png
			if(strcasecmp(Input::file('photo')->getClientOriginalExtension(), 'jpg') === 0 || strcasecmp(Input::file('photo')->getClientOriginalExtension(), 'png') === 0) {
				Input::file('photo')->move(Config::get('global.profilePicturePath'), $user->id . "-profile.jpg");
				$user->profile_picture = Config::get('global.profilePictureURL') . "/" . $user->id . "-profile.jpg";
			} else {
				Redirect::to('employee/profile')->withErrors(['Only JPG and PNG files allowed.']);
			}
		}

		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->email = Input::get('email');
		$user->skype_name = Input::get('skype_name');
		$user->department_id = Input::get('department') == "" ? null : Input::get('department');
		$user->job_title_id = Input::get('job_title') == "" ? null : Input::get('job_title');

		$user->save();

		return Redirect::to('employee/profile')->with('postMessage', 'Successfully updated.');
	}



}
