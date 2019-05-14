@include('inc._head')
  <body>
    @include('inc._nav')

    <div class="container">
      @include('inc._messages')
      @yield('content')
      <hr>
      <p class="text-center">Copyright {{ date('Y')}}</p>
    </div>
@include('inc._foot')