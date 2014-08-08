<?php

class DepartmentController extends BaseController {

	public function index()	{
		if(Request::isMethod('post')) {
			$department = Input::has('id') ? Department::find(Input::get('id')) : new Department;

			$department->parent_department = ( Input::get('parent_department') == "" ? null : Input::get('parent_department') );
			//$department->manager = Input::get('manager');
			$department->name = Input::get('name');
			$department->is_active = 1;

			$department->save();
		}

		return View::make('department/department', array(
			'departments' => Department::where('is_active', '=', '1')->get()
		));
	}

	public function removeDepartment() {
		$dept = Department::find(Input::get('id'));
		$dept->is_active = 0;

		echo $dept->save() ? "success" : "fail";
	}

}

?>