<?php
if (isset($_GET['type'])) {
  switch($_GET['type']) {
    case 'check':
      if (rand(1,10) === 1) {
        print "Let's update (any changed value will prompt an update)";
      } else {
        print "Static val";
      }
      break;
    case 'update':
      header('Content-Type: application/json');
      print json_encode(array('update' => "Last updated at: " . time()));
      break;
  }
  exit;
}
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>JS Update Manager Test</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
  <script src="js/update-manager.js"></script>
  <script type="text/javascript">
    var update = new UpdateManager("test.php?type=check", "test.php?type=update", "#mydiv", false);
    update.start(1000)
  </script>

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
  <h1>Test for Js Update Manager</h1>
  <h3>Div:</h3>
  <div id="mydiv" style="width: 550px; height: 120px; border: 1px black solid; padding: 5px;">
      Original value pre-js 
  </div>
</body>
</html>
