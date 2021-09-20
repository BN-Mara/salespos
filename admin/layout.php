<?php

session_start();
include "user/session.php";
include_once '../models/Dao_Carte.php';
$response=new Dao_Carte();

$count_plainte0 = !$response->countPlainteByStatus(0) ? $response->countPlainteByStatus(0) : 0  ;
$loginCount = 0;
if(isset($_SESSION['current_user']))
$loginCount = $response->checkFirstLogin($_SESSION['current_user']);
?>
<?php 
 
 //$response=new Dao_Carte();
 $total=$response->countAllCommande();
$today = $response->countTodayCommande();
$thismonth = $response->countThisMonthCommande();
$thisyear = $response->countThisWeekCommande();
//port d'entree
 //$prov = $response->getProvenance();
$products = $response->getAll();
$arr_label = array();
$arr_dt = array();
if($products){
$count = 0;
foreach($products as $item){
$arr_label[$count] = $item['designation'];
$arr_dt[$count] = $response->getQuantityProduitCommande($item['id_product']);
if($arr_dt[$count] == null)
 $arr_dt[$count]=0;

$count++;

}
// var_dump($arr_dt);
}

//mois de l'annee courrante
$month = array();
for($i=0; $i<12; $i++){
 $month[$i]=$response->countThisYearMonthCommande($i+1);
}




?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AFRICELL | SALESPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link href="bower_components/datatables.net-bs/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="bower_components/datatables.net-bs/css/buttons.dataTables.min.css" rel="stylesheet">
    <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>

</style>
<script src="bower_components/jquery/dist/jquery.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" >  

  <header class="main-header" style="background-color:#A01775">
    <!-- Logo -->
    <a href="layout.php?page=dashboard" class="logo" style="background-color:#A01775;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="dist/img/wlogo.png"  width="50" alt="logo"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="dist/img/wlogo.png"  width="100" alt="logo"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top"  style="background-color:#A01775;">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
	 
      <div class="navbar-custom-menu">
	  
        <ul class="nav navbar-nav">

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">
			   <?php echo $count_plainte0 ?>
			  </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                Plaintes non resolues

			  </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php
                  $allplaintes0 = $response->getPlainteByStatus(0);
                  if($allplaintes0){
                    foreach($allplaintes0 as $item){

                  ?>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i>
                          <?php echo $item['nom'];?>
                        </a>
                      </li>

                      <?php
                    }
                  }
                  ?>



                </ul>
              </li>
              <li class="footer"><a href="layout.php?page=plaintes">Voir tout</a></li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/avatar_man.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php if(isset($_SESSION['current_user'])){echo $_SESSION['current_user'];}?></span>
            </a>
            <ul class="dropdown-menu" >
              <!-- User image -->
              <li class="user-header"  style="background-color:#A01775">
                <img src="dist/img/avatar_man.png" class="img-circle" alt="User Image">

                <p>
                  <?php if(isset($_SESSION['current_user'])){echo $_SESSION['current_user'];} ?>
                  <small><?php if(isset($_SESSION['current_user'])){echo $_SESSION['current_user_role'];} ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <!--<div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="layout.php?page=userProfile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">DECONNEXION</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background-color:#A01775">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" >
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/avatar_man.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php if(isset($_SESSION['current_user'])){echo $_SESSION['current_user'];} ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> En ligne</a>
        </div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <!-- <input type="text" name="q" class="form-control" placeholder="Search..."> -->
      <!-- <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
    </div>
  </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree"  >
        <li class="header" style="background-color:white">MENU</li>
        <li>
          <a href="layout.php?page=dashboard">
            <i class="fa fa-dashboard"></i> <span>Tableau de board</span>
            <!-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>-->
          </a>
          <!-- <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>-->
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Produits</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="layout.php?page=ajoutProduit"><i class="fa fa-edit"></i>Ajouter</a></li>
            <li><a href="layout.php?page=produits"><i class="fa fa-book"></i> Catalogue</a></li>
            <li><a href="layout.php?page=rate"><i class="fa fa-book"></i> Rate</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Stock</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="layout.php?page=stock"><i class="fa fa-book"></i>Stock</a></li>
            <li><a href="layout.php?page=addStock"><i class="fa fa-book"></i> Ajouter Stock</a></li>
            <li><a href="layout.php?page=imeis"><i class="fa fa-book"></i>IMEI</a></li>
            <!--<li><a href="layout.php?page=addImei"><i class="fa fa-book"></i> Ajouter IMEI</a></li>-->
            <li><a href="layout.php?page=iccids"><i class="fa fa-book"></i>ICCID</a></li>
            <li><a href="layout.php?page=serials"><i class="fa fa-book"></i>Serials</a></li>
            <!--<li><a href="layout.php?page=addIccid"><i class="fa fa-book"></i> Ajouter ICCID</a></li>-->
            <li><a href="layout.php?page=stockTransfer"><i class="fa fa-book"></i>Stock Transfert</a></li>

          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>POS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="layout.php?page=pos"><i class="fa fa-book"></i>Tous les POS</a></li>
            <li><a href="layout.php?page=addPos"><i class="fa fa-book"></i> Ajouter POS</a></li>

          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Utilisateur</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="layout.php?page=addUser"><i class="fa fa-edit"></i> Ajouter Utilisateur</a></li>
            <li><a href="layout.php?page=users"><i class="fa fa-book"></i>Les utilisateurs</a></li>
			      <li><a href="layout.php?page=logins"><i class="fa fa-book"></i>Les connexions</a></li>
            
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Ventes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="layout.php?page=productSale"><i class="fa fa-book"></i> VENTES POS</a></li>
            <!--<li><a href="layout.php?page=orders&when=today"><i class="fa fa-book"></i> AUJOURD'HUI</a></li>
            <li><a href="layout.php?page=orders&when=thisweek"><i class="fa fa-book"></i> CETTE SEMAINE</a></li>
            <li><a href="layout.php?page=orders&when=thismonth"><i class="fa fa-book"></i> CE MOIS</a></li>-->
            <li><a href="layout.php?page=productSale"><i class="fa fa-book"></i> PRODUITS VENDUS </a></li>

          </ul>
        </li>
        <!--  <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Departement</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="layout.php?page=ajoutDepart"><i class="fa fa-circle-o"></i> Ajouter departement </a></li>
              <li><a href="layout.php?page=listeDepart"><i class="fa fa-circle-o"></i> Liste </a></li>

            </ul>
          </li>-->
          <li class="treeview">
            <a href="layout.php?page=clients">
              <i class="fa fa-edit"></i> <span>Client</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="layout.php?page=clients"><i class="fa fa-circle-o"></i> Tous les clients</a></li>

            </ul>
          </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Plaintes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="layout.php?page=plaintes"><i class="fa fa-circle-o"></i> Toutes Les plaintes</a></li>

          </ul>
        </li>

        </ul>
      </section>
      <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- /.content -->
		<?php
    $username = "";

    if($loginCount >= 1){
      if(isset($_SESSION['current_user']))
        $username = $_SESSION['current_user'];
        
        $dao = new Dao_Carte();

	if(isset($_GET['page'])){
		$page = $_GET['page'];
      $check_user_page = $dao->checkPagesByUsername($username,$page);
      if($page != "userProfile"){
        if($check_user_page){
          include "pages/".$page.".php";
        }else
         include "pages/notallowed.php";

      }else{
        include "pages/".$page.".php";
      }
   
	
	
	}else{

      $page = "dashboard";

      $check_user_page = $dao->checkPagesByUsername($username,$page);
      if($check_user_page){
        include "pages/dashboard.php";
      }else
        include "pages/notallowed.php";
	}

  }else{
    $_SESSION['info_error']="Modifier votre mot de passe svp!";
    include "pages/userProfile.php";
  }
    
	?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
     <!-- <b>Version</b> 2.4.1-->
    </div>
    <strong>Africell &copy; 2020</strong>
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net-bs/js/jquery.dataTables.min.js"></script>


  <!-- Page level custom scripts -->
  <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>

  <script src="bower_components/datatables.net-bs/js/jszip.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/vfs_fonts.js"></script>
  <script src="bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/buttons.print.min.js"></script>
<!-- ChartJS -->
<script src="bower_components/chart.js/Chart.js"></script>
<!-- FLOT CHARTS -->
<script src="bower_components/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="bower_components/Flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="bower_components/Flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="bower_components/Flot/jquery.flot.categories.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script>
 //$('#test').hide('fast');
 
    $('#example2').DataTable({
      dom: 'Blfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
    });
</script>
<script>
  function departChange()
  {

    var departement = document.getElementById("utilisateur");
    var selectedDepart = departement.options[departement.selectedIndex].value;

    jQuery.ajax({
      type: 'post',
      data: {dep_id: selectedDepart},
      success: function(response){
        // Code
        alert("hello");
      }
    });
  }


</script>
<script>
  $(function () {
    /*
     * Flot Interactive Chart
     * -----------------------
     */
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    /* var data = [], totalPoints = 100

    function getRandomData() {

      if (data.length > 0)
        data = data.slice(1)

      // Do a random walk
      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
            y    = prev + Math.random() * 10 - 5

        if (y < 0) {
          y = 0
        } else if (y > 100) {
          y = 100
        }

        data.push(y)
      }

      // Zip the generated y values with the x values
      var res = []
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]])
      }

      return res
    }

    var interactive_plot = $.plot('#interactive', [getRandomData()], {
      grid  : {
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color     : '#3c8dbc'
      },
      lines : {
        fill : true, //Converts the line chart to area chart
        color: '#3c8dbc'
      },
      yaxis : {
        min : 0,
        max : 100,
        show: true
      },
      xaxis : {
        show: true
      }
    })

    var updateInterval = 500 //Fetch data ever x milliseconds
    var realtime       = 'on' //If == to on then fetch data every x seconds. else stop fetching
    function update() {

      interactive_plot.setData([getRandomData()])

      // Since the axes don't change, we don't need to call plot.setupGrid()
      interactive_plot.draw()
      if (realtime === 'on')
        setTimeout(update, updateInterval)
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === 'on') {
      update()
    }
    //REALTIME TOGGLE
    $('#realtime .btn').click(function () {
      if ($(this).data('toggle') === 'on') {
        realtime = 'on'
      }
      else {
        realtime = 'off'
      }
      update()
    }) */
    /*
     * END INTERACTIVE CHART
     */

    /*
     * LINE CHART
     * ----------
     */
    //LINE randomly generated data

   /*  var sin = [], cos = []
    for (var i = 0; i < 14; i += 0.5) {
      sin.push([i, Math.sin(i)])
      cos.push([i, Math.cos(i)])
    }
    var line_data1 = {
      data : sin,
      color: '#3c8dbc'
    }
    var line_data2 = {
      data : cos,
      color: '#00c0ef'
    }
    $.plot('#line-chart', [line_data1, line_data2], {
      grid  : {
        hoverable  : true,
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: ['#3c8dbc', '#f56954']
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
    $('#line-chart').bind('plothover', function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
          .css({ top: item.pageY + 5, left: item.pageX + 5 })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }

    }) */
    /* END LINE CHART */

    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */
    /* var areaData = [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6],
      [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9],
      [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]]
    $.plot('#area-chart', [areaData], {
      grid  : {
        borderWidth: 0
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color     : '#00c0ef'
      },
      lines : {
        fill: true //Converts the line chart to area chart
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    })
 */
    /* END AREA CHART */

    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data : [['Jan.', <?php echo $month[0]; ?>], ['Fev.', <?php echo $month[1]; ?>], ['Mar.', <?php echo $month[2]; ?>], 
	  ['Avr.', <?php echo $month[3]; ?>], ['Mai', <?php echo $month[4]; ?>], ['Jui', <?php echo $month[5]; ?>],
	  ['Jui.', <?php echo $month[6]; ?>], ['Aou.', <?php echo $month[7]; ?>], ['Sep.', <?php echo $month[8]; ?>], 
	  ['Oct.', <?php echo $month[9]; ?>], ['Nov.', <?php echo $month[10]; ?>], ['Dec.', <?php echo $month[11]; ?>]],
      color: '#3c8dbc'
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
        bars: {
          show    : true,
          barWidth: 0.5,
          align   : 'center'
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 0
      }
    })
    /* END BAR CHART */

    /*
     * DONUT CHART
     * -----------
     */

    var lbl = '<?php echo "DRH"; ?>';
    var donutData=[];
    var col = 0;
    <?php
    $i = 0;
     foreach($arr_label as $lb){
     ?>
    col++;
    //alert("ello");
    donutData.push(
        {
          label:'<?php echo $lb; ?>',
          data:<?php echo $arr_dt[$i]; ?>,
          color: random_rgba()
        }
    );


    <?php
    $i++;
     }

     ?>
   
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: true
      }
    })
    /*
     * END DONUT CHART
     */

  })

  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieChart       = new Chart(pieChartCanvas)
  var PieData=[];
  var col = 0;
  <?php
  $i = 0;
   foreach($arr_label as $lb){
   ?>
  col++;
  //alert("ello");
  PieData.push(
      {
        value:<?php echo $arr_dt[$i]; ?>,
        color: random_rgba(),
        highlight: random_rgba(),
        label:'<?php echo $lb; ?>'
      }
  );


  <?php
  $i++;
   }

   ?>
 /* var PieData        = [
    {
      value    : 700,
      color    : '#f56954',
      highlight: '#f56954',
      label    : 'Chrome'
    },
    {
      value    : 500,
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'IE'
    },
    {
      value    : 400,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'FireFox'
    },
    {
      value    : 600,
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'Safari'
    },
    {
      value    : 300,
      color    : '#3c8dbc',
      highlight: '#3c8dbc',
      label    : 'Opera'
    },
    {
      value    : 100,
      color    : '#d2d6de',
      highlight: '#d2d6de',
      label    : 'Navigator'
    }
  ]*/
  var pieOptions     = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    //String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    //Number - The width of each segment stroke
    segmentStrokeWidth   : 2,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps       : 100,
    //String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : true,
    //String - A legend template
    legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions)

  //-------------

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
  function random_rgba(){
    var o = Math.round, r=Math.random, s=255;
    return'rgba('+o(r()*s)+','+o(r()*s)+','+r().toFixed(1)+')';
  }
</script>
<script>
  $(function () {
     $('.select2').select2();
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
</body>
</html>
