<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('xylophone.base.html_direction') }}">

<head>
  @include(xylophone_view('inc.head'))

</head>

<body class="{{ config('xylophone.base.body_class') }}">

  @include(xylophone_view('inc.main_header'))

  <div class="app-body">

    @include(xylophone_view('inc.sidebar'))

    <main class="main pt-2">

       @includeWhen(isset($breadcrumbs), xylophone_view('inc.breadcrumbs'))

       @yield('header')

        <div class="container-fluid animated fadeIn">

          @if (isset($widgets['before_content']))
            @include(xylophone_view('inc.widgets'), [ 'widgets' => $widgets['before_content'] ])
          @endif

          @yield('content')

          @if (isset($widgets['after_content']))
            @include(xylophone_view('inc.widgets'), [ 'widgets' => $widgets['after_content'] ])
          @endif

        </div>

    </main>

  </div><!-- ./app-body -->

  <footer class="{{ config('xylophone.base.footer_class') }}">
    @include(xylophone_view('inc.footer'))
  </footer>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(xylophone_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>
