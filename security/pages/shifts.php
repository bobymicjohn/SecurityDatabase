<?php
    require("../config.php");
    if(empty($_SESSION['user']))
    {
        header("Location: ../index.html");
        die("Redirecting to ../index.html");
    }

    //Get Supervisees
    $query = "
        SELECT
          *
        FROM Security_Officer
        WHERE
        Super_SSN = :ssn
        ORDER BY Last_Name
    ";

    $query_params = array(
        ':ssn' => $_SESSION['user']['Officer_SSN']
    );

    try{
        $supervisees = $db->prepare($query);
        $result = $supervisees->execute($query_params);
        $supervisees->setFetchMode(PDO::FETCH_ASSOC);
    }
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
    $num_supervisees = $supervisees->rowCount();

    //Get Shifts
    $query = "
        SELECT
            *
        FROM Shift_Assignment AS S INNER JOIN Security_Officer AS O ON S.Officer_SSN = O.SSN
        WHERE
        S.Officer_SSN IN
        (SELECT
            SSN
        FROM Security_Officer
        WHERE Super_SSN = :ssn)
    ";

    $query_params = array(
        ':ssn' => $_SESSION['user']['Officer_SSN']
    );

    try{
        $shifts = $db->prepare($query);
        $result = $shifts->execute($query_params);
        $shifts->setFetchMode(PDO::FETCH_ASSOC);
    }
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
    $num_shifts = $shifts->rowCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shift Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Security Officer Terminal</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="user.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../php/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="user.php"><i class="fa fa-user fa-fw"></i> Profile</a>
                        </li>
                        <li>
                            <a href="alarms.php"><i class="fa fa-exclamation-triangle fa-fw"></i> Alarms</a>
                        </li>
                        <li>
                            <a href="tickets.php"><i class="fa fa-ticket fa-fw"></i> Tickets</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Shift Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4><b>Supervisees</h4><b>
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Shifts</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php while($row = $supervisees->fetch()) { ?>
                                <tr>
                                  <td><?php echo $row['Last_Name']; ?></td>
                                  <td><?php echo $row['First_Name']; ?></td>
                                  <td><?php echo $row['Phone_Number']; ?></td>
                                  <td><?php echo $row['Email']; ?></td>
                                  <td><?php

                                  $query = "
                                      SELECT
                                        *
                                      FROM Shift_Assignment
                                      WHERE
                                      Officer_SSN = :ssn
                                  ";

                                  $query_params = array(
                                      ':ssn' => $row['SSN']
                                  );

                                  try{
                                      $supervisee_shifts = $db->prepare($query);
                                      $result = $supervisee_shifts->execute($query_params);
                                      $supervisee_shifts->setFetchMode(PDO::FETCH_ASSOC);
                                  }
                                  catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
                                  $num_supervisee_shifts = $supervisee_shifts->rowCount();
                                  echo $num_supervisee_shifts; ?></td>
                                </tr>
                                <?php } ?>
                            <tbody>
                          </table>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4><b>All Shifts</b></h4>
                            There are currently <b><?php echo $num_shifts?></b> shifts under your management.
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php while($row = $shifts->fetch()) { ?>
                                <tr>
                                  <td><?php echo $row['Start_Time']; ?></td>
                                  <td><?php echo $row['End_Time']; ?></td>
                                  <td><?php echo $row['Last_Name']; ?></td>
                                  <td><?php echo $row['First_Name']; ?></td>
                                </tr>
                              <?php } ?>
                            <tbody>
                          </table>
                    </div>

                    <hr>
                  </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
