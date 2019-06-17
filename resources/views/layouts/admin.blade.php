@include('inc._head')
  <body>
    @include('inc._nav')
    @include('inc._admin')
    <div class="container">
      @include('inc._messages')
      @yield('content')
      <hr>
    </div>
@include('inc._foot')

