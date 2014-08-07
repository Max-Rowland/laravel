@extends('layout')

@section('content')
	
	<form id="searchEmployees" action="search" method="post">
		<fieldset>
			<legend>Search Employees</legend>
			<input type="text" name="name" id="searchName">
			<select name="department" id="searchDepartment">
				<option value=""></option>
				@foreach($departments as $dept)
					<option value="{{$dept->id}}">{{$dept->name}}</option>
				@endforeach
			</select>
			<select name="jobTitle" id="searchJobTitle">
				<option value=""></option>
				@foreach($jobTitles as $job)
					<option value="{{$job->id}}">{{$job->name}}</option>
				@endforeach
			</select>

			<button type="submit">Search</button>
		</fieldset>
		

	</form>
	
	@if(sizeof($employees) > 0)
	<table>
		<thead>
			<th>Name</th><th>Email</th><th>Skype Name</th><th>Department</th><th>Job Title</th><th>Edit</th><th>Delete</th>
		</thead>
		@foreach($employees as $employee)
			<tr id="employeeRow{{$employee->id}}">
				<td>{{$employee->getFullName()}}</td>
				<td>{{$employee->email}}</td>
				<td>{{$employee->skype_name}}</td>
				<td>{{$employee->getDepartment()->name}}</td>
				<td>{{$employee->getJobTitle()->name}}</td>
				<td><button onclick="edit('{{$employee->id}}', '{{$employee->first_name}}', '{{$employee->last_name}}', '{{$employee->email}}', '{{$employee->skype_name}}', 
									'{{$employee->department}}', '{{$employee->job_title}}')">Edit</button>
				</td>
				<td><button onclick="deleteEmployee('{{$employee->id}}')">Delete</button></td>
			</tr>
		@endforeach
	</table>
	@endif

	<br><br>

	<form id="addEmployee" action="index" method="post">
		<fieldset>
			<legend>Add A New Employee</legend>

			<label for="newFirstNameInput">First Name</label>
			<input id="newFirstNameInput" type="text" name="first_name" />

			<label for="newLastNameInput">Last Name</label>
			<input id="newLastNameInput" type="text" name="last_name" />

			<label for="newEmailInput">Email</label>
			<input id="newEmailInput" type="text" name="email" />

			<label for="newSkypeNameInput">Skype Name</label>
			<input id="newSkypeNameInput" type="text" name="skype_name" />

			<label for="newDepartmentInput">Department</label>
			<select id="newDepartmentInput" name="department">
				<option value=""></option>
				@foreach($departments as $dept)
					<option value="{{$dept->id}}">{{$dept->name}}</option>
				@endforeach
			</select>

			<label for="newJobTitleInput">Job Title</label>
			<select id="newJobTitleInput" name="job_title">
				<option value=""></option>
				@foreach($jobTitles as $job)
				<option value="{{$job->id}}">{{$job->name}}</option>
				@endforeach
			</select>

			<button type="submit">Save</button>
		</fieldset>
		
	</form>

	<form id="editEmployee" action="index" method="post" style="display:none;">
		<fieldset>
			<legend>Edit Employee</legend>

			<input id="editId" type="hidden" name="id" value="">

			<label for="editFirstNameInput">First Name</label>
			<input id="editFirstNameInput" type="text" name="first_name" />

			<label for="editLastNameInput">Last Name</label>
			<input id="editLastNameInput" type="text" name="last_name" />

			<label for="editEmailInput">Email</label>
			<input id="editEmailInput" type="text" name="email" />

			<label for="editSkypeNameInput">Skype Name</label>
			<input id="editSkypeNameInput" type="text" name="skype_name" />

			<label for="editDepartmentInput">Department</label>
			<select id="editDepartmentInput" name="department">
				<option value=""></option>
				@foreach($departments as $dept)
				<option value="{{$dept->id}}">{{$dept->name}}</option>
				@endforeach
			</select>

			<label for="editJobTitleInput">Job Title</label>
			<select id="editJobTitleInput" name="job_title">
				<option value=""></option>
				@foreach($jobTitles as $job)
				<option value="{{$job->id}}">{{$job->name}}</option>
				@endforeach
			</select>

			<button type="submit">Save</button>
			<button id="editCancel" type="reset">Cancel</button>
		</fieldset>
		
	</form>



	<script type="text/javascript">

		$("#editCancel").click(function() { 
			$("#editEmployee").toggle(); 
		});

		function edit(id, firstName, lastName, email, skypeName, department, jobTitle) {
			$("#editEmployee").toggle();
			$("#editId").val(id);
			$("#editFirstNameInput").val(firstName);
			$("#editLastNameInput").val(lastName);
			$("#editEmailInput").val(email);
			$("#editSkypeNameInput").val(skypeName);
			$("#editDepartmentInput").val(department);
			$("#editJobTitleInput").val(jobTitle);
		}


		function deleteEmployee(id) {
			if(confirm("You sure you want to delete the employee?") == true) {
				$.ajax({
					type: "POST",
					url: "removeEmployee",
					data: {id : id},
					dataType: "text",
					success: function(data) {
						if(data == "success")
							$("#employeeRow" + id).remove();
					}
				});
			}
		}

	</script>

@stop