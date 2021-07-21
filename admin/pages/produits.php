<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$chkPg = $response->checkPagesByUsername($_SESSION['current_user'], "deleteProduct");
if($chkPg){
    if(isset($_GET['delete'])){
        $response->deleteOneProduct($_GET['delete'] , $_SESSION['current_user']);
        
    }
}else{
    $_SESSION['info'] = "Vous n\'etes pas autorise pour cette tache!";
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
           <!-- <form method="post" action="../controllers/ProduitController.php" enctype="multipart/form-data">
            <table class="pull-right">
                <tr>
                    <td>
                    <input  type="file" name="csv" id="csv" accept=".csv" onChange="validateAndUpload(this);" >
                    </td>
                    <td>
                    <button class="btn btn-secondary " type="submit" name="uploadcsv" id="uploadcsv" disabled>Import</button>
                    </td>
                </tr>
            </table>
        </form>-->
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
                            <td>
                                <?php
                                if($response->checkPagesByUsername($_SESSION['current_user'], "editProduit")){
                                    ?>
                                    <a href="layout.php?page=editProduit&id=<?php  echo $item['id_product']; ?>">Modifier</a><br>
                                    <?php
                                }
                                ?>
                                <?php
                                if($response->checkPagesByUsername($_SESSION['current_user'], "deleteProduct")){
                                    ?>
                                    <a href="layout.php?page=produits&delete=<?php echo $item['id_product']; ?>">Supprimer</a></td>
                                    <?php
                                }
                                ?>
                                

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
<script>
function validateAndUpload(input){
    var file = input.files[0];
    var nme = document.getElementById("csv");
    var impbtn = document.getElementById("uploadcsv");
    
    if(nme.value.length < 4){
        impbtn.disabled = true;
    }else{
        impbtn.disabled = false;
    }
}
</script>