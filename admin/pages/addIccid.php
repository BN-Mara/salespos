<?php include_once '../models/Dao_Carte.php' ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Ajouter ICCID

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Ajouter ICCID</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Product ICCID</h3> <a href="layout.php?page=produits"><button class="btn btn-primary pull-right" >retour à la liste</button></a>
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
        <form role="form" method="post" action="../controllers/IccidController.php" enctype="multipart/form-data">
            <center>
                <div class="box-body" style="width:50%">
                    <input type="hidden" id="action" name="action" value="ajouter" >
                    <div class="form-group" >
                        <label for="exampleInputEmail1">Produit</label>
                        <select class="form-control" name="id_product">
                            <?php

                            $response=new Dao_Carte();
                            $rows=$response->getAll();
                            if($rows){
                                foreach ($rows as $row) {
                                    ?>
                                    <option value="<?php echo $row['id_product']; ?>"><?php echo $row['designation']; ?> </option>
                                    <?php
                                }
                            }
                            else {
                                //die("no data");
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="iccid">ICCID</label>
                        <input type="number" class="form-control" id="iccid" name="iccid" min="1"  onKeyDown="if(this.value.length==20) return false;">
                    </div>
                    <div class="form-group" >
                        <label for="emsisdn">MSISDN</label>
                        <input type="number" class="form-control" id="msisdn" name="msisdn" min="1"  onKeyDown="if(this.value.length==10) return false;">
                    </div>
                    <div class="form-group" >
                        <label for="type">Type</label>
                        <input type="text" class="form-control" id="type" name="type" min="1" maxlength="10">
                    </div>
                    <div class="form-group" >
                        <label for="profile">Profile</label>
                        <input type="text" class="form-control" id="profile" name="profile" min="1" >
                    </div>
                    <div class="form-group" >
                        <label for="id_pos">POS</label>
                        <select class="form-control"  id="id_pos" name="id_pos">
                            <?php

                            $response=new Dao_Carte();
                            $rows=$response->getAllPOS();
                            if($rows){
                                foreach ($rows as $row) {
                                    ?>
                                    <option value="<?php echo $row['id_pos']; ?>"><?php echo $row['designation']; ?> </option>
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