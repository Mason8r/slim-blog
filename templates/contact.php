<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>It's all about Stu</title>

    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
      /* Customize container */
      .jumbotron {
        margin-top: 30px;
      }
      @media (min-width: 768px) {
        .container {
          
          max-width: 730px;

        }
      }
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li><a href="/">Home</a></li>
          <li><a href="/about" >About</a></li>
          <li class="active"><a href="/contact">Contact</a></li>
        </ul>
        <h3 class="text-muted">stuartmason.co.uk</h3>
      </div>

      <div class="jumbotron">
        <h1><?php echo $heading ?></h1>
        <p class="lead"><?php echo $message ?></p>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <form method="post" action="contact" >
            <label for="name">Name</label>
            <input type="type" name="text">
          </form>
        </div>
      </div>


      <div class="footer">
        <p>&copy; Stuartmason.co.uk 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  </body>
</html>
