<html>
	<head>
		<title>Systems in Motion - Organization Chart</title>
		{{ HTML::script('js/jquery.min.js') }}
		{{ HTML::script('js/jquery.uniform.min.js') }}
		{{ HTML::script('js/jquery-ui.min.js') }}
		{{ HTML::style('css/style.css'); }}
	</head>
    <body>
    	<div align="center">
    		{{ HTML::image('images/sim-logo.png', 'alt', array( 'width' => 200, 'height' => 70 )) }}
    		<div id="navbar">
				<a href="depts">Departments</a>
				<a href="emps">Employees</a>
				<a href="titles">Job Titles</a>
				<a href="admin/login">Login</a>
			</div>
	        @yield('content')
    	</div>
    </body>
</html>