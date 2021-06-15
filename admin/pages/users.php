<?php include_once '../models/Dao_Carte.php' ?>
<?php 
   
      $response=new Dao_Carte();
      $row=$response->getAllUsers();	 

?>

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Liste des Utilisateurs
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Liste des utilisateurs</a></li> 
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
                  <th>Noms</th>
                  <th>Username</th>
                  <th>statut</th>
                  <th>Role</th>
                  <th>POS</th>
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
                  <td><?php echo $item['names']; ?></td>
                  <td><?php echo $item['username']; ?></td>
                  <td><?php echo $item['status']; ?></td>
                  <td><?php echo $item['role']; ?></td>
                  <td><?php echo $item['designation']; ?></td>
				  <td><a href="layout.php?page=editUser&id=<?php echo $item['id']; ?>">Modifier</a><br>
				  <a href="layout.php?page=deleteUser&id=<?php echo $item['id']; ?>">Supprimer</a></td>

                </tr>
					
					<?php }}?>
                </tbody>
                <tfoot>
                <tr>
                   <th>Noms</th>
                  <th>Username</th>
                  <th>statut</th>
                  <th>Role</th>
                  <th>POS</th>
				  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
			 
              <!-- /.box-body -->
        
           
    </div>
    </section>
