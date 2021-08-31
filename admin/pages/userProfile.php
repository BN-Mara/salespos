<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$row="";
if(isset($_SESSION['current_user']))
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
        <?php
        if(isset($_SESSION['info'])){
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $_SESSION['info']; ?> .
            </div>

            <?php
            unset($_SESSION['info']);
        }
        if(isset($_SESSION['info_error'])){
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                <?php echo $_SESSION['info_error']; ?> .
            </div>

            <?php
            unset($_SESSION['info_error']);
        }
        ?>
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
                        <tr>
                            <td>Modifier Mot de pass</td>
                            <td>
                                <form action="../controllers/C_AjouterUser.php" method="post">
                                <input type="hidden" name="username" value="<?php echo $item['username']; ?>">
                                    <div class="form-group">
                                     <input class="form-control" type="password" placeholder="new password" name="modifpw" style="width:50%" minlength="6">
                                     <button class="btn btn-primary" type="submit" style="margin-top:10px">Modifier</button>
                                    </div>
                                </form>
                            </td>

                        </tr>


                    <?php }}?>

            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
