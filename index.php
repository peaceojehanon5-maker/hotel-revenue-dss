<?php include "core/controller.php"; ?>
<?php

if($_SESSION['userData']['type'] != 'A')
    header('Location: logout.php' );

$sql = "SELECT * FROM users WHERE type != 'A' ";
$query = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>DSS | Hotel </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <link type="text/css" href="css/app.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <!-- end of global css -->
</head>

<body class="skin-coreplus">

<!-- header logo: style can be found in header-->
<header class="header">
     <?php include "inc_nav.php";?>
</header>
<div id="app" class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">
                 <ul class="navigation">
                    <li>
                        <a href="logout.php">
                            <i class="menu-icon fa fa-fw fa-home"></i>
                            <span class="mm-text ">logout</span>
                        </a>
                    </li>
                </ul>
                <!-- / .navigation -->
            </div>
            <!-- menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Blank</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">
                        <i class="fa fa-fw fa-home"></i> Dashboard
                    </a>
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-fw fa-crosshairs"></i> Add User
                            </h3>
                            <span class="pull-right">
                                <!-- <i class="fa fa-fw fa-chevron-up clickable"></i> -->
                                <!-- <i class="fa fa-fw fa-times removepanel clickable"></i> -->
                            </span>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" action="core/register.php" id="user-form" role="form">
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Full Name </label>
                                    <div class="col-sm-10">
                                        <input type="text" required name="name" class="form-control" 
                                               placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Email </label>
                                    <div class="col-sm-10">
                                        <input type="text" required name="email" class="form-control" 
                                               placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Select User Type</label>
                                    <div class="col-sm-10">
                                        <select name="type" required class="form-control">
                                            <option value="">Type</option>
                                            <option value="M">Manager</option>
                                            <option value="R">Record Keeper</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Password:</label>
                                    <div class="col-sm-10">
                                        <input type="password" required name="password" class="form-control"  placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Confirm Password:</label>
                                    <div class="col-sm-10">
                                        <input type="password" required name="password2" class="form-control"  placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered">
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Action</th>
                  <tbody>
                    <?php while ($data = mysqli_fetch_object($query)) { ?>
                          <tr>
                              <td><?php echo $data->name?></td>
                              <td><?php echo $data->email?></td>
                              <td><?php echo $data->type?></td>
                              <td><a @click.prevent="deleteUser" href="" data-id="<?php echo $data->id?>">Delete</a> </td>
                          </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
        </section>
        <!-- /.content -->
    </aside>
    <!-- /.right-side -->
    <footer class="pull-right">
        Ogbu Chinazom Elvis { 14/3326 } | Peace Ojehanon { 14/3377 }
    </footer>
</div>
<!-- /.right-side -->
<!-- ./wrapper -->
<!-- global js -->
<script src="js/app.js" type="text/javascript"></script>
<script src="js/dss/vue.js" type="text/javascript"></script>
<script src="js/dss/axios.min.js" type="text/javascript"></script>
<script src="js/dss/app.js" type="text/javascript"></script>
</body>

</html>
