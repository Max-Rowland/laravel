@extends('layout')

@section('content')
<h2>Your Profile</h2>

	@if(Session::get('postMessage') !== "")
		<h4>{{Session::get('postMessage')}}</h4>
	@endif

	<form id="addEmployee" action="postProfile" method="post" enctype="multipart/form-data" class="pure-form pure-form-aligned">
		<fieldset>
			<legend>Your Information</legend>

			<img src="{{$user->profile_picture}}" alt="picture" width="auto" height="300" />

			<br>

			<div class="pure-control-group">
				@if($user->profile_picture != null || $user->profile_picture != "")
					<label for="picUpload">Change your picture:</label>
				@else
					<label for="picUpload">Choose a picture:</label>
				@endif
				<input type="file" name="photo" id="picUpload" accept="image/*">
			</div>

			<input type="hidden" name="id" value="{{$user->id}}">

			<br>

			<div class="pure-control-group">
				<label for="newFirstNameInput">First Name</label>
				<input id="newFirstNameInput" type="text" name="first_name" value="{{$user->first_name}}" required />
			</div>

			<div class="pure-control-group">
				<label for="newLastNameInput">Last Name</label>
				<input id="newLastNameInput" type="text" name="last_name" value="{{$user->last_name}}" required />
			</div>

			<div class="pure-control-group">
				<label for="newEmailInput">Email</label>
				<input id="newEmailInput" type="text" name="email" value="{{$user->email}}" required />
			</div>

			<div class="pure-control-group">
				<label for="newSkypeNameInput">Skype Name</label>
				<input id="newSkypeNameInput" type="text" name="skype_name" value="{{$user->skype_name}}" required />
			</div>

			@if($accessLevel === 'admin')
				<div class="pure-control-group">
					<label for="newDepartmentInput">Department</label>
					<select id="newDepartmentInput" name="department" style="width: 200px;">
						<option value=""></option>
						@foreach($departments as $dept)
							<option value="{{$dept->id}}" @if($user->department->id == $dept->id) selected @endif>{{$dept->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="pure-control-group">
				<label for="newJobTitleInput">Job Title</label>
				<select id="newJobTitleInput" name="job_title" style="width: 200px;">
					<option value=""></option>
					@foreach($jobTitles as $job)
						<option value="{{$job->id}}" @if($user->jobTitle->id == $job->id) selected @endif>{{$job->name}}</option>
					@endforeach
				</select>
			</div>
			@else
				<input type="hidden" name="department" value="{{$user->department}}">

				<input type="hidden" name="job_title" value="{{$user->job_title}}">
			@endif
			

			<button type="submit" class="pure-button pure-button-primary">Save</button>
			<button type="reset" id="addCancel" class="pure-button">Cancel</button>
		</fieldset>
	</form>

@stop