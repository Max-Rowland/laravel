@extends('layout')

@section('content')

	<br>
	
	{{ Form::open(array('url' => 'login', 'class' => 'pure-form pure-form-aligned')) }}
		<div class="pure-control-group">
			<label for="email">Username</label>
			<input type="text" name="email" id="email">
		</div>

		<div class="pure-control-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password">
		</div>
		
		<button type="submit" class="pure-button pure-button-primary">Login</button>
	{{ Form::close() }}
@stop