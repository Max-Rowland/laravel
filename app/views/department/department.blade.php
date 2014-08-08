@extends('layout')

@section('content')
	<h2>Departments</h2>

	<form id="newDepartment" action="index" method="post">
		<fieldset>
			<legend>New Department</legend>
			<label for="addName">Name</label>
			<input id="name" type="text" name="name">
			<label for="addParentDept">Parent Department</label>
			<select id="parentDept" name="parent_department">
				<option value=""></option>
				@foreach($departments as $dept)
					<option value="{{$dept->id}}">{{$dept->name}}</option>
				@endforeach
			</select>
			<input type="hidden" name="is_active" value="1">
			<button type="submit">Save</button>
			<button type="reset">Reset</button>
		</fieldset>
	</form>


	<table>
		<thead>
			<th>Name</th><th>Parent</th><th>Edit</th><th>Delete</th>
		</thead>
		@foreach($departments as $dept)
			<tr id="departmentRow{{$dept->id}}">
				<td>{{$dept->name}}</td>
				<td>{{ $dept->getParentDepartment() == null ? "" : $dept->getParentDepartment()->name }}</td>
				<td><button onclick="editDept('{{$dept->id}}', '{{$dept->name}}', '{{$dept->parent_department}}')">Edit</button></td>
				<td><button onclick="deleteDept('{{$dept->id}}')">Delete</button></td>
			</tr>
		@endforeach
	</table>


	<form id="editDepartment" action="index" method="post" style="display: none;">
		<fieldset>
			<legend>Edit Department</legend>
			<input type="hidden" name="id" id="editId">
			<label for="editName">Name</label>
			<input type="text" name="name" id="editName">
			<label for="editParentDetp">Parent Department</label>
			<select id="editParentDept" name="parent_department">
				<option value=""></option>
				@foreach($departments as $dept)
					<option value="{{$dept->id}}">{{$dept->name}}</option>
				@endforeach
			</select>
			<button type="submit">Save</button>
			<button type="resest" id="cancelEdit">Cancel</button>
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