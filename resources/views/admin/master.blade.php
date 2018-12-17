<!DOCTYPE html>
<html>

@yield('head')

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('admin.header')
			@include('admin.menu')
		</nav>
		@yield('content')
	</div>
@yield('script')
</body>

</html>