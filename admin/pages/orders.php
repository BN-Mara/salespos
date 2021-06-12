<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$vente_txt = "";
if(isset($_GET['when'])){
    $when = $_GET['when'];
    if($when == 'today'){
        $row=$response->todaySales();
        $vente_txt = "Ventes d'aujourd'hui";
        $total = $response->todayTotalPriceSales();
        $quantity = $response->todaySalesQte();

    }
    if($when == 'thismonth'){
        $row=$response->thisMonthSales();
        $vente_txt = "Ventes de ce Mois";
        $total = $response->thisMonthTotalPriceSales();
        $quantity = $response->thisMonthSalesQte();

    }
    if($when == 'thisweek'){
        $row=$response->thisWeekSales();
        $vente_txt = "Ventes de cette semaine";
        $total = $response->thisWeekTotalPriceSales();
        $quantity = $response->thisWeekSalesQte();
    }

}else{
    $row=$response->getAllSaleReference();
    $vente_txt = "Toutes les ventes";
    $total = $response->totalPriceSales();
    $quantity = $response->totalSalesQuantity();
}


?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $vente_txt; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Toutes les comandes</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Motant Total: <?php echo $total; ?> CDF</h3>  <h3 class="box-title"> | Quantité: <?php echo $quantity; ?> Articles commandés</h3>
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
                    <th>Reference</th>
                    <th>ID Client</th>
                    <th>Nbre d'article</th>
                    <th>Total payé</th>
                    <th>POS</th>
                    <th>Date</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
                <?php
                //var_dump($row);
                if($row)
                {
                    $count=0;
                    foreach($row as $item)
                    {
                        $count++;
                        ?>
                        <tr>
                            <td><?php echo $item['reference']; ?></td>
                            <td><?php
                                $c = $response->getOneClientById($item['id_client']);
                                echo $c['firstname'];
                                ?></td>
                            <td><?php echo $item['nbre_article']; ?></td>
                            <td> <?php echo $item['total_price']; ?> CDF</td>
                            <td><?php
                                $posid = $response->getPOSByUsername($item['addedBy']);
                                $pos = $response->getOnePOSById($posid);
                                echo $pos['designation'];
                                ?></td>
                            <td><?php echo $item['creation_date']; ?></td>
                            <td><!--<a href="orderdetails.php?&id=<?php //echo $item['id_ref']; ?>">detail</a>--></td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Reference</th>
                    <th>ID Client</th>
                    <th>Nbre d'article</th>
                    <th>Total payé</th>
                    <th>POS</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
