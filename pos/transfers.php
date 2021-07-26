<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();

$row=$response->getTransferRefByIdPOSFrom($pos);
?>

<!-- Content Header (Page header) -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Mes Transferts</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Transferts</h6>
    </div>
    <div class="card-body">
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
            <table id="dataTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Transfer</th>
                    <th>De POS </th>
                    <th>Pour POS</th>
                    <th>date Ajouter</th>
                    <th>Ajouter Par</th>
                    <th>Statut</th>
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
                            <td><?php echo $item['id_trans_reference']; ?></td>
                            <td><?php 
                            $rs = $response->getOnePOSById($item['id_pos_from']);
                            echo $rs['designation']; ?></td>
                            <td><?php 
                            $rs = $response->getOnePOSById($item['id_pos_to']);
                            echo $rs['designation']; ?></td>
                            <td><?php echo $item['creation_date']; ?></td>
                            <td><?php echo $item['addedBy']; ?></td>
                            <td><?php 
                            if($item['status'] == "APPROVED")
                            echo '<span class="label label-success">'.$item['status'].'</span>';
                            else if($item['status'] == "CANCELED")
                            echo '<span class="label label-danger">'.$item['status'].'</span>';
                            else
                            echo '<span class="label label-warning">'.$item['status'].'</span>';
                            ?></td>                           
                             

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Transfer</th>
                    <th>De POS </th>
                    <th>Pour POS</th>
                    <th>date Ajouter</th>
                    <th>Ajouter Par</th>
                    <th>Statut</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</div>
</div>
