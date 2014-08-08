<?php

class Department extends Eloquent {
	protected $primaryKey = 'id';
	protected $table = 'departments';
	public $timestamps = false;

	public function getParentDepartment() {
		return ($this->parent_department !== null) ? Department::find($this->parent_department) : null;
	}
}

?>