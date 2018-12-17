<!DOCTYPE html>
<html lang="en">

@yield('head')

<body>

<div class="super_container">
	
	@include('header')

	@yield('content')

	@include('footer')

	@include('copyright')

</div>

@yield('script')
<script async src="//static.zotabox.com/7/a/7ae5b21e851dbd458f3f3815baa7edbb/widgets.js"></script>
</body>

</html>