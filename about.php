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

    <title>About Us</title>

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
            <a class="navbar-brand" href="index.php"> Clusterizer</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            </button>
        </div>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="training.php">Training</a></li>
            <li><a href="testing.php">Testing</a></li>
            <li class="active"><a href="about.php">About Us</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">User Options
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="signin.php">Sign In</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--/.nav-collapse -->
    </div>
    </nav>

    <div class="container">
        <div class="starter-template">
            <img class="d-block mx-auto mb-4" src="https://image.flaticon.com/icons/png/512/139/139690.png" alt="" width="100" height="100">
            <h1>CLUSTERIZER</h1>
            <h3> <br> Micah Demong | Gurdev Sihra | Katrina Tran</h3>
            <h1> <br>ABOUT US</h1>
        </div>
        <div>
                <h2 class="text-center">Micah Demong</h2>
    <div class = "text-center"><img style="border-radius: 50%;"class="rounded"  vspace="20"src="images/micah.jpg" alt="avatar" width=30% height=30%;></div>
                    <h3>I like pizza and dogs 🍕🐶<h3>
     <div class = "text-center"><img style="border-radius: 50%;"class="rounded vspace="20"" src="images/gurdev.jpg" alt="avatar" width=30% height=30%;></div>
                <h2 class="text-center">Gurdev Sihra</h2>
    <h3> I am a dynamic figure ☃, often seen scaling walls and crushing ice. I have been known to remodel train stations 🚆 on my lunch breaks, making them more efficient in the area of heat retention. I translate ethnic slurs for Cuban refugees, I write award-winning operas, I manage time efficiently. Occasionally, I tread water for three days in a row. I can hurl tennis rackets at small moving objects with deadly accuracy. I once read Paradise Lost, Moby Dick, and David Copperfield in one day and still had time to refurbish an entire dining room that evening. On weekends, to let off steam, I participate in full-contact origami. I have performed several covert operations for the CIA 🕵️‍♀️. I sleep once a week; when I do sleep, I sleep in a chair. While on vacation in Canada, I successfully negotiated with a group of terrorists who had seized a small bakery. The laws of physics do not apply to me.
<h3>
    <div class = "text-center"><img style="border-radius: 50%;"class="rounded" vspace="20" src="images/katrina.JPG" alt="avatar" width=30% height=30%;></div>
                <h2 class="text-center">Katrina Tran</h2>
                    <h3>I am an abstract artist 🎨, a concrete analyst, and a ruthless bookie. Critics worldwide swoon over my original line of corduroy evening wear. I do not perspire. I am a private citizen, yet I receive fan mail. I have been caller number nine and have won the weekend passes. Last summer I toured New Jersey with a traveling centrifugal-force demonstration. I bat .400. My deft floral 🌹 arrangements have earned me fame in international botany circles. I balance, I weave, I dodge, I frolic, and my bills are all paid. I know the exact location of every food item in the supermarket. Years ago I discovered the meaning of life but forgot to write it down. I have made extraordinary four course meals using only a mouli and a toaster oven. I breed prizewinning clams. I have won bullfights in San Juan, cliff-diving competitions in Sri Lanka, and spelling bees at the Kremlin. I have played Hamlet, I have performed open-heart surgery ❤️, and I have spoken with Elvis.<h3>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
_BEGIN;
    echo "</body></html>";
?>
