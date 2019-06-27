@include('inc._head')
  <body>
    @include('inc._nav')
    @include('inc._admin')
    @include('inc._messages')
    <div class="main-display">
      <div class="container">
      @yield('content')
      <hr>
      </div>
      @include('inc._foot')
    </div>


