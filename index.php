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
            <a class="navbar-brand" href="index.php"> Clusterizer</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            </button>
        </div>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
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
            <h1>CLUSTERIZER</h1>
            <h3> <br>Micah Demong | Gurdev Sihra | Katrina Tran</h3>
        </div>
        <div>
             <div class = "text-center"><h1>K-Means Clustering Algorithm</h1></div>
    <div class = "text-center"><img class="rounded" src="https://upload.wikimedia.org/wikipedia/commons/e/ea/K-means_convergence.gif" alt="" width=30% height=30%;></div>
    <h3>An iterative algorithm that tries to partition the dataset into K pre-defined distinct non-overlapping subgroups (clusters) where each data point belongs to only one group. This algorithm is implemented using the following steps:</h3>
              <h4><ol>
                <li>Specify number of clusters K.</li>
                <li>Initialize centroids by first shuffling the dataset and then randomly selecting K data points for the centroids without replacement.</li>
                <li>Keep iterating until there is no change to the centroids. The centroids are updated like:</li>
                </ol></h4>
  
             <h5>   <ul>
                <li>Compute the sum of the squared distance between data points and all centroids.</li>
                <li>Assign each data point to the closest cluster (centroid).</li>
                <li>Compute the centroids for the clusters by taking the average of the all data points that belong to each cluster.</li>
                </ul>
    </h5>
        <h4>Learn more at<a href ="https://towardsdatascience.com/k-means-clustering-algorithm-applications-evaluation-methods-and-drawbacks-aa03e644b48a"> this link</a>!</h4>
    
     <div class = "text-center"><h1>Expectation Maximization Algorithm</h1></div>
    <div class = "text-center"><img class="rounded" src="https://upload.wikimedia.org/wikipedia/commons/6/69/EM_Clustering_of_Old_Faithful_data.gif" alt=""></div>
    <h3>An algorithm that uses the available observed data of the dataset to estimate the missing data and then using that data to update the values of the parameters. This is implemented in the following steps:</h3>
    <ol>
    <h4>  <li>Initially, a set of initial values of the parameters are considered. A set of incomplete observed data is given to the system with the assumption that the observed data comes from a specific model.</li>
    <li>The next step is known as “Expectation” – step or E-step. In this step, we use the observed data in order to estimate or guess the values of the missing or incomplete data. It is basically used to update the variables.</li>
    <li>The next step is known as “Maximization”-step or M-step. In this step, we use the complete data generated in the preceding “Expectation” – step in order to update the values of the parameters. It is basically used to update the hypothesis.</li>
    <li>Now, in the fourth step, it is checked whether the values are converging or not, if yes, then stop otherwise repeat step-2 and step-3 i.e. “Expectation” – step and “Maximization” – step until the convergence occurs.</li>
    </ol>
    </h4>
    <h4>Learn more at<a href ="https://www.geeksforgeeks.org/ml-expectation-maximization-algorithm/"> this link</a>!</h4>
    
    
    <h1>Want to try it out?</h1>
                <h3><a href = "signup.php">sign up here!</a><h3>
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
