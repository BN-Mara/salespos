<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();

$row=$response->getAllSerialJoined();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tous les Serials

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tous les Serials</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Scratch Serials</h3>
            <!--<form method="post" action="../controllers/ImeiController.php" enctype="multipart/form-data">
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
                    <th>Produit</th>
                    <th>Serial</th>
                    <th>POS</th>
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
                            <td><?php
                                //$p = $response->getOneProductById($item['id_product']);
                                echo $item[1];
                                ?></td>
                            <td><?php echo $item['serial']; ?></td>
                            <td><?php
                                //$pos = $response->getOnePOSById($item['id_pos']);
                                echo $item[2];
                                ?>
                            </td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Produit</th>
                    <th>Serial</th>
                    <th>POS</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
<script>

</script>
