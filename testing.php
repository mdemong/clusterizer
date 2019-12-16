<?php
    require_once 'magic.php';
    $conn = new mysqli($hn, $un, $pw, $db);

    #check database connection
    if($conn->connect_error)
    {
        die(errorPage());
    }

    session_start();
    if (isset($_SESSION['username']))
	{
        if ($_SESSION['check'] != hash('ripemd128', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))
        {
            different_user();
        }
        else 
        {
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $name = $_SESSION['name'];

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
        
                <title>Testing</title>
        
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
                            <li class="active"><a href="testing.php">Testing</a></li>
                            <li><a href="about.php">About Us</a></li>
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
                    <h1>Testing</h1>
                    <p class="lead">TEST THE MODEL</p>
                </div>
        
                <form action="testing.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="filename">Upload a file!</label>
                        <input type="file" class="form-control-file" id="filename" name="filename">
                    </div>
        
                    <input type="submit" value="SUBMIT">
                </form>
        
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
    }
    else 
    {
        echo <<<_ERROR
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
        
            <title>ERROR</title>
        
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
                    <li><a href="about.php">About Us</a></li>
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
                    <h1>ERROR</h1>
                    <h1>You do not have access to this page because you are not logged in. Please <a href='signin.php'>click here</a> to log in.</h1>                </div>
                <div class="text-center">
                    <img class="rounded" src = "https://images-production.freetls.fastly.net/uploads/posts/image/160749/sad-cat-luhu.jpg?auto=compress&crop=faces%2Ctop&fit=crop&h=562&q=55&w=750">
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
    
        </body>
    </html>
_ERROR;
    }

    function errorPage()
	{
		header("Location:error.php");
		exit();
    }
    
    function mysql_entities_fix_string($conn, $string)
	{
		return htmlentities(mysql_fix_string($conn, $string));
	}

	function mysql_fix_string($conn, $string)
	{
		if (get_magic_quotes_gpc())
		{
			$string = stripslashes($string);
		}
		return $conn->real_escape_string($string);
	}

    function enterFile($conn)
    {
        $modelname = mysql_entities_fix_string($conn, $_POST['modelname']);
    }

    function enterText($conn)
    {
        $modelname = mysql_entities_fix_string($conn, $_POST['modelname']);
    }

    function different_user()
    {
        destroy_session_and_data();
        echo "Something went wrong! Please <a href='signin.php'>click here</a> to log in again.</h1>";
    }

    function destroy_session_and_data()
    {
        session_start();
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }
    $conn->close();
    echo "</body></html>";
?>