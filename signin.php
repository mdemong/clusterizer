<?php
    echo <<<_BEGIN
    <!doctype html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="https://image.flaticon.com/icons/png/512/139/139690.png">
    
        <title>Sign In</title>
    
        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">
    
        <!-- Bootstrap core CSS -->
        <link href="bootstrap-3.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- Custom styles for this template -->
        <link href="signup.css" rel="stylesheet">
      </head>
    
      <body class="text-center">
        <form action="signin.php" method="post" enctype="multipart/form-data">
          <img class="mb-4" src="https://image.flaticon.com/icons/png/512/139/139690.png" alt="" width="72" height="72">
          <h1 class="h3 mb-3 font-weight-normal">Sign in</h1><br>
    
          <div class="form-group">
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" name="inputUsername" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
          </div>

          <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
          </div>
    
          <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <br><p class="mt-5 mb-3 text-muted">	<a href = "index.php"> back to main page </a></p>
          </div>
      </form></body>
_BEGIN;

    require_once 'magic.php';
    $conn = new mysqli($hn, $un, $pw, $db);

    #check database connection
    if($conn->connect_error)
    {
        die(errorPage());
    }

    if(((isset($_POST['inputUsername'])) && (!empty($_POST['inputUsername']))) && ((isset($_POST['inputPassword'])) && (!empty($_POST['inputPassword']))))
	{
		$username = mysql_entities_fix_string($conn, $_POST['inputUsername']);
		$password = mysql_entities_fix_string($conn, $_POST['inputPassword']);

		$querySelect = "SELECT * FROM user WHERE username = '$username'";
		$result = $conn->query($querySelect);
		if (!$result)
		{
            # query select failed
            $result->close();
            die("Invalid username or password. Please <a href='signin.php'>click here</a> to try logging in again.");
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
                $_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
                if (!isset($_SESSION['initiated']))
                {
                    session_regenerate_id();
                    $_SESSION['initiated'] = 1;
                }
                echo "<script>alert(\"You are signed in!\");</script>";
                die();
            }
			else
			{
                die("Invalid username or password. Please <a href='signin.php'>click here</a> to try logging in again.");
			}
		}
		else
		{
            die("Invalid username or password. Please <a href='signin.php'>click here</a> to try logging in again.");
		}
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
    
    $conn->close();
    echo "</body></html>";
?>