<?php include_once '../models/Dao_Carte.php' ?>

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ajouter Utilisateur

      </h1>
      <ol class="breadcrumb">

        <li><a href="#">Ajouter Utilisateur</a></li>

      </ol>
    </section>
	<section class="content">
	<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Utilisateur</h3> <a href="layout.php?page=users"><button class="btn btn-primary pull-right" name="action" value="ajouter">retour à la liste</button></a>
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
              <div class="box-body" style="width:50%">
			  <input type="hidden" id="action" name="action" value="ajouter" >
                <div class="form-group" >
                  <label for="exampleInputEmail1">Noms</label>
                  <input type="text" class="form-control form-control" id="nom" name="noms" placeholder="Nom complet" >
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Nom d'utilisateur </label>
                  <input type="text" class="form-control" id="nom" name="username" placeholder="utilisateur">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Mot de passe </label>
                  <input type="password" class="form-control" id="nom" name="password" placeholder="Mot de passe">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Role</label>
                  <select class="form-control" name="role">
                    <option>USER</option>
                    <option>ADMIN</option>
					 <option>SUPER_ADMIN</option>
                    </select>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Statut</label>
                  <select class="form-control" name="status">
                    <option>DESACTIVE</option>
                    <option>ACTIVE</option>
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
				 <div class="form-group">
                <label>Pages à acceder</label>
                <select class="form-control select2" name="pages[]" multiple="multiple" data-placeholder="Selectionner les pages de l'utilisateur"
                        style="width: 100%;">
                 <?php 
   
                 $response=new Dao_Carte();
                 $rows=$response->getPages();
                 if($rows){
                 foreach ($rows as $row) {
                   ?> 
                     <option><?php echo $row['name']; ?> </option>
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

			  </center>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Ajouter</button>
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
