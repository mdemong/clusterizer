<?php
    require_once 'magic.php';
    $conn = new mysqli($hn, $un, $pw, $db);

    #check database connection
    if($conn->connect_error)
    {
        die(errorPage());
    }

    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
	{
		$username = mysql_entities_fix_string($conn, $_SERVER['PHP_AUTH_USER']);
		$password = mysql_entities_fix_string($conn, $_SERVER['PHP_AUTH_PW']);

		$querySelect = "SELECT * FROM user WHERE username = '$username'";
		$result = $conn->query($querySelect);
		if (!$result)
		{
			# query select failed
			die("Invalid username or password.");
		}
		else if($result->num_rows)
		{
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $result->close();
			$salt1 = $row['salt1'];
			$salt2 = $row['salt2'];
			$token = hash('ripemd128', '$salt1$password$salt2');
			if ($token == $row['hashpass'])
			{
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $row['name'];
                echo "<br><br><br><h1>Hello ".$row['name'].", you are now logged in!</h1>";
                die ("<p><a href=training.php>Continue to the training page here.</a></p>");            
            }
			else
			{
				die("Invalid username or password.");
			}
		}
		else
		{
			die("Invalid username or password.");
		}
	}
	else
	{
		header('WWW-Authenticate: Basic realm="Restricted Section"');
		header('HTTP/1.0 401 Unauthorized');
		die("Invalid username or password.");
	}

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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="training.php">Training</a></li>
                    <li><a href="testing.php">Testing</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li class="active"><a href="signin.php">Sign In</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

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
    
    $conn->close();
    echo "</body></html>";
?>