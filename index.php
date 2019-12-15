<?php
    echo <<<_BEGIN
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://image.flaticon.com/icons/png/512/139/139690.png">

    <title>Home</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.4.1-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="index.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Clusterizer</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li class="signed-in"><a href="training.php">Training</a></li>
                    <li class="signed-in"><a href="testing.php">Testing</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="index.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">User Options</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="signin.php">Sign In</a>
                            <a class="dropdown-item" href="signin.php">Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <div class="starter-template">
            <h1>CLUSTERIZER</h1>
            <h3> <br>Micah Demong | Gurdev Sihra | Katrina Tran</h3>
        </div>
        <div>
            <h1>k-means clustering</h1>
                <h3>...information about k-means clustering here...<h3>
            <h1>expectation maximization</h1>
                <h3>...information about expectation maximization here...<h3>
            <h1>want to try it out?</h1>
                <h3><a href = "signup.php">sign up here!</a><h3>
        </div>

    </div>
    <!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
    </script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

_BEGIN;
    echo "</body></html>"
?>