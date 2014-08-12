@extends('layout')

@section('content')
	<h2>Job Titles</h2>

	@if(Auth::user()->access_level === 'admin')
		<form id="newJobTitle" action="index" method="post" class="pure-form pure-form-aligned">
			<fieldset>
				<legend>Add Job Title</legend>

				<div class="pure-control-group">
					<label for="addName">Name</label>
					<input type="text" name="name" id="addName">
				</div>

				<button type="submit" class="pure-button pure-button-primary">Save</button>
				<button type="reset" class="pure-button">Cancel</button>
			</fieldset>
		</form>
	@endif


	<table class="pure-table pure-table-horizontal">
		<thead>
			<th>Name</th>
			@if(Auth::user()->access_level === 'admin')
				<th>Edit</th>
				<th>Delete</th>
			@endif
		</thead>
		@foreach($jobTitles as $job)
			<tr id="jobRow{{$job->id}}">
				<td>{{$job->name}}</td>
				@if(Auth::user()->access_level === 'admin')
					<td><button onclick="editJob('{{$job->id}}', '{{$job->name}}')" class="pure-button">Edit</button></td>
					<td><button onclick="deleteJob('{{$job->id}}')" class="pure-button">Delete</button></td>
				@endif
			</tr>
		@endforeach
	</table>

	@if(Auth::user()->access_level === 'admin')
		<form id="editJobTitle" action="index" method="post" style="display: none;" class="pure-form pure-form-aligned">
			<fieldset>
				<legend>Edit Job Title</legend>
				<input type="hidden" name="id" id="editId">

				<div class="pure-control-group">
					<label for="editName">Name</label>
					<input type="text" name="name" id="editName">
				</div>

				<button type="submit" class="pure-button pure-button-primary">Save</button>
				<button type="reset" id="cancelBtn" class="pure-button">Cancel</button>
			</fieldset>
		</form>
	@endif


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