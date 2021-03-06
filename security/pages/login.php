<?php
    require_once("../config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Security Officer Account Registration</title>
    <script type="text/javascript" src="../vendor/jquery/jquery.min.js"></script>
    <script src="../js/login.js"></script>

    <!-- Bootstrap Validator-->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js"> </script>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/login.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <div class="container">
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-login">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6">
              <a href="#" class="active" id="login-form-link">Login</a>
            </div>
            <div class="col-xs-6">
              <a href="#" id="register-form-link">Register</a>
            </div>
          </div>
          <hr>
        </div>
        <div class="panel-body">
          <?php if(isset($_SESSION['login_fail']) && $_SESSION['login_fail']) {
            echo
            '<div class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> The username / password combination you enetered was incorrect. Please try again.
            </div>';
          }?>
          <div class="row">
            <div class="col-lg-12">
              <form id="login-form" action="../php/login_check.php" data-toggle="validator" method="post" role="form" style="display: block;">
                <div class="form-group">
                  <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                </div>
                <div class="form-group">
                  <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                      <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                    </div>
                  </div>
                </div>
              </form>
              <form id="register-form" action="../php/register.php" method="post" role="form" data-toggle="validator" style="display: none;">
                <div class="form-group">
                  <input type="text" name="username" id="re_username" tabindex="1" class="form-control" placeholder="Username" value="" required>
                </div>
                <div class="form-group">
                  <input type="text" size="9" data-minlength="9" data-minlength-error="Invalid Social Security Number" name="ssn" id="ssn" tabindex="1" class="form-control" placeholder="Social Security Number" value="" required>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                  <input type="password" data-minlength="6" name="inputPassword" id="inputPassword" tabindex="2" class="form-control" placeholder="Password" required>
                  <div class="help-block">Minimum of 6 characters</div>
                </div>
                <div class="form-group">
                  <input type="password" name="confirm-password" id="confirm-password" data-match="#inputPassword" data-match-error="Passwords don't match." tabindex="2" class="form-control" placeholder="Confirm Password" required>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                      <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <br>
          <hr>
          <br>
            <div class="col-md-12">
                <a href="ticket.php" type="button" class="col-md-12 btn btn-warning btn-lg">
                	<i class="fa fa-ticket"></i> Submit Security Ticket
                </a>
            </div>

            <div class="col-md-12" style="margin-top:10px">
                <a href="../javaapi/" type="button" class="col-md-6 btn btn-success btn-lg">
                	<i class="fa fa-code"></i> Java API
                </a>
                <a href="../javaapi/SecurityDB.jar" type="button" class="col-md-6 btn btn-success btn-lg">
                	<i class="fa fa-coffee"></i> Java JAR
                </a>
            </div>
      </div>
    </div>
    </div>
  </div>
</div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Bootstrap Validator JavaScript -->
    <script src="../node_modules/bootstrap-validator/dist/validator.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php
if(isset($_SESSION['login_fail']))
{
	unset($_SESSION['login_fail']);
}
?>
