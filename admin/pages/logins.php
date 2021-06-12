<?php include_once '../models/Dao_Carte.php' ?>
<?php 
   
      $response=new Dao_Carte();
      $row=$response->getLogins();	 

?>

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Liste des Connexions
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Connexion des utilisateurs</a></li> 
      </ol>
    </section>
	<section class="content">
	<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Connexions</h3>
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
                  <th>Nom d'utilisateur</th>
                  <th>Derniere connexion</th>
                  <th>Permission</th>
                  <th>Deconnexion</th>
                  <th>Utilisateur</th>
				  <th>IP</th>
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
                  <td><?php echo $item['username']; ?></td>
                  <td><?php echo $item['last_login']; ?></td>
                  <td><?php
				     if($item['granted'])
				    echo '<div class="color-palette-set">             
                <div class="bg-green-active color-palette"><center><span><strong>autorisé</strong></span></center></div>
              </div>';
            
                     else
                         echo '<div class="color-palette-set">             
                <div class="bg-red-active color-palette"><center><span><strong>refusé</strong></span></center></div>
              </div>';			   
				  ?></td>
                  <td><?php echo $item['logout']; ?></td>
                  <td><?php 
				  if($item['usercheck']=='user')
					  echo '<div class="color-palette-set">             
                           <div class="bg-green-active color-palette"><center><span><strong>'.$item['usercheck'].'</strong></span></center></div>
                           </div>'; 
			     else
				      echo '<div class="color-palette-set">             
                           <div class="bg-red-active color-palette"><center><span><strong>'.$item['usercheck'].'</strong></span></center></div>
                           </div>'; 
				  ?></td>
				  <td><?php echo $item['ip']; ?></td>
				  
                </tr>
					
					<?php }}?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nom d'utilisateur</th>
                  <th>Derniere connexion</th>
                  <th>Permission</th>
                  <th>Deconnexion</th>
                  <th>Utilisateur</th>
				  <th>IP</th>
                </tr>
                </tfoot>
              </table>
            </div>
			 
              <!-- /.box-body -->
        
           
    </div>
    </section>
