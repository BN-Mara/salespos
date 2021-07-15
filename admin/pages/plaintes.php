<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$row=$response->getAllPlainte();

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Liste des Plaintes
        <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Plaintes</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Utilisateurs</h3>
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
                    <th>Client</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Date d'ajout</th>
                    <th>statut</th>
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
                            <td><?php
                                $cl = $response->getOneClientById($item['id_client']);
                                echo $cl['firstname']." ".$cl['lastname'];

                                ?></td>
                            <td><?php
                                $pl = $response->getOnePlainteTypeById($item['id_type']) ;
                                echo $pl['designation'];
                                ?></td>
                            <td><?php echo $item['description']; ?></td>
                            <td><?php echo $item['creation_date']; ?></td>
                            <td><?php
                                if($item['status'] == 0){
                                    echo "NON";
                                }else{
                                    echo "OUI";
                                }
                                ?></td>
                            <td><a href="layout.php?page=setPlaintesolution&id=<?php echo $item['id_plainte']; ?>">Completer</a></td>


                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Date d'ajout</th>
                    <th>statut</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
