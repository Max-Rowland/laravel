<?php

class JobTitleController extends BaseController {

	public function index()	{
		if(Request::isMethod('post')) {
			$jobTitle = Input::has('id') ? JobTitle::find(Input::get('id')) : new JobTitle;

			$jobTitle->name = Input::get('name');
			$jobTitle->is_active = 1;

			$jobTitle->save();
		}

		return View::make('jobTitle/jobTitle', array(
			'jobTitles' => JobTitle::where('is_active', '=', '1')->get()
		));
	}
}

?>