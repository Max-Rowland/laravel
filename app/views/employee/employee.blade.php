@extends('layout')

@section('content')
	<h2>Employees</h2>

	@if(Session::get('postMessage') !== "")
		<p><b>{{Session::get('postMessage')}}</b></p>
	@endif
	
	<form id="searchEmployees" action="employee/search" method="post" class="pure-form pure-form-aligned">
		<fieldset>
			<legend>Search Employees</legend>

			<div class="pure-control-group">
				<label for="searchName">Name</label>
				<input type="text" name="name" id="searchName">
			</div>

			@if($accessLevel === 'admin')
				<div class="pure-control-group">
					<label for="searchDepartment">Department</label>
					<select name="department" id="searchDepartment" style="width: 200px;">
						<option value=""></option>
						@foreach($departments as $dept)
							<option value="{{$dept->id}}">{{$dept->name}}</option>
						@endforeach
					</select>
				</div>
			@endif

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

	<br>

	@if($accessLevel === 'admin' || $accessLevel === 'manager')
		<button id="showAddForm" class="pure-button pure-button-primary">Add Employee</button>
	@endif
	<br>

	@if(sizeof($employees) > 0)
		<table class="pure-table pure-table-horizontal">
			<thead>
				<th>Name</th>
				<th>Email</th>
				<th>Skype Name</th>
				<th>Department</th>
				<th>Job Title</th>
				@if($accessLevel === 'admin' || $accessLevel === 'manager')
					<th>Edit</th>
				@endif
				@if($accessLevel === 'admin')
					<th>Delete</th>
				@endif
			</thead>
			@foreach($employees as $employee)
				<tr id="employeeRow{{$employee->id}}">
					<td>{{$employee->getFullName()}}</td>
					<td>{{$employee->email}}</td>
					<td>{{$employee->skype_name}}</td>
					<td>{{ $employee->department == null ? "" : $employee->department->name }}</td>
					<td>{{ $employee->jobTitle == null ? "" : $employee->jobTitle->name}}</td>
					@if($accessLevel === 'admin' || $accessLevel === 'manager')
						<td><button onclick="edit('{{$employee->id}}', '{{$employee->first_name}}', '{{$employee->last_name}}', '{{$employee->email}}', '{{$employee->skype_name}}', 
											'{{$employee->department->id}}', '{{$employee->jobTitle->id}}')" class="pure-button">Edit</button>
						</td>
					@endif
					@if($accessLevel === 'admin')
						<td><button onclick="deleteEmployee('{{$employee->id}}')" class="pure-button">Delete</button></td>
					@endif
				</tr>
			@endforeach
		</table>
	@endif


	<br><br>

	@if($accessLevel === 'admin' || $accessLevel === 'manager')
		<form id="addEmployee" action="employee/postEmployee" method="post" class="pure-form pure-form-aligned" style="display: none;">
			<fieldset>
				<legend>Add A New Employee</legend>

				<div class="pure-control-group">
					<label for="newFirstNameInput">First Name</label>
					<input id="newFirstNameInput" type="text" name="first_name" required />
				</div>

				<div class="pure-control-group">
					<label for="newLastNameInput">Last Name</label>
					<input id="newLastNameInput" type="text" name="last_name" required />
				</div>

				<div class="pure-control-group">
					<label for="newEmailInput">Email</label>
					<input id="newEmailInput" type="text" name="email" required />
				</div>

				<div class="pure-control-group">
					<label for="newSkypeNameInput">Skype Name</label>
					<input id="newSkypeNameInput" type="text" name="skype_name" required />
				</div>

				@if($accessLevel === 'admin')
					<div class="pure-control-group">
						<label for="newDepartmentInput">Department</label>
						<select id="newDepartmentInput" name="department" style="width: 200px;">
							<option value=""></option>
							@foreach($departments as $dept)
								<option value="{{$dept->id}}">{{$dept->name}}</option>
							@endforeach
						</select>
					</div>
				@else
					<input type="hidden" name="department" value="{{Auth::user()->department}}">
				@endif

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
				<button type="reset" id="addCancel" class="pure-button">Cancel</button>
			</fieldset>
		</form>


		<form id="editEmployee" action="employee/postEmployee" method="post" style="display:none;" class="pure-form pure-form-aligned">
			<fieldset>
				<legend>Edit Employee</legend>

				<input id="editId" type="hidden" name="id" value="">

				<div class="pure-control-group">
					<label for="editFirstNameInput">First Name</label>
					<input id="editFirstNameInput" type="text" name="first_name" required />
				</div>

				<div class="pure-control-group">
					<label for="editLastNameInput">Last Name</label>
					<input id="editLastNameInput" type="text" name="last_name" required />
				</div>

				<div class="pure-control-group">
					<label for="editEmailInput">Email</label>
					<input id="editEmailInput" type="text" name="email" required />
				</div>

				<div class="pure-control-group">
					<label for="editSkypeNameInput">Skype Name</label>
					<input id="editSkypeNameInput" type="text" name="skype_name" required />
				</div>

				@if($accessLevel === 'admin')
					<div class="pure-control-group">
						<label for="editDepartmentInput">Department</label>
						<select id="editDepartmentInput" name="department" style="width: 200px;">
							<option value=""></option>
							@foreach($departments as $dept)
								<option value="{{$dept->id}}">{{$dept->name}}</option>
							@endforeach
						</select>
					</div>
				@else
					<input type="hidden" name="department" value="{{Auth::user()->department}}">
				@endif

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
	@endif


	<script type="text/javascript">

		var queries = {{ json_encode(DB::getQueryLog()) }};
	    console.log('/****************************** Database Queries ******************************/');
	    console.log(' ');
	    $.each(queries, function(id, query) {
	        console.log('   ' + query.time + ' | ' + query.query + ' | ' + query.bindings[0]);
	    });
	    console.log(' ');
	    console.log('/****************************** End Queries ***********************************/');

		$("#showAddForm").click(function() {
			$("#addEmployee").toggle();
			$("#showAddForm").toggle();
			$("#newFirstNameInput").focus();
		});

		$("#editCancel").click(function() { 
			$("#editEmployee").toggle(); 
		});

		$("#addCancel").click(function() { 
			$("#addEmployee").toggle();
			$("#showAddForm").toggle();
		});

		$("#addEmployee").submit(function() {
			if($("#newDepartmentInput").val() == "" || $("#newJobTitleInput").val() == "") {
				alert("Department and job title are required fields.");
				return false;
			}
		});

		$("#editEmployee").submit(function() {
			if($("#editDepartmentInput").val() == "" || $("#editJobTitleInput").val() == "") {
				alert("Department and job title are required fields.");
				return false;
			}
		});

		$("input#searchName").autocomplete({
			source: function(request, response) {
				$.ajax({
					type: "GET",
					url: "employee/autocomplete/" + $('#searchName').val(),
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
			$("#editFirstNameInput").focus();
		}


		function deleteEmployee(id) {
			if(confirm("You sure you want to delete the employee?") == true) {
				$.ajax({
					type: "POST",
					url: "removeEmployee",
					data: {id : id},
					dataType: "text",
					contentType: 'application/json',
					success: function(data) {
						// if(data == "success")
						// 	$("#employeeRow" + id).remove();
					}
				});
			}
		}

	</script>
@stop