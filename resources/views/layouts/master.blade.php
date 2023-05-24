<!DOCTYPE html>
<html lang="en">
<head>
	<title>ECOSYSTEM</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="#" />
	@include('layouts.css')
	@yield('css-custom-script')
  	@yield('css-custom')
</head>

<body>

@yield('content')
@include('layouts.js')
@yield('js-custom-script')
@yield('js-custom')


</body>
</html>
