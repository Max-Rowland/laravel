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

Route::get('/', function() {
	return View::make('hello');
});


//*********** EMPLOYEE ROUTES ***********
Route::any('employee/index', 'EmployeeController@index');

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