<?php include "core/controller.php"; ?>
<?php

$sql = "SELECT * FROM staffs";
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
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <?php include "inc_sidenav.php";?>
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
                                <i class="fa fa-fw fa-crosshairs"></i> Staff Issues
                            </h3>
                            <span class="pull-right">
                                <!-- <i class="fa fa-fw fa-chevron-up clickable"></i> -->
                                <!-- <i class="fa fa-fw fa-times removepanel clickable"></i> -->
                            </span>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" action="core/controller.php" id="ish-form" role="form">
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Details:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" required name="ish-details" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Select Staff</label>
                                    <div class="col-sm-10">
                                        <select name="ish-name" required class="form-control">
                                            <option value=""></option>
                                            <?php while($data = mysqli_fetch_object($query)) {?>
                    <option value="<?php echo $data->id?>"> <?php echo $data->name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">Date:</label>
                                    <div class="col-sm-10">
                                        <input type="date" required name="ish-date" class="form-control" id="input-text" placeholder="Price">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                    
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
<script>
    $('#ish-form').on('submit', function(){
        var that = $(this), 
            url  = that.attr('action'),
            method = that.attr('method'),
            data = {};

            that.find('[name]').each(function (index, value) {
                var that = $(this),
                name = that.attr('name'),
                value = that.val();

                data[name] = value;
            });
            console.log(data);

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response){
                    console.log(response);
                    $('#ish-form').trigger('reset')
                    alert("Submitted Sucessfully")
                }
            })
        return false;
    })
</script>
</body>

</html>
