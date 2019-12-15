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
                    <img class="d-block mx-auto mb-4" src="https://image.flaticon.com/icons/png/512/139/139690.png" alt="" width="100s" height="100">
                    <h1>Training</h1>
                    <p class="lead">Enter a name for your model and choose what type of algorithm you would like to train your model with. You must choose the dimensions for your model. You can then either upload a file to train your model OR enter values into the text box. Do not do both. If you do both, we will take the values from your file. Please format your file/values in textbox by having a tuple/line and separate values in the tuple with a space.</p>
                </div>
        
                <form action="training.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="text-center">
                        <label for="modelname">Model Name:</label>
                        <input type="text" id="modelname" name="modelname" required>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="text-center">
                        <label for="alg">Algorithm: </label>
                        <select class="custom-select d-block w-100" id="alg" name="alg" required>
                            <option value="">Choose...</option>
                            <option>k-means clustering</option>
                            <option>expectation maximization</option>
                        </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="text-center">
                        <label for="alg">Dimensions: </label>
                        <select class="custom-select d-block w-100" id="alg" name="alg" required>
                            <option value="">Choose...</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        </div>
                    </div>
        
                    <hr class="mb-4">
        
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                        <label for="file1">Upload a file of scores:</label>
                        <input type="file" class="form-control-file" id="file1" name="file1">
                        </div>
        
                        <div class="col-md-6 mb-3">
                        <label for="textarea">Type in score values:</label>
                        <textarea class="form-control" id="textarea" name="textarea" style="resize:none" rows="3"></textarea>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="text-center">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                    </div>
                </div>
        
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

        #model name with file upload only
        if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_FILES['file1'])) && (!empty($_FILES['file1']['tmp_name']))) && (empty($_POST['textarea'])))
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
   
        #model name with text upload only
        if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_POST['textarea'])) && (!empty($_POST['textarea']))) && (empty($_FILES['file1']['tmp_name'])))
        {
            enterText($conn);
        }
    
        #model name text and file chosen --> choose file
        if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_FILES['file1'])) && (!empty($_FILES['file1']['tmp_name']))) && ((isset($_POST['textarea'])) && (!empty($_POST['textarea']))))
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
    }
    else {
        echo "<br><br><br><h1>Please <a href='signin.php'>click here</a> to log in.</h1>";
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
    $conn->close();
    echo "</body></html>";
?>