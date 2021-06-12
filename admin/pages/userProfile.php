<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$row=$response->getUserByUsername($_SESSION['current_user']);

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profil d'utilisateur
    </h1>

</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Mon compte</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
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
                            <td>Nom d'utilisateur</td>
                            <td><?php echo $item['username']; ?></td>

                        </tr>
                        <tr>
                            <td>Nom</td>
                            <td><?php echo $item['names']; ?></td>

                        </tr>


                    <?php }}?>

            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
