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
<body background="img/bg.png" onload="newScan()">



  @if (session('status'))
  <div id="status" style="display:none">
    {{ session('status') }}
  </div>
  @endif

  <div id="p1" style="display:none"></div>

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
        <img src="img/logo.png" alt="" width="350px">
      </div>

      <br>
      <div class="">
        <button type="button" class="btn btn-outline-success btn-lg" onclick="enterKey()" style="font-family:Dosis">Let's Scan</button>
        <!-- <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#exampleModal" style="font-family:Dosis">New Scan</button> -->
        <div class="btn-group">
          <button type="button" class="btn btn-lg btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            New Scan
          </button>

          <div class="dropdown-menu">
            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" href="#" style="font-family:Dosis;color:#636b6f">Repository</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal2" href="#" style="font-family:Dosis;color:#636b6f">Upload project</a>
            <!-- <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a> -->
          </div>
        </div>
      </div><br>
      <div class="">
        <a href="https://sonarqube.com" target="_blank"><img src="img/sonaricon.png" alt="" width="25px"> <span style="color:#20A8F5">VIEW ON SONARQUBE</span></a>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="{{url('newscan')}}" method="post" id="newscanForm" onsubmit="pageloading()">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="projecttype" value="repo">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" style="color:#20A8F5"><img src="img/sonaricon.png" alt="" width="25px"> Sonar Properties</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label for="recipient-name" class="form-control-label">Project Name:</label>
                <input type="text" class="form-control" id="projectname" name="projectname" required="">
              </div>
              <div class="form-group">
                <label for="message-text" class="form-control-label">Project Repo:</label>
                <input type="text" class="form-control" id="projectrepo" name="projectrepo" required="">
              </div>
              <br>
              <div class="form-group">
                <label for="recipient-name" class="form-control-label">Organization Key:</label>
                <input type="text" class="form-control" id="organization" name="organization" required="">
              </div>
              <div class="form-group">
                <label for="message-text" class="form-control-label">Token:</label>
                <input type="text" class="form-control" id="token" name="token" required="">
              </div>

              <!-- <div class="form-group">
              <label for="recipient-name" class="form-control-label">Recipient:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
            <label for="message-text" class="form-control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-family:Dosis;color: #636b6f;">Close</button>
          <button type="submit" class="btn btn-success" style="font-family:Dosis">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{url('newscan')}}" method="post" id="newscanForm" enctype="multipart/form-data" onsubmit="return Validate(this);">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="projecttype" value="upload">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" style="color:#20A8F5"><img src="img/sonaricon.png" alt="" width="25px"> Sonar Properties</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Project Name:</label>
            <input type="text" class="form-control" id="projectname" name="projectname" required="">
          </div>
          <div class="form-group">
            <label for="message-text" class="form-control-label">Upload Project:</label>
            <input type="file" class="form-control" id="projectrepo" name="projectrepo" required="">
          </div>
          <br>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Organization Key:</label>
            <input type="text" class="form-control" id="organization" name="organization" required="">
          </div>
          <div class="form-group">
            <label for="message-text" class="form-control-label">Token:</label>
            <input type="text" class="form-control" id="token" name="token" required="">
          </div>

          <!-- <div class="form-group">
          <label for="recipient-name" class="form-control-label">Recipient:</label>
          <input type="text" class="form-control" id="recipient-name">
        </div>
        <div class="form-group">
        <label for="message-text" class="form-control-label">Message:</label>
        <textarea class="form-control" id="message-text"></textarea>
      </div> -->
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-family:Dosis;color: #636b6f;">Close</button>
      <button type="submit" class="btn btn-success" style="font-family:Dosis">Submit</button>
    </div>
  </form>
</div>
</div>
</div>

<form id="enterkey" action="{{url('enterkey')}}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="key" value="">
</form>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.1/clipboard.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript">

function enterKey(){
  swal({
    title: 'Enter your project key',
    input: 'text',
    inputValidator: function (value) {
      return new Promise(function (resolve, reject) {
        if (value) {
          document.getElementById('enterkey').elements.namedItem("key").value = value ;
          $("#enterkey").submit();
          resolve();
        } else {
          reject('You need to write something!')
        }
      })
    }
  })
}

function newScan(){
  $status = document.getElementById('status').innerHTML ;


  // if($status != ""){
  if($status.indexOf("sit:kmutt:") !== -1){

    swal.queue([{
      title: 'Successful',
      confirmButtonText: 'Show my project key',
      type: 'success',
      showLoaderOnConfirm: true,
      allowOutsideClick: false,
      text:
      'Your project key will be received ' +
      'via our system request',
      showLoaderOnConfirm: true,
      preConfirm: function () {
        return new Promise(function (resolve) {
          $.get('https://api.ipify.org?format=json')
          .done(function () {
            swal({
              // title:'<h5>'+$status+'</h5>',
              title: $status,
              animation: true,
              confirmButtonText:'Copy' ,
              allowOutsideClick: false}).then(function () {
                window.copyToClipboard('#status');

                swal({

                  title: 'Copied!',
                  type: 'success',
                  showConfirmButton: false,
                  timer: 2000,
                })

              }).insertQueueStep()
              resolve()
            })
          })
        }
      }])
    }

    if($status.indexOf("keynotexist") !== -1){

      swal(
        'Oops...',
        'Please check your project key!',
        'error'
      )
    }

    if($status.indexOf("success") !== -1){
      swal(
        'Good job!',
        'Let\'s check your project!',
        'success'
      )
    }

    if($status.indexOf("failed") !== -1){
      swal(
        'Oops...',
        'Something went wrong!',
        'error'
      )
    }


  }

  var _validFileExtensions = [".zip", ".rar"];
  function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
      var oInput = arrInputs[i];
      if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
          var blnValid = false;
          for (var j = 0; j < _validFileExtensions.length; j++) {
            var sCurExtension = _validFileExtensions[j];
            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
              $('#exampleModal2').modal('toggle');
              swal({
                imageUrl: 'img/loading.gif',
                imageWidth: 200,
                imageHeight: 150,
                showCancelButton: false,
                showConfirmButton: false,
                animation: false,
                allowOutsideClick: false,
              })
              blnValid = true;
              break;
            }
          }

          if (!blnValid) {
            swal(
              'Sorry...',
              'Only support file extensions ".zip" and ".rar"',
              'error'
            )
            return false;
          }
        }
      }
    }

    return true;
  }

  function pageloading(){
    $('#exampleModal').modal('toggle');

    swal({
      imageUrl: 'img/loading.gif',
      imageWidth: 200,
      imageHeight: 150,
      showCancelButton: false,
      showConfirmButton: false,
      animation: false,
      allowOutsideClick: false,
    })
  }

  function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }

  </script>
</body>
</html>
