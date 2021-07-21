<?php include_once '../models/Dao_Carte.php' ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Ajouter Produit

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Ajouter Document</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Nouveau Produit</h3> <a href="layout.php?page=produits"><button class="btn btn-primary pull-right" >retour à la liste</button></a>
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
        <form role="form" method="post" action="../controllers/ProduitController.php" enctype="multipart/form-data">
            <center>
                <div class="box-body" style="width:50%">
                    <input type="hidden" id="action" name="action" value="ajouter" >
                   <!-- <div class="form-group" >
                        <label for="exampleInputEmail1">Code</label>
                        <input type="text" class="form-control form-control" id="nom" name="code" placeholder="Code du produit" >
                    </div>-->

                    <div class="form-group" >
                        <label for="exampleInputEmail1">Designation</label>
                        <input type="text" class="form-control" id="nom" name="name" placeholder="Nom du produit" >
                    </div>
                    <label for="price">Prix</label> 
                    <div class="input-group md-3" >
                        
                            <span class="input-group-addon">USD</span> 
                                         
                        <input id="price" type="number" class="form-control" name="price" placeholder="Prix du produit" min="0" step="0.000001">
                    </div>

                    <div class="form-group" >
                        <label for="exampleInputEmail1">Type de produit</label>
                        <select class="form-control" name="produit_type">
                            <?php

                            $response=new Dao_Carte();
                            $rows=$response->getAllCategory();
                            if($rows){
                                foreach ($rows as $row) {
                                    ?>
                                    <option value="<?php echo $row['id_category']; ?>"><?php echo $row['designation']; ?> </option>
                                    <?php
                                }
                            }
                            else {
                                //die("no data");
                            }
                            ?>
                        </select>
                    </div>

                    <!--<div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea type="text" class="form-control" id="nom" name="description" placeholder="description du produit">
                    </textarea>
                    </div>-->


                </div>

            </center>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Ajouter</button>
            </div>
        </form>
    </div>
    <section class="content">

    </section>

</section>
<script>

</script>