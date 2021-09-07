<?php

session_start();

if(!isset($_SESSION['user'])){
    //check username and password then set to session
    header("location:login.php");
    exit;

}

include_once '../models/Dao_Carte.php';
require_once("../models/Client.php");
require_once("../helper/Format.php");


$response=new Dao_Carte();
$username = $_SESSION['user']['username'];
$pos = $response->getPOSByUsername($username);
$produits = $response->getPOSProducts($pos);
$showing = "Produits";
$clients = $response->getAllCustomer();
$taux = $response->getRate();
$loginCount = $response->checkFirstLogin($_SESSION['user']['username']);
$pages="sales.php&saletype=phone";
if(isset($_GET['page'])){
    $page = $_GET['page'];
    if($page == "sales"){
        if(isset($_GET['saletype'])){
            switch($_GET['saletype']){
                case "phone":
                    $produits = $response->getAllByType(1);
                    $showing = "Téléphones";
                    break;
                case "modem":
                    $produits = $response->getAllByType(2);
                    $showing = "Modems";
                    break;
                case "balance":
                    $showing = "balance";
                    $page = "balance";

                default:
                    $produits = $response->getAll();
                    $showing = "all";
                    break;
            }
        }
    }
}

if(isset($_POST['search'])){
    $produits = $response->getAllBySearch($_POST['search_str']);
    $showing = "Résultat de votre recherche";
}
//var_dump($_SESSION);

$total_quantity = 0;
$total_price = 0;
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;

    foreach ($_SESSION["cart_item"] as $item){
        //$item_price = $item["quantity"]*$item["price"];
        $total_quantity += $item["quantity"];
        $total_price += ($item["price"]*$item["quantity"]);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Africell::SalesPOS</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/w3.css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/jquery.dataTables.min.css" rel="stylesheet">
    <link href="vendor/datatables/buttons.dataTables.min.css" rel="stylesheet">
    <script type="text/javascript" charset="utf8" src="js/jquery-3.5.1.min.js"></script>
    
    <style>

        /* Mark input boxes that gets an error on validation: */

        /* Hide all steps by default: */
        .tab {
            display: none;
        }


        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #4CAF50;
        }
        input.invalid {
            background-color: #ffdddd;
        }
        .bg-sidebar{
          background-color: #A01775;
        }
    </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <img src="images/wlogo.png" width="100">
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Sales</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>

              <!--<a class="collapse-item" href="index.php?page=sim">SIM</a>-->
              <a class="collapse-item" href="index.php?page=sales">Add Sale</a>
              <a class="collapse-item" href="index.php?page=exchange">Exchange</a>
              <a class="collapse-item" href="index.php?page=orders">All Sales</a>
              
            </div>
          </div>
        </li>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Plainte</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="index.php?page=plainte">Ajouter plainte</a>
                    <a class="collapse-item" href="index.php?page=plaintes">Les plaintes</a>

                </div>
            </div>
        </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Stock</span>
            </a>
            <div id="collapseStock" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Stock:</h6>
                    <a class="collapse-item" href="index.php?page=mystock">mon stock</a>
                    <a class="collapse-item" href="index.php?page=stockTransfert">Transferer stock</a>
                    <a class="collapse-item" href="index.php?page=transfers">Mes transferts</a>

                </div>
            </div>
        </li>

      <!-- Heading -->
    

      <!-- Nav Item - Pages Collapse Menu -->
      

      <!-- Nav Item - Charts -->
      
      <!-- Nav Item - Tables -->
      

      <!-- Divider -->
      

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
        

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
          

            <!-- Nav Item - Alerts -->
            
            <!-- Nav Item - Messages -->
            

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user']['names']; ?></span>
                <img class="img-profile rounded-circle" src="images/avatar_man.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="index.php?page=profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <!--<a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>-->
                <!--<a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>-->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
		
		
		<div id="register" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('register').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <b>Nouveau client</b>
            </div>

            <form class="w3-container" method="post" action="cart.php">
                <div class="w3-section">
                    <label><b>Nom</b></label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round " type="text" placeholder="Nom" name="noms" required>
                    <label><b>Prénom</b></label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round" type="text" placeholder="Prénom" name="prenom" required>
                    <label><b>Post-nom</b></label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round" type="text" placeholder="Post-nom" name="postnom" required>
                    <label><b>Adresse</b></label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round" type="text" placeholder="adresse du client" name="address">
                    <label><b>Tel</b></label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round" type="text" placeholder="Numero e telephone" name="tel">
                    <label><b>Piece d'itentité</b></label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round" type="text" placeholder="Numero de la carte" name="idcard">
                    <input class="w3-button w3-block w3-green w3-section w3-padding w3-round" type="submit" name="new_cust_pl" value="AJOUTER">

                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('register').style.display='none'" type="button" class="w3-button w3-red w3-round">Annuler</button>
            </div>

        </div>

    </div>
    <div class="w3-container">
    <?php
    if(isset($_SESSION['info_success'])){
        ?>
        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php
            echo $_SESSION['info_success'];

            ?>
        </div>

        <?php
        unset($_SESSION['info_success']);
    }

    ?>

    <?php
    if(isset($_SESSION['info'])){
        ?>
        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation-triangle"></i> Alert!</h4><?php
            echo $_SESSION['info'];

            ?>
        </div>

        <?php
        unset($_SESSION['info']);
    }

    ?>
    </div>
    <?php
    if($loginCount >= 1){
      if(isset($_GET['page'])){
        include $page.'.php';
    }else{
        include "dashboard.php";
    }
    }else{
      $_SESSION['info'] = "Modifier votre mot de passe svp!";
      include "profile.php";
    }
    

    ?>
    <p></p>


          
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Africell 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
  <!-- Page level plugins -->
  <script src="js/jquery.dataTables.min.js"></script>


  <!-- Page level custom scripts -->
  <script type="text/javascript" charset="utf8" src="vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/jszip.min.js"></script>
  <script src="js/pdfmake.min.js"></script>
  <script src="js/vfs_fonts.js"></script>
  <script src="js/buttons.html5.min.js"></script>
  <script src="js/buttons.print.min.js"></script>
  <script>


    </script>
  

</body>

</html>
