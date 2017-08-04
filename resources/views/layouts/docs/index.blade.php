<!DOCTYPE html>
<html lang="en">

@include('layouts.default.partials.head')

<body id="page-top" class="index">

<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>

@include('layouts.default.partials.nav')

<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                @include('layouts.docs.partials.menu')
            </div>
            <div class="col-md-9">
                @yield('main')
            </div>
        </div>
    </div>
</section>

@include('layouts.default.partials.footer')

@include('layouts.default.partials.foot')

</body>

</html>