<?php

class Employee extends Eloquent {
	protected $primaryKey = 'id';
	protected $table = 'employees';
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