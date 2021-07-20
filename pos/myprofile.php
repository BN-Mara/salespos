
<?php 
include_once '../models/Dao_Carte.php';

$response=new Dao_Carte();
$row=$response->getUserByUsername($username);

?>

<div class="container-fluid">
<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Mon stock</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Stock available</h6>
    </div>
    <div class="card-body">
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
                                     <input class="form-control" type="password" placeholder="new password" name="modifpw" style="width:50%">
                                     <button class="btn btn-primary" type="submit" style="margin-top:10px">Modifier</button>
                                    </div>
                                </form>
                            </td>

                        </tr>


                    <?php }}?>

            </table>
    </div>
</div>
</div>