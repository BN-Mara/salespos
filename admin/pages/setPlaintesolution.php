
<?php
include_once '../models/Dao_Carte.php' ;


$id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $response=new Dao_Carte();
    $row=$response->getPlainteById($id);
}

else{

    $row=0;
    $error = "aucune";
}



?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Modifier Plainte

    </h1>
    <ol class="breadcrumb">

        <li><a href="#">Solution Plainte</a></li>

    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Plainte No <?php echo $row['id_plainte']; ?></h3> <a href="layout.php?page=plaintes"><button class="btn btn-primary pull-right" >retour à la liste</button></a>
        </div>
        <!-- /.box-header -->
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
        <?php
        if(isset($_SESSION['infoerror'])){
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo $_SESSION['infoerror']; ?> .
            </div>

            <?php
            unset($_SESSION['infoerror']);
        }
        ?>
        <!-- form start -->
        <form role="form" method="post" action="../controllers/PlainteController.php" enctype="multipart/form-data">
            <center>
                <div class="box-body" style="width:50%">
                    <input type="hidden" id="action" name="action" value="modifier" >
                    <input type="hidden" name="bnid" value="<?php echo $row['id_plainte']; ?>" >
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea type="text" class="form-control" id="nom"   placeholder="Solution du produit" readonly="readonly">
                            <?php echo $row['description']; ?>
                    </textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Solution</label>
                        <textarea type="text" class="form-control" id="nom" name="solution"  placeholder="Solution du produit">
                            <?php echo $row['solution']; ?>
                    </textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" >Statut</label>
                        <select class="form-control" name="status">
                            <option <?php if($row['status'] == "PENDING" ){echo 'selected';}  ?>>PENDING</option>
                            <option <?php if($row['status'] == "COMPLETE" ){echo 'selected';}  ?>>COMPLETE</option>
                        </select>
                    </div>

                </div>

            </center>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Modifier</button>
            </div>
        </form>
    </div>

</section>
