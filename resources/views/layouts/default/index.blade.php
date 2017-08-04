<!DOCTYPE html>
<html lang="en">

@include('layouts.default.partials.head')

<body id="page-top" class="index">

<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>

@include('layouts.default.partials.nav')

@include('layouts.default.partials.header')

@yield('main')

@include('layouts.default.partials.footer')

@yield('modals')

@include('layouts.default.partials.foot')

</body>

</html>