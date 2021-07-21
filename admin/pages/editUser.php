<?php include_once '../models/Dao_Carte.php' ?>
<?php 
    if(isset($_GET['id'])){
	 $id = $_GET['id'];
      $response=new Dao_Carte();
      $row=$response->getOneUserById($id);	 
	}
	
    else
		$error = "aucune";
?> 
 
 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ajouter Utilisateur
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Ajouter Utilisateur</a></li>
        <li class="active">General Elements</li> 
      </ol>
    </section>
	<section class="content">
	<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Modifier l'utilisateur</h3> <a href="layout.php?page=users"><button class="btn btn-primary pull-right" name="action" value="ajouter">retour à la liste</button></a>
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
            <form role="form" method="post" action="../controllers/C_AjouterUser.php" enctype="multipart/form-data">
			  <center>
			  <?php
			    //var_dump($row);
			    if($row)
                {
                     $count=0;
                     foreach($row as $item)
                    {
                    $count++;
                    ?> 
              <div class="box-body" style="width:50%">
			  <input type="hidden" id="action" name="action" value="modifier" >
			  <input type="hidden" id="myid" name="bnid" value="<?php echo $item['id']; ?>" >
                <div class="form-group" >
                  <label for="exampleInputEmail1">Noms</label>
                  <input type="text" class="form-control form-control" id="nom" name="noms" placeholder="Nom complet"  value="<?php echo $item['names']; ?>" required>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Nom d'utilisateur </label>
                  <input type="text" class="form-control" id="nom" name="username" placeholder="utilisateur" value="<?php echo $item['username']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">email </label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="adresse email" value="<?php echo $item['email']; ?>"  required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Phone </label>
                  <input type="text" class="form-control" id="email" name="phone" placeholder="Numero de telephone" value="<?php echo $item['phone']; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Adresse</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="adresse" value="<?php echo $item['address']; ?>">
                </div>

				<div class="form-group">
                  <label for="exampleInputEmail1">Role</label>
                  <select class="form-control" name="role" >
                    <option <?php if($item['role'] == "USER" ){echo 'selected';}  ?>>USER</option>
                    <option <?php if($item['role'] == "ADMIN" ){echo 'selected';}  ?>>ADMIN</option>
					 <option <?php if($item['role'] == "SUPER_ADMIN" ){echo 'selected';}  ?>>SUPER_ADMIN</option>
                    </select>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1" >Statut</label>
                  <select class="form-control" name="status">
                    <option <?php if($item['status'] == "DESACTIVE" ){echo 'selected';}  ?>>DESACTIVE</option>
                    <option <?php if($item['status'] == "ACTIVE" ){echo 'selected';}  ?>>ACTIVE</option>
                    </select>
                </div>
                <div class="form-group">
                      <label>POS</label>
                      <select class="form-control" name="pos" style="width: 100%;">
                      <option value="">-- Choisir --</option>
                      <option value="0">ADMIN</option>
                          <?php

                          $response=new Dao_Carte();
                          $rows=$response->getAllPOS();
                          if($rows){
                              foreach ($rows as $row) {
                                  ?>
                                  <option value="<?php echo $row['id_pos'];?>" <?php if($item['id_pos'] == $row['id_pos'] ){echo 'selected';} ?> ><?php echo $row['designation']; ?> </option>
                                  <?php
                              }
                          }
                          else {
                              //die("no data");
                          }
                          ?>
                      </select>
                  </div>
        <div class="form-group">
                <label>Pages à acceder</label>
                <select class="form-control select2" name="pages[]" multiple="multiple" data-placeholder="Selectionner les pages de l'utilisateur"
                        style="width: 100%;">
                    <?php

                    $response2=new Dao_Carte();
                    $rows2=$response2->getPages();
                    $user_pages = explode(";",$item['pages']);

                    if($rows2){
                        foreach ($rows2 as $row2) {
                            ?>
                            <option value="<?php echo $row2['name']; ?>" <?php if(in_array($row2['name'],$user_pages)){echo 'selected';}  ?>><?php echo $row2['name']; ?> </option>
                            <?php
                        }
                    }
                    else {
                        die("no data");
                    }
                    ?>
                </select>
              </div>
				 
              </div>
			  <?php }}?>
			  </center>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Modifier</button>
              </div>
            </form>
    </div>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">description des pages</h3>
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Page</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $response=new Dao_Carte();
                        $rows=$response->getPages();

                        if($rows){
                            foreach ($rows as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['name']; ?> </td>
                                    <td><?php echo $row['description']; ?> </td>
                                </tr>
                                <?php
                            }
                        }
                        else {
                            die("no data");
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Page</th>
                            <th>Description</th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </section>
    </section>