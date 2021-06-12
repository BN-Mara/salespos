<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();

$row=$response->getRate();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Taux de change

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Taux de change</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Taux</h3>
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
                    <th>USD</th>
                    <th>CDF</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //var_dump($row);
                if($row)
                {
                
                        ?>
                        <tr>
                            <td><?php echo '1 USD'; ?></td>

                            <td><?php echo $row[0]['rate'].' CDF'; ?></td>
                
                            <td>
                                <a href="layout.php?page=editRate&id=<?php echo $row[0]['id_rate']; ?>">Modifier</a></td>

                        </tr>

                    <?php }?>
                </tbody>
                <tfoot>
                <tr>
                    <th>USD</th>
                    <th>CDF</th>
                    <th>Action</th>
                    
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
