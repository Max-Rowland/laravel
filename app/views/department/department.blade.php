@extends('layout')

@section('content')
<h2>Departments</h2>

<form id="newDepartment" action="index" method="post">
	<fieldset>
		<legend>New Department</legend>
		<input id="name" type="text" name="name">
		<select id="parentDept" name="parent_department">
			<option value=""></option>
			@foreach($departments as $dept)
				<option value="{{$dept->id}}">{{$dept->name}}</option>
			@endforeach
		</select>
		<input type="hidden" name="is_active" value="1">
		<button type="submit">Save</button>
	</fieldset>
</form>


<table>
	<thead>
		<th>Name</th><th>Parent</th><th>Edit</th><th>Delete</th>
	</thead>
	@foreach($departments as $dept)
		<tr>
			<td>{{$dept->name}}</td>
			<td>{{$dept->parent_department}}</td>
			<td><button>Edit</button></td>
			<td><button>Delete</button></td>
		</tr>
	@endforeach
</table>


@stop