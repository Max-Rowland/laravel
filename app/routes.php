<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::any('login', array(
	'uses' => 'EmployeeController@login'
));

Route::any('logout', array(
	'uses' => 'EmployeeController@logout'
));


Route::group(array('before' => 'auth'), function() {
	//route to always go to employee by default
	Route::any('/', 'EmployeeController@index');

	//*********** EMPLOYEE ROUTES ***********
	Route::any('employee/index', 'EmployeeController@index');

	Route::any('employee/profile', 'EmployeeController@profile');

	Route::post('employee/search', array(
		'uses' => 'EmployeeController@searchEmployees'
	));

	Route::post( 'employee/removeEmployee', array(
	    'uses' => 'EmployeeController@removeEmployee'
	));

	Route::get('employee/autocomplete/{name}', array(
	    'uses' => 'EmployeeController@autocomplete'
	));
	//***************************************


	//*********** DEPARTMENT ROUTES ***********
	Route::any('department/index', 'DepartmentController@index');

	Route::post( 'department/removeDepartment', array(
	    'uses' => 'DepartmentController@removeDepartment'
	));
	//*****************************************


	//*********** JOB TITLE ROUTES ***********
	Route::any('jobTitle/index', 'JobTitleController@index');

	Route::post( 'jobTitle/removeJobTitle', array(
	    'uses' => 'JobTitleController@removeJobTitle'
	));
	//****************************************
});

