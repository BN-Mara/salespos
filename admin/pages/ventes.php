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
            <select id="pos_filter">
            <option>--</option>
                <?php
                $poses = $response->getAllPOS();
                foreach($poses as $pos){
                    ?>
                   <option value="<?php echo $item['id_pos']; ?>">
                   <?php echo $item['designation']; ?>
                   </option>
                    <?php
                }

                ?>

            </select>
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
                    <th>ID</th>
                    <th>ID Client</th>
                    <th>ID Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Prix Total</th>
                    <th>Date de vente</th>
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
                            <td><?php echo $item['id_ref']; ?></td>
                            <td><?php
                                $c = $response->getOneClientById($item['id_client']);
                                echo $c['firstname'];
                                ?></td>
                            <td><?php
                                $p = $response->getOneProduitById($item['id_product']);
                                echo $p[0]['designation'];
                                ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$ <?php echo $item['unit_price']; ?></td>
                            <td>$ <?php echo $item['total_price']; ?></td>
                            <td><?php echo $item['creation_date']; ?></td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>ID Client</th>
                    <th>ID Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Prix Total</th>
                    <th>Date de vente</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
