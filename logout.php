<?php
    session_start();
    if (isset($_SESSION['username']))
	{
        if ($_SESSION['check'] != hash('ripemd128', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))
        {
            different_user();
        }
        else 
        {
            destroy_session_and_data();
            showLogout();            
        }
    }   
    else {
        echo "<br><br><br><h1>You aren't logged in, please <a href='signin.php'>click here</a> to log in.</h1>";
    }

    function different_user()
    {
        destroy_session_and_data();
        echo "Something went wrong! Please <a href='signin.php'>click here</a> to log in again.</h1>";
    }

    function destroy_session_and_data()
    {
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }

    function showLogout()
    {
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
    
            <title>Log Out</title>
    
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="training.php">Training</a></li>
                        <li><a href="testing.php">Testing</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">User Options
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="signin.php">Sign In</a></li>
                                <li class="active"><a href="logout.php">Log Out</a></li>
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
                <h1>You are logged out!</h1>
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
    }
?>