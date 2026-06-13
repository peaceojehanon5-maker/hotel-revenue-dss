<?php include "core/controller.php"; ?>
<?php

if($_SESSION['userData']['type'] != 'M')
    header('Location: logout.php' )

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
    <link href="css/custom_css/chartjs-charts.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .prc {
            font-weight: bold;
        }
    </style>

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
                        <a href="home.php">
                            <i class="menu-icon fa fa-fw fa-home"></i>
                            <span class="mm-text ">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="menu-icon fa fa-fw fa-home"></i>
                            <span class="mm-text ">Logout</span>
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
            <h1>
                <!-- Chartjs Charts -->
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="">
                        <i class="fa fa-fw fa-home"></i> Dashboard
                    </a>
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-bar-chart-o"></i> Bar Chart showing Rooms and number of bookings for year <span id="dyear"></span>
                            </h4>
                            
                        </div>
                        <div class="panel-top">
                            <span class="pull-right">
                                <form action="">
                                    <select id="bar-year" class="form-control">
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                    </select>
                                </form>
                            </span>
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="bar-chart" width="800" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-area-chart"></i> Decision Suggestion
                            </h4>
                            <span class="pull-right">
                                <!-- <i class="fa fa-fw fa-chevron-up clickable"></i>
                                <i class="fa fa-fw fa-times removepanel clickable"></i> -->
                            </span>
                        </div>
                        <div class="panel-body">
                            <div>
                                <h4>Price Each Room should go for:</h4>
                                <p>Total Number of times <strong>Executive</strong>  was booked: <span id="exec"></span></p>
                                <h5>Price: <span id="ex-price"></span></h5>
                                <p>Total Number of times <strong>Regular</strong>  was booked: <span id="reg"></span></p>
                                <h5>Price: <span id="rg-price"></span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-line-chart"></i> Expenses vs Revenue Analysis
                            </h4>
                        </div>
                        <div class="panel-top">
                            <span class="pull-right">
                                <form action="">
                                    <select id="line-year" class="form-control">
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                    </select>
                                </form>
                            </span>
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="line-chart" width="800" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-bar-chart-o"></i> Decision (Layoff or Not)
                            </h4>
                            <span class="pull-right">
                                <!-- <i class="fa fa-fw fa-chevron-up clickable"></i>
                                <i class="fa fa-fw fa-times removepanel clickable"></i>
                            </span> -->
                        </div>
                        <div class="panel-body">
                            <div>
                                <p>January: <span id="Jan"></span></p>
                                <p>February: <span id="Feb"></span></p>
                                <p>March: <span id="Mar"></span></p>
                                <p>April: <span id="Apr"></span></p>
                                <p>May: <span id="May"></span></p>
                                <p>June: <span id="Jun"></span></p>
                                <p>July: <span id="Jul"></span></p>
                                <p>August: <span id="Aug"></span></p>
                                <p>September: <span id="Sep"></span></p>
                                <p>October: <span id="Oct"></span></p>
                                <p>November: <span id="Nov"></span></p>
                                <p>December: <span id="Dec"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-pie-chart"></i> Staffs, Salaries and Number of times they had Issues.
                            </h4>
                            <span class="pull-right">
                               <!--  <i class="fa fa-fw fa-chevron-up clickable"></i>
                                <i class="fa fa-fw fa-times removepanel clickable"></i> -->
                            </span>
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="pie-chart" width="800" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-pie-chart"></i> Decision
                            </h4>
                            <!-- <span class="pull-right"> -->
                                <!-- <i class="fa fa-fw fa-chevron-up clickable"></i>
                                <i class="fa fa-fw fa-times removepanel clickable"></i>
                            </span> -->
                        </div>
                        <div class="panel-body">
                            <div  id="staff-dec" class="panel-body">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-line-chart"></i> Maintenance Trend
                            </h4>
                        </div>
                        <div class="panel-top">
                            <span class="pull-right">
                                <form action="">
                                    <select id="line2-year" class="form-control">
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                    </select>
                                </form>
                            </span>
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="line-chart2" width="800" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Basic charts strats here-->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-fw fa-bar-chart-o"></i> Decision (Amount)
                            </h4>
                            <span class="pull-right">
                                <!-- <i class="fa fa-fw fa-chevron-up clickable"></i>
                                <i class="fa fa-fw fa-times removepanel clickable"></i>
                            </span> -->
                        </div>
                        <div class="panel-body">
                            <div>
                                <p>January: <span class="prc" id="jan"></span></p>
                                <p>February: <span class="prc" id="feb"></span></p>
                                <p>March: <span class="prc" id="mar"></span></p>
                                <p>April: <span class="prc" id="apr"></span></p>
                                <p>May: <span class="prc" id="may"></span></p>
                                <p>June: <span class="prc" id="jun"></span></p>
                                <p>July: <span class="prc" id="jul"></span></p>
                                <p>August: <span class="prc" id="aug"></span></p>
                                <p>September: <span class="prc" id="sep"></span></p>
                                <p>October: <span class="prc" id="oct"></span></p>
                                <p>November: <span class="prc" id="nov"></span></p>
                                <p>December: <span class="prc" id="dec"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
<script src="vendors/chartjs/js/Chart.js"></script>
<script src="js/dss/axios.min.js" ></script>
<script src="js/dss/chart.js" ></script>
<!-- <script type="text/javascript" src="js/custom_js/chartjs-charts.js"></script> -->
</body>

</html>
