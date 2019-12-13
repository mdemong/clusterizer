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

    <title>Training</title>

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
                    <li class="active"><a href="training.php">Training</a></li>
                    <li><a href="testing.php">Testing</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <div class="starter-template">
            <h1>Training</h1>
            <p class="lead">TRAIN THE MODEL</p>
        </div>

        <form action="training.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="modelname">Name of the uploaded model:</label>
                <input type="text" id="modelname" name="modelname">
            </div>

            <div class="form-group">
                <label for="file1">Upload a file of scores:</label>
                <input type="file" class="form-control-file" id="file1" name="file1">
            </div>

            <div class="form-group">
                <label for="textarea">Type in score values:</label>
                <textarea class="form-control" id="textarea" name="textarea" rows="3"></textarea>
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
_BEGIN;
    
    require_once 'magic.php';
    $conn = new mysqli($hn, $un, $pw, $db);

    #check database connection
    if($conn->connect_error)
    {
        die(errorPage());
    }

    #model name with file upload
    if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_FILES['file1'])) && (!empty($_FILES['file1']['tmp_name']))))
	{
        $type = $_FILES['file1']['type'];
		if ($type === "text/plain")
		{
            enterFile($conn);
        }
        else {
            #incorrect file format
            echo "<h3>Incorrect file format! Please try again with a .txt file.<h3>";
        }
    }
    
    #model name with text upload
    if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_POST['textarea'])) && (!empty($_POST['textarea']))))
	{
		enterText($conn);
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
    echo "</body></html>"
?>