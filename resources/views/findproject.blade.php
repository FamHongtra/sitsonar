<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Dosis:100,600" rel="stylesheet" type="text/css">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">



  <script src="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.css">
  <script src="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.js"></script>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <!-- Styles -->
  <style>
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Dosis', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
  }

  .full-height {
    height: 100vh;
  }

  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }

  .position-ref {
    position: relative;
  }

  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .content {
    text-align: center;
  }

  .title {
    font-size: 84px;
  }

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }

  .m-b-md {
    margin-bottom: 30px;
  }

  .modal-body .form-horizontal .col-sm-2,
  .modal-body .form-horizontal .col-sm-10 {
    width: 100%
  }

  .modal-body .form-horizontal .control-label {
    text-align: left;
  }
  .modal-body .form-horizontal .col-sm-offset-2 {
    margin-left: 15px;
  }
  </style>
</head>
<body background="img/bg.png">




  <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
    <div class="top-right links">
      @if (Auth::check())
      <a href="{{ url('/home') }}">Home</a>
      @else
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/register') }}">Register</a>
      @endif
    </div>
    @endif

    <div class="content">
      <div class="title m-b-md">
        <h5>PROJECT NAME</h5>{{$project->projectname}}
      </div>
      <div class="">

        <a href="{{url('/')}}"><button type="button" class="btn btn-outline-success btn-lg" style="font-family:Dosis">Exit</button></a>
        <button type="button" class="btn btn-success btn-lg" onclick="scan()" style="font-family:Dosis"><i class="material-icons">search</i> SONAR SCANNER</button>
      </div><br>
      <br>
    </div>
    <div id="projkey" style="display:none">{{$project->projectkey}}</div>
    <div class="" style="display:none">
      <form id="scanner" action="{{url('scanproject')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="projectkey" value="">
      </form>
    </div>



    <script type="text/javascript">
    function scan(){
      $key = document.getElementById('projkey').innerHTML ;
      swal({
        title: 'Lets scan!',
        text: 'This process will take a few minutes.',
        imageUrl: 'img/search-loading.gif',
        imageWidth: 200,
        imageHeight: 150,
        showCancelButton: true,
        confirmButtonText: 'Start',
        animation: false,
      }).then(function () {
        swal({
          imageUrl: 'img/loading.gif',
          imageWidth: 200,
          imageHeight: 150,
          showCancelButton: false,
          showConfirmButton: false,
          animation: false,
          allowOutsideClick: false,
        })
        document.getElementById('scanner').elements.namedItem("projectkey").value = $key ;
        document.getElementById('scanner').submit();
      })
    }

    </script>
  </body>
  </html>
