@extends('layout')

@section('content')
	<h2>Departments</h2>

	<form id="newDepartment" action="index" method="post" class="pure-form pure-form-aligned">
		<fieldset>
			<legend>New Department</legend>

			<div class="pure-control-group">
				<label for="addName">Name</label>
				<input id="name" type="text" name="name">
			</div>

			<div class="pure-control-group">
				<label for="addParentDept">Parent Department</label>
				<select id="parentDept" name="parent_department" style="width: 200px;">
					<option value=""></option>
					@foreach($departments as $dept)
						<option value="{{$dept->id}}">{{$dept->name}}</option>
					@endforeach
				</select>
			</div>

			<input type="hidden" name="is_active" value="1">
			<button type="submit" class="pure-button pure-button-primary">Save</button>
			<button type="reset" class="pure-button">Reset</button>
		</fieldset>
	</form>


	<table class="pure-table pure-table-horizontal">
		<thead>
			<th>Name</th><th>Parent</th><th>Edit</th><th>Delete</th>
		</thead>
		@foreach($departments as $dept)
			<tr id="departmentRow{{$dept->id}}">
				<td>{{$dept->name}}</td>
				<td>{{ $dept->getParentDepartment() == null ? "" : $dept->getParentDepartment()->name }}</td>
				<td><button onclick="editDept('{{$dept->id}}', '{{$dept->name}}', '{{$dept->parent_department}}')" class="pure-button">Edit</button></td>
				<td><button onclick="deleteDept('{{$dept->id}}')" class="pure-button">Delete</button></td>
			</tr>
		@endforeach
	</table>


	<form id="editDepartment" action="index" method="post" class="pure-form pure-form-aligned" style="display: none;">
		<fieldset>
			<legend>Edit Department</legend>

			<input type="hidden" name="id" id="editId">

			<div class="pure-control-group">
				<label for="editName">Name</label>
				<input type="text" name="name" id="editName">
			</div>

			<div class="pure-control-group">
				<label for="editParentDetp">Parent Department</label>
				<select id="editParentDept" name="parent_department" style="width: 200px;">
					<option value=""></option>
					@foreach($departments as $dept)
						<option value="{{$dept->id}}">{{$dept->name}}</option>
					@endforeach
				</select>
			</div>

			<button type="submit" class="pure-button pure-button-primary">Save</button>
			<button type="resest" id="cancelEdit" class="pure-button">Cancel</button>
		</fieldset>
	</form>


	<script type="text/javascript">

		function editDept(id, name, parent) {
			$("#editDepartment").toggle();
			$("#editId").val(id);
			$("#editName").val(name);
			$("#editParentDept").val(parent);
		}

		function deleteDept(id) {
			if(confirm("You sure you want to delete the department?") == true) {
				$.ajax({
					type: "POST",
					url: "removeDepartment",
					data: {id : id},
					dataType: "text",
					success: function(data) {
						if(data == "success")
							$("#departmentRow" + id).remove();
					}
				});
			}
		}

		$("#cancelEdit").click(function() {
			$("#editDepartment").toggle();
		});

	</script>
@stop