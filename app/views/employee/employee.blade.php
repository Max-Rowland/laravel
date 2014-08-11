@extends('layout')

@section('content')
	<h2>Employees</h2>
	
	<form id="searchEmployees" action="search" method="post" class="pure-form pure-form-aligned">
		<fieldset>
			<legend>Search Employees</legend>

			<div class="pure-control-group">
				<label for="searchName">Name</label>
				<input type="text" name="name" id="searchName">
			</div>

			<div class="pure-control-group">
				<label for="searchDepartment">Department</label>
				<select name="department" id="searchDepartment" style="width: 200px;">
					<option value=""></option>
					@foreach($departments as $dept)
						<option value="{{$dept->id}}">{{$dept->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="pure-control-group">
				<label for="searchJobTitle">Job Title</label>
				<select name="jobTitle" id="searchJobTitle" style="width: 200px;">
					<option value=""></option>
					@foreach($jobTitles as $job)
						<option value="{{$job->id}}">{{$job->name}}</option>
					@endforeach
				</select>
			</div>

			<button type="submit" class="pure-button pure-button-primary">Search</button>
		</fieldset>
		

	</form>

	<br><br>

	@if(sizeof($employees) > 0)
	<table class="pure-table pure-table-horizontal">
		<thead>
			<th>Name</th><th>Email</th><th>Skype Name</th><th>Department</th><th>Job Title</th><th>Edit</th><th>Delete</th>
		</thead>
		@foreach($employees as $employee)
			<tr id="employeeRow{{$employee->id}}">
				<td>{{$employee->getFullName()}}</td>
				<td>{{$employee->email}}</td>
				<td>{{$employee->skype_name}}</td>
				<td>{{ $employee->getDepartment() == null ? "" : $employee->getDepartment()->name }}</td>
				<td>{{ $employee->getJobTitle() == null ? "" : $employee->getJobTitle()->name}}</td>
				<td><button onclick="edit('{{$employee->id}}', '{{$employee->first_name}}', '{{$employee->last_name}}', '{{$employee->email}}', '{{$employee->skype_name}}', 
									'{{$employee->department}}', '{{$employee->job_title}}')" class="pure-button">Edit</button>
				</td>
				<td><button onclick="deleteEmployee('{{$employee->id}}')" class="pure-button">Delete</button></td>
			</tr>
		@endforeach
	</table>
	@endif


	<br><br>


	<form id="addEmployee" action="index" method="post" class="pure-form pure-form-aligned">
		<fieldset>
			<legend>Add A New Employee</legend>

			<div class="pure-control-group">
				<label for="newFirstNameInput">First Name</label>
				<input id="newFirstNameInput" type="text" name="first_name" />
			</div>

			<div class="pure-control-group">
				<label for="newLastNameInput">Last Name</label>
				<input id="newLastNameInput" type="text" name="last_name" />
			</div>

			<div class="pure-control-group">
				<label for="newEmailInput">Email</label>
				<input id="newEmailInput" type="text" name="email" />
			</div>

			<div class="pure-control-group">
				<label for="newSkypeNameInput">Skype Name</label>
				<input id="newSkypeNameInput" type="text" name="skype_name" />
			</div>

			<div class="pure-control-group">
				<label for="newDepartmentInput">Department</label>
				<select id="newDepartmentInput" name="department" style="width: 200px;">
					<option value=""></option>
					@foreach($departments as $dept)
						<option value="{{$dept->id}}">{{$dept->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="pure-control-group">
				<label for="newJobTitleInput">Job Title</label>
				<select id="newJobTitleInput" name="job_title" style="width: 200px;">
					<option value=""></option>
					@foreach($jobTitles as $job)
					<option value="{{$job->id}}">{{$job->name}}</option>
					@endforeach
				</select>
			</div>

			<button type="submit" class="pure-button pure-button-primary">Save</button>
		</fieldset>
		
	</form>


	<form id="editEmployee" action="index" method="post" style="display:none;" class="pure-form pure-form-aligned">
		<fieldset>
			<legend>Edit Employee</legend>

			<input id="editId" type="hidden" name="id" value="">

			<div class="pure-control-group">
				<label for="editFirstNameInput">First Name</label>
				<input id="editFirstNameInput" type="text" name="first_name" />
			</div>

			<div class="pure-control-group">
				<label for="editLastNameInput">Last Name</label>
				<input id="editLastNameInput" type="text" name="last_name" />
			</div>

			<div class="pure-control-group">
				<label for="editEmailInput">Email</label>
				<input id="editEmailInput" type="text" name="email" />
			</div>

			<div class="pure-control-group">
				<label for="editSkypeNameInput">Skype Name</label>
				<input id="editSkypeNameInput" type="text" name="skype_name" />
			</div>

			<div class="pure-control-group">
				<label for="editDepartmentInput">Department</label>
				<select id="editDepartmentInput" name="department" style="width: 200px;">
					<option value=""></option>
					@foreach($departments as $dept)
					<option value="{{$dept->id}}">{{$dept->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="pure-control-group">
				<label for="editJobTitleInput">Job Title</label>
				<select id="editJobTitleInput" name="job_title" style="width: 200px;">
					<option value=""></option>
					@foreach($jobTitles as $job)
					<option value="{{$job->id}}">{{$job->name}}</option>
					@endforeach
				</select>
			</div>

			<button type="submit" class="pure-button pure-button-primary">Save</button>
			<button id="editCancel" type="reset" class="pure-button">Cancel</button>
		</fieldset>
		
	</form>


	<script type="text/javascript">

		$("#editCancel").click(function() { 
			$("#editEmployee").toggle(); 
		});

		$("input#searchName").autocomplete({
			source: function(request, response) {
				$.ajax({
					type: "GET",
					url: "autocomplete/" + $('#searchName').val(),
					dataType: "text",
					success: function(data) {
						var suggestions = data.split(",");
						console.log(suggestions);
						suggestions.pop();  // remove the empty element at the end
						response(suggestions);
					}
				});
			}
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