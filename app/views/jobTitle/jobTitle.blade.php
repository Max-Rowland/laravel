@extends('layout')

@section('content')
	<h2>Job Titles</h2>

	<form id="newJobTitle" action="index" method="post">
		<fieldset>
			<legend>Add Job Title</legend>
			<label for="addName">Name</label>
			<input type="text" name="name" id="addName">
			<button type="submit">Save</button>
			<button type="reset">Cancel</button>
		</fieldset>
	</form>


	<table>
		<thead>
			<th>Name</th><th>Edit</th><th>Delete</th>
		</thead>
		@foreach($jobTitles as $job)
			<tr id="jobRow{{$job->id}}">
				<td>{{$job->name}}</td>
				<td><button onclick="editJob('{{$job->id}}', '{{$job->name}}')">Edit</button></td>
				<td><button onclick="deleteJob('{{$job->id}}')">Delete</button></td>
			</tr>
		@endforeach
	</table>


	<form id="editJobTitle" action="index" method="post" style="display: none;">
		<fieldset>
			<legend>Edit Job Title</legend>
			<input type="hidden" name="id" id="editId">
			<label for="editName">Name</label>
			<input type="text" name="name" id="editName">
			<button type="submit">Save</button>
			<button type="reset" id="cancelBtn">Cancel</button>
		</fieldset>
	</form>


	<script type="text/javascript">
		function editJob(id, name) {
			$("#editJobTitle").toggle();
			$("#editId").val(id);
			$("#editName").val(name);
		}

		function deleteJob(id) {
			if(confirm("You sure you want to delete the department?") == true) {
				$.ajax({
					type: "POST",
					url: "removeJobTitle",
					data: {id : id},
					dataType: "text",
					success: function(data) {
						if(data == "success")
							$("#jobRow" + id).remove();
					}
				});
			}
		}

		$("#cancelBtn").click(function() {
			$("#editJobTitle").toggle();
		});

	</script>
@stop