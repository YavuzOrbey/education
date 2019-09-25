@include('inc._head')
  <body>
    @include('inc._nav')
    @include('inc._admin')
    @include('inc._messages')
    <div class="main-display">
      <div style="margin-left: 10px;">
      @yield('content')
      <hr>
      </div>
      @include('inc._foot')
    </div>


