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

    <title>Sign Up</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.4.1-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signup.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form action="signup.php" method="post" enctype="multipart/form-data">
      <img class="mb-4" src="https://image.flaticon.com/icons/png/512/139/139690.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Sign up</h1><br>

      <div class="form-group">
        <label for="inputName" class="sr-only">Name</label>
        <input type="text" name="inputName" id="inputName" class="form-control" placeholder="Name" required autofocus>
      </div>

      <div class="form-group">
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" name="inputUsername" id="inputUsername" class="form-control" placeholder="Username (A-Z, a-z, -, _)" required autofocus>
      </div>
      
      <div class="form-group">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      </div>

      <div class="form-group">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password (> 10)" minlength="10" required>
      </div>

      <div class="form-group">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        <br><p class="mt-5 mb-3 text-muted">	<a href = "index.php"> back to main page </a></p>
      </div>
  </form></body>
_BEGIN;

  define("SALT1_LEN", 4);
  define("SALT2_LEN", 5);
  define("STRING_BEG", 0);
  define("STRING_MASH", "aeoxbxs!asd!fjkl%#weruip#zxvnm*1039475839201029384756574#*");
  define("VALID_USERNAME", "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_-");

  require_once 'magic.php';
  $conn = new mysqli($hn, $un, $pw, $db);

  #check database connection
  if($conn->connect_error)
  {
      die(errorPage());
  }

	$queryCreateUserTable = "CREATE TABLE IF NOT EXISTS user(
		name VARCHAR(64) NOT NULL,
    username VARCHAR(32) UNIQUE NOT NULL PRIMARY KEY,
    email VARCHAR(64) UNIQUE NOT NULL,
    salt1 CHAR(4) UNIQUE NOT NULL,
    salt2 CHAR(5) UNIQUE NOT NULL,
		hashpass CHAR(32) NOT NULL);";
  
  $createTable = $conn->query($queryCreateUserTable);
	if (!$createTable)
	{
    # table could not be created
		die(errorPage());
  }
    
    $queryCreateUserFilesTable = "CREATE TABLE IF NOT EXISTS userFiles(
    username VARCHAR(32) NOT NULL,
    modelname VARCHAR(32) NOT NULL,
    algtype INTEGER NOT NULL,
    PRIMARY KEY(username, modelname),
    dimension INTEGER NOT NULL);";
    
    $createTable = $conn->query($queryCreateUserFilesTable);
    if (!$createTable)
    {
        # table could not be created
        die(errorPage());
    }
    
    $queryCreatekmeansTable = "CREATE TABLE IF NOT EXISTS kmeans (
      username  VARCHAR(32) NOT NULL,
      modelname VARCHAR(32) NOT NULL,
      centroids LONGTEXT,
      PRIMARY KEY(username, modelname));";
    
    $createTable = $conn->query($queryCreatekmeansTable);
    if (!$createTable)
    {
        # table could not be created
        die(errorPage());
    }

    $queryCreateEMTable = "CREATE TABLE IF NOT EXISTS em (
      username  VARCHAR(32) NOT NULL,
      modelname VARCHAR(32) NOT NULL,
      distributions LONGTEXT,
      PRIMARY KEY(username, modelname));";
    
    $createTable = $conn->query($queryCreateEMTable);
    if (!$createTable)
    {
        # table could not be created
        die(errorPage());
    }
    #$createTable->close();

  if(((isset($_POST['inputName'])) && (!empty($_POST['inputName']))) && ((isset($_POST['inputUsername'])) && (!empty($_POST['inputUsername']))) && ((isset($_POST['inputEmail'])) && (!empty($_POST['inputEmail']))) && ((isset($_POST['inputPassword'])) && (!empty($_POST['inputPassword']))))
  {
    addUser($conn);
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

  function addUser($conn)
  {
    $preplace = $conn->prepare('INSERT INTO user VALUES(?,?,?,?,?,?)');
		$preplace->bind_param('ssssss', $name, $username, $email, $salt1, $salt2, $token);

    $name = mysql_entities_fix_string($conn, $_POST['inputName']);
    $username = mysql_entities_fix_string($conn, $_POST['inputUsername']);
    $email = mysql_entities_fix_string($conn, $_POST['inputEmail']);
    $password = mysql_entities_fix_string($conn, $_POST['inputPassword']);

    $userNameValid = true;
    for($i = 0; $i <strlen($username); $i++)
    {
      $pos = strpos(VALID_USERNAME, substr($username, $i, 1));
      if ($pos === false) 
      {
        $userNameValid = false;
      }
    }

    if($userNameValid === false)
    {
      die("<script>alert(\"Your username is in the wrong format. Please try signing up again.\");</script>");
    }
    else 
    {
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
      {
        $shuf1 = str_shuffle(STRING_MASH);
        $salt1 = substr($shuf1, STRING_BEG, SALT1_LEN);
        $shuf2 = str_shuffle(STRING_MASH);
        $salt2 = substr($shuf2, STRING_BEG, SALT2_LEN);
        $token = hash('ripemd128', "$salt1$password$salt2");

        $addUser = $preplace->execute();
		    if (!$addUser)
		    {
          # user could not be inserted
          die("<script>alert(\"Something went wrong! Please try signing up again.\");</script>");
        }
        else {
			    die("<script>alert(\"You are signed up! Go back to the main page.\");</script>");
        }
        $addUser->close();
      }
      else 
      {
        die("<script>alert(\"Your email is in the wrong format. Please try signing up again.\");</script>");
      }
    }
  }

	$conn->close();
  echo "</html>";
?>
