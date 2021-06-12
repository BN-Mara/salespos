<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$vente_txt = "";
if(isset($_GET['when'])){
    $when = $_GET['when'];
    if($when == 'today'){
        $row=$response->todayCommande();
        $vente_txt = "Ventes d'aujourd'hui";
        $total = $response->todayTotalCommande();
        $quantity = $response->todayProduitCommande();

    }
    if($when == 'thismonth'){
        $row=$response->thisMonthCommande();
        $vente_txt = "Ventes de ce Mois";
        $total = $response->thisMonthTotalCommande();
        $quantity = $response->thisMonthProduitCommande();

    }
    if($when == 'thisweek'){
        $row=$response->thisWeekCommande();
        $vente_txt = "Ventes de cette semaine";
        $total = $response->thisWeekTotalCommande();
        $quantity = $response->thisWeekTotalCommande();
    }

}else{
    $row=$response->getAllOrder();
    $vente_txt = "Toutes les ventes";
    $total = $response->thisYearTotalCommande();
    $quantity = $response->thisYearProduitCommande();
}


?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $vente_txt; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tous les produits</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
           </div>
        <!-- /.box-header -->
        <?php
        if(isset($_SESSION['info'])){
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $_SESSION['info'];
                unset( $_SESSION['info']);
                ?> .
            </div>

            <?php
        }
        ?>
        <!-- form start -->

        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>POS NAME</th>
                    <?php 
                    for($z=1;$z<32;$z++){
                        ?>
                    <th><?php echo $z; ?></th>


                    <?php 

                    }
                    
                    ?>
                <th></th>
                </tr>

                </thead>
                <tbody>
                <tr><td colspan="31">SALES REPORT</td><td>TOTAL</td></tr>
                <tr><td>Item</td>
                <?php 
                    for($z=1;$z<32;$z++){
                        ?>
                    <td><div class="row"><div class="col-xs-6">Qte</div><div class="col-xs-6">CDF</div></div></td>


                    <?php 

                    }
                    
                    ?>
                <td><div class="row"><div class="col-xs-6">Qte</div><div class="col-xs-6">CDF</div></div></td>
                
                
                </tr>
                <?php
                //var_dump($row);
                $prods = $response->getAll();
                if($prods){
                    foreach($prods as $prod){
                        ?>
                        <tr>
                        <td><?php echo $prod['designation']; ?></td>
                        
                        <?php 
                    for($z=1;$z<32;$z++){
                        ?>
                    <td><div class="row"><div class="col-xs-6">2</div><div class="col-xs-6">1000</div></div></td>


                    <?php 

                    }
                    
                    ?>
                    <td><div class="row"><div class="col-xs-6">2</div><div class="col-xs-6">2000</div></div></td>
                        </tr>

                        <?php
                    }
                }

                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>POS NAME</th>
                    <?php 
                    for($z=1;$z<32;$z++){
                        ?>
                    <th><?php echo $z; ?></th>


                    <?php 

                    }
                    
                    ?>
                <th></th>
                </tr>

                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
