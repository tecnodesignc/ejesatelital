<!DOCTYPE html>
<html>
<head lang="{{ LaravelLocalization::setLocale() }}">
    <meta charset="UTF-8">
    @section('meta')
        <meta name="description" content="@setting('core::site-description')"/>
    @show
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@section('title')@setting('core::site-name')@show</title>
    <link rel="canonical" href="{{canonical_url()}}"/>
    <link rel="shortcut icon" href="{{ Theme::url('favicon.ico') }}">

    {!! Theme::style('css/main.css'.config('app.version')) !!}
    @stack('css-stack')
</head>
<body>

@auth
    @include('partials.admin-bar')
@endauth
@include('partials.header')

<div class="container">
    @yield('content')
</div>
@include('partials.footer')

{!! Theme::style('css/stiles.css?v='.config('app.version')) !!}
{!! Theme::script('js/all.js?v='.config('app.version')) !!}
{!! Theme::script('js/secondary.js?v='.config('app.version')) !!}

@yield('scripts')

<?php if (Setting::has('core::analytics-script')): ?>
{!! Setting::get('core::analytics-script') !!}
<?php endif; ?>
@stack('js-stack')
</body>
</html>
