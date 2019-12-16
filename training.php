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
                        <label for="clusters">Cluster Amount:</label>
                        <input type="text" id="clusters" name="clusters" required>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="text-center">
                        <label for="alg">Algorithm: </label>
                        <select class="custom-select d-block w-100" id="alg" name="alg" required>
                            <option value="">Choose...</option>
                            <option value = "0">k-means clustering</option>
                            <option value = "1">expectation maximization</option>
                        </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="text-center">
                        <label for="dim">Dimensions: </label>
                        <select class="custom-select d-block w-100" id="dim" name="dim" required>
                            <option value="">Choose...</option>
                            <option value = "2">2</option>
                            <option value = "3">3</option>
                            <option value = "4">4</option>
                            <option value = "5">5</option>
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
        if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_FILES['file1'])) && (!empty($_FILES['file1']['tmp_name']))) && (empty($_POST['textarea']))
           )
        {
            $number = $_POST['clusters'];
            $num = mysql_entities_fix_string($conn, $number);
            print "number: $num ";
            if(is_numeric($num)){
                $type = $_FILES['file1']['type'];
                if ($type === "text/plain")
                {
                    enterFile($conn);
                    $option = $_POST['alg'];
                    $dimesnion = int($option);
                    $dimOpt = $_POST['dim'];
                    
                    
                }
            }
        }
   
        #model name with text upload only
        if(((isset($_POST['modelname'])) && (!empty($_POST['modelname']))) && ((isset($_POST['textarea'])) && (!empty($_POST['textarea']))) && (empty($_FILES['file1']['tmp_name'])))
        {

            enterText($conn, );
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
                #
                session_unset();
                echo "<br><br><br><h1>Please <a href='signin.php'>click here</a> to log in.</h1>";
            }
        }
    }
    else {
        session_unset();
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
        $fileText = file_get_contents($_FILES['file1']['tmp_name'], FALSE, NULL, 0);
        $text = mysql_entities_fix_string($conn, $fileText);
        
        $arr = explode('\n', $text);
        echo "$check";
        $check = checkFile($arr);
        if($check == TRUE){
            inputDB($conn, $text);
        }else{
            #incorrect file format
            echo "<h3>The file uploaded does not match the specified dimension type. Please sign in again and input the correct file.<h3>";
            session_unset();
            echo "<br><br><br><h1>Please <a href='signin.php'>click here</a> to log in.</h1>";
        }
        
    }

    function enterText($conn)
    {
        $fileText = mysql_entities_fix_string($conn,$_POST['textarea']);
       
        $arr = explode('\r\n', $fileText);
        $check = checkFile($arr);
        if($check == TRUE){
            $arr = explode('\r', $fileText);
            $str = implode("", $arr);
            inputDB($conn, $str);
        }else{
            #incorrect file format
            echo "<h3>The text entered does not match the specified dimension type. Please sign in again and input the correct file.<h3>";
            session_unset();
            echo "<br><br><br><h1>Please <a href='signin.php'>click here</a> to log in.</h1>";
        }
        
    }
    
    # If the enterFile and enterText methods return a valid string, then the values can be sumitted to the DB if there are no errors
    function inputDB($conn, $fileText)
    {
        $modelname = mysql_entities_fix_string($conn, $_POST['modelname']);
        $dimension = (int)$_POST['dim'];
        $username = $_SESSION['username'];
        
        echo "$modelname   $dimension   $algorithm  $username";

        $preplace = $conn->prepare('INSERT INTO userFiles VALUES(?,?,?)');
        $preplace->bind_param('ssi', $username, $modelname, $dimension);
        
        $result = $preplace->execute();
        if($result){
            echo " added into database";
           // computeAlg($fileText, );
            
        }else{
            #incorrect file format
            echo "<h3>The text entered does not match the specified dimension type. Please sign in again and input the correct file.<h3>";
            session_unset();
            echo "<br><br><br><h1>Please <a href='signin.php'>click here</a> to log in.</h1>";
        }
        $preplace->close();
    }
    
    
    function computeAlg($fileText)
    {
        $algorithm = (int)$_POST['alg'];
        $number = $_POST['clusters'];
        $dimension = $_POST['dim'];
        $combine = $fileText." ZZZ ".$dimension." ZZZ ".$number;
        if($algorithm == 0){
            $PATH_TO_SCRIPT = "scripts/k-means.py";
            // There also exists an escapeshellcmd() function.
            $command = escapeshellcmd('python ' // . dirname(__DIR__) . '/'
                                      . $PATH_TO_SCRIPT . " \"" . $combine . "\"");
            $output = [];
            $retcode = -1;
            echo "$combine<br>";
            echo "$command<br>";
            exec($command, $output, $retcode);
            if($retcode !== 0) echo "Error $retcode<br>";
            echo implode("<br>",$output);
            //echo $pyout;
        }
    }
    
    
    function checkFile($fileText)
    {
        $dimension = (int)$_POST['dim'];
        foreach($fileText as $data) {
            // Splits file into array separated by spaces >> Should contain each value in point
            $result = explode(" ", $data);
            if(count($result) == $dimension){
                foreach($result as $num){
                    if(!is_numeric($num)){
                        return FALSE;
                    }
                }
            }else{
                $length = count($result);
                return FALSE;
            }
        }
        return TRUE;
    }
    
    $conn->close();
    echo "</body></html>";
?>