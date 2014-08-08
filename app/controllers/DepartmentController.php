<?php

class DepartmentController extends BaseController {

	public function index()	{
		if(Request::isMethod('post')) {
			$department = null;

			if(Input::has('id'))
				$department = Department::find(Input::get('id'));
			else
				$department = new Department;

			$department->parent_department = Input::get('parent_department');
			//$department->manager = Input::get('manager');
			$department->name = Input::get('name');
			$department->is_active = 1;

			$department->save();
		}

		return View::make('department/department', array(
			'departments' => Department::where('is_active', '=', '1')->get()
		));
	}

}

?>