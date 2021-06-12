<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$row=$response->getAllCustomer();

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tous les Produits

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tous les produits</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Produits</h3>
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
                    <th>Noms</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
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
                            <td><?php echo $item['id_client']; ?></td>
                            <td><?php echo $item['lastname'].' '.$item['midlename'].' '.$item['firstname']; ?></td>
                            <td><?php echo $item['address']; ?></td>
                            <td><?php echo $item['phone']; ?></td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Noms</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
