<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();

if(isset($_GET['delete'])){
    $response->deleteOneProduct($_GET['delete'] , $_SESSION['current_user']);
    
}
$row=$response->getAll();
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
                    <th>Code</th>
                    <th>Designation</th>
                    <th>Prix</th>
                    <th>date Ajouter</th>
                    <th>Ajouter Par</th>
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
                            <td><?php echo $item['code']; ?></td>
                            <td><?php echo $item['designation']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['creation_date']; ?></td>
                            <td><?php echo $item['addedBy']; ?></td>
                            <td><a href="layout.php?page=editProduit&id=<?php echo $item['id_product']; ?>">Modifier</a><br>
                                <a href="layout.php?page=produits&delete=<?php echo $item['id_product']; ?>">Supprimer</a></td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Code</th>
                    <th>Designation</th>
                    <th>Prix</th>
                    <th>date Ajouter</th>
                    <th>Ajouter Par</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
