<?php 
 
      //$response=new Dao_Carte();
      $username = $_SESSION['user']['username'];
      $pos = $response->getPOSByUsername($username);
      $total_pos = $response->todayTotalSalesPOS($pos);


$total_order = $response->countSalesPOS($pos);
$total_qt = $response->totalSalesQuantityPOS($pos);

      $total=$response->countAllCommande();


	  $today = $response->countTodaySalesPOS($pos);
      $today_qt =  $response->todaySalesQtePOS($pos);
	  $thismonth = $response->countThisMonthSalesPOS($pos);
      $thismonth_qt = $response->countThisMonthSalesQtePOS($pos);

$thisweek = $response->countThisWeekSalesPOS($pos);
$thisweek_qt = $response->countThisWeekSalesQtePOS($pos);
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
    $arr_dt[$count] = $response->getQuantityProduitCommandePOS($item['id_product'],$pos);
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
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>POS - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    
      <!-- Divider -->
      
      <!-- Nav Item - Dashboard -->
      
      <!-- Divider -->
      
      <!-- Heading -->
      

      <!-- Nav Item - Pages Collapse Menu -->
   
            <!-- Nav Item - Alerts -->
       
            <!-- Nav Item - Messages -->
 
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          -->
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total order</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_order; ?></div>
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Articles</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_qt; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Orders today</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $today; ?></div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Articles</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $today_qt; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Orders this month</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $thismonth; ?></div>
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Articles</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $thismonth_qt; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Orders this week</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $thisweek; ?></div>
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Articles</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $thisweek_qt; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="row">

            <!-- Area Chart -->
            <div class="col-12">
              <div class="card shadow mb-4 white">
                <!-- Card Header - Dropdown -->
                
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Produits vendus</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped display nowrap " id="dataTable" width="100%" cellspacing="0">
                      <thead>
                      <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix total</th>
                        <th>Client</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      //var_dump($row);
                      if($products)
                      {
                        $count=0;
                        foreach($products as $item)
                        {
                          $count++;
                          ?>
                          <tr>
                            <td><?php
                              $p = $response->getOneProductById($item['id_product']);
                              echo $p['designation'];
                              ?></td>
                            <td><?php echo $p = $response->getQuantityProduitCommandePOS($item['id_product'],$pos); ?></td>
                            <td><?php
                              $rate = $response->getRate();
                              $t = $response->totalPriceSalesByProductPOS($item['id_product'],$pos);
                              echo $t;
                              ?></td>
                              <td><?php
                              $p = $response->getOneProductById($item['id_product']);
                              echo $p['designation'];
                              ?></td>


                          </tr>

                        <?php }}?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix total</th>
                        <th>Client</th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>


                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          

          <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      
      <!-- End of Footer -->

    
    <!-- End of Content Wrapper -->

  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->

  
  