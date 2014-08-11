<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Employee extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;


	protected $primaryKey = 'id';
	protected $table = 'employees';
	protected $hidden = array('password', 'remember_token');
	
	public $timestamps = false;


	public function getFullName() {
		return $this->last_name . ", " . $this->first_name;
	}

	public function getDepartment() {
		return Department::find($this->department);
	}

	public function getJobTitle() {
		return JobTitle::find($this->job_title);
	}
}

?>