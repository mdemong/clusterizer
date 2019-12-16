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
                    <p class="lead">This will compare the results from the trained model with the distance between each point and the final centroids. While training attaches data points to certain clusters, the testing will show the actual distance between each data point and the final centroid. </p>
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
            testForm($conn);
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

    function testForm($conn)
    {
        echo "<form action=\"testing.php\" method=\"post\" enctype=\"multipart/form-data\">
        <div class=\"form-group\">
        <div class=\"text-center\">
        <label for=\"modeln\">Model Names: </label>
        <select class=\"custom-select d-block w-100\" id=\"modeln\" name=\"modeln\" required>
        <option value=\"\">Choose...</option>";
        $querySelectMN = "SELECT * FROM userFiles WHERE username = '".$_SESSION['username']."'";
		$result = $conn->query($querySelectMN);
		if (!$result)
		{
            # query select failed
            die("<script>alert(\"There are no models for this user. Train first!\");</script>");
		}
		else
		{
            for ($i = 1; $i < ($result->num_rows)+1; $i++)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo "<option value=\"$i\"> Model Name: ". $row['modelname'] . " | Dimensions: ". $row['dimension']. "</option>";
            }
            $result->close();
            echo "</select></div></div>
            <div class=\"form-group\">
            <div class=\"text-center\">
                <input type=\"file\" class=\"form-control-file\" id=\"filename\" name=\"filename\">
                </div>
            </div>
            <div class=\"text-center\">
            <input type=\"submit\" value=\"SUBMIT\">
            </div>
            </form>";
        }
        if(((isset($_POST['modeln'])) && (!empty($_POST['modeln']))) && ((isset($_FILES['filename'])) && (!empty($_FILES['filename']['tmp_name']))))
        {
            $modelchoice = (int)$_POST['modeln'];
            $querySelectMN = "SELECT * FROM userFiles WHERE username = '".$_SESSION['username']."'";
            $result = $conn->query($querySelectMN);
            if (!$result)
            {
                # query select failed
                die("<script>alert(\"There are no models for this user. Train first!\");</script>");
            }
            else
            {
                for ($i = 1; $i <= $modelchoice; $i++)
                {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                }
                $result->close();
                $dim = $row['dimension'];
                $mn = $row['modelname'];
                $algtype = $row['algtype'];
                enterFile($conn, $dim, $mn, $algtype);
            }
        }
    }
    
    function enterFile($conn, $dim, $mn, $algtype)
    {
        $fileText = file_get_contents($_FILES['filename']['tmp_name'], FALSE, NULL, 0);
        $text = mysql_entities_fix_string($conn, $fileText);
        
        $arr = explode('\n', $text);
        
        $check = checkFile($arr, $dim);
        
        if($check == TRUE)
        {
            $str = implode("", $arr);
            #algtype = 0 = kmeans
            
            if($algtype == 1) {
                testEM($conn, $dim, $mn, $algtype, $text);
            }

        }
        else
        {
            #incorrect file format
            echo "<h3>The file uploaded does not match the specified dimension type. Please sign in again and input the correct file.<h3>"; 
        }
    }

    function testEM($conn, $dim, $mn, $algtype, $text) {
        $query = "SELECT * FROM (em NATURAL JOIN userFiles)
                    WHERE username=(?) AND modelname=(?);";
        $preplace = $conn->prepare($query);
        $preplace->bind_param('ss', $username, $mn);
        $username = $_SESSION['username'];
        $succeed = $preplace->execute();
        if (!$succeed) die("<script>alert(\"Something went wrong! Please try again.\");</script>");
        
        $result = $preplace->get_result();
        if(!$result) die("<script>alert(\"Something went wrong! Please try again.\");</script>");

        $arr = $result->fetch_assoc();

        $resarr = [];
        $resarr['dist'] = $arr['distributions'];
        $resarr['points'] = $text;
        $resarr['dimension'] = $arr['dimension'];

        
        $PATH_TO_SCRIPT = "scripts/em.py";
        $command = escapeshellcmd('python ' . $PATH_TO_SCRIPT . " \"" . json_encode($resarr) . "\"");
        $output = [];
        $retcode = -1;
        
        exec($command, $output, $retcode);
        if($retcode !== 0) echo "Sorry, something went wrong. Please try again.<br>";
        
        print($output[0]);

        $result->close();
        $preplace->close();
    }

    function checkFile($fileText, $dimension)
    {
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