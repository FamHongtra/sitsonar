<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <p style="color:wheat;font-size:55px;text-align:center;">How to copy a TEXT to Clipboard on a Button-Click</p>

  <center>

    <div id="p1" style="display:none">1ST</div>
    <p id="p2">Hi, I'm the 2nd TEXT</p><br/>

    <button onclick="copyToClipboard('#p1')">Copy TEXT 1</button>


    <button onclick="setText()">Copy TEXT 2</button>


  </center>

  <script type="text/javascript">

  function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }

function setText(){
  document.getElementById('p1').innerHTML = '5555';
}

  </script>
</body>
</html>
