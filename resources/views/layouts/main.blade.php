@include('inc._head')
  <body>
    
    @include('inc._nav')
    <div class="container">

      @include('inc._messages')
      @yield('content')
      <hr>

    </div>
@include('inc._foot')