@include('inc._head')
  <body>

    @include('inc._nav')
    <div class="banner"></div>
    <div class="container">

      @include('inc._messages')
      @yield('content')
      <hr>

    </div>
@include('inc._foot')