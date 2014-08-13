<html>
	<head>
		<title>Systems in Motion - Organization Chart</title>
		{{ HTML::script('js/jquery.min.js') }}
		{{ HTML::script('js/jquery.uniform.min.js') }}
		{{ HTML::script('js/jquery-ui.min.js') }}
		{{ HTML::style('css/style.css') }}
		{{ HTML::style('css/pure-min.css'); }}
	</head>
    <body>
    	<div align="center">
    		{{ HTML::image('images/sim-logo.png', 'alt', array( 'width' => 200, 'height' => 70 )) }}
    		@if(Auth::check())
	    		<div id="navbar">
					<a href="{{url('department/index')}}">Departments</a>
					<a href="{{url('employee/index')}}">Employees</a>
					<a href="{{url('jobTitle/index')}}">Job Titles</a>
					<a href="{{action('EmployeeController@logout')}}">Logout</a>
				</div>
			@endif
	        @yield('content')
    	</div>
    </body>
</html>
