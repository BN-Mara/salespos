<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$chkPg = $response->checkPagesByUsername($_SESSION['current_user'], "approveStock");
/*if($chkPg){
    if(isset($_GET['delete'])){
        $response->deleteOneProduct($_GET['delete'] , $_SESSION['current_user']);
        
    }
}else{
    $_SESSION['info'] = "Vous n\'etes pas autorise pour cette tache!";
}
*/
$row=$response->getAllTransferReferences();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tous les Transferts

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tous les Transferts</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Transferts</h3>
           <!-- <form method="post" action="../controllers/ProduitController.php" enctype="multipart/form-data">
            <table class="pull-right">
                <tr>
                    <td>
                    <input  type="file" name="csv" id="csv" accept=".csv" onChange="validateAndUpload(this);" >
                    </td>
                    <td>
                    <button class="btn btn-secondary " type="submit" name="uploadcsv" id="uploadcsv" disabled>Import</button>
                    </td>
                </tr>
            </table>
        </form>-->
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
                    <th>Transfer</th>
                    <th>De POS </th>
                    <th>Pour POS</th>
                    <th>date Ajouter</th>
                    <th>Ajouter Par</th>
                    <th>Statut</th>
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
                            <td><?php echo $item['id_trans_reference']; ?></td>
                            <td><?php 
                            $rs = $response->getOnePOSById($item['id_pos_from']);
                            echo $rs['designation']; ?></td>
                            <td><?php 
                            $rs = $response->getOnePOSById($item['id_pos_to']);
                            echo $rs['designation']; ?></td>
                            <td><?php echo $item['creation_date']; ?></td>
                            <td><?php echo $item['addedBy']; ?></td>
                            <td><?php 
                            if($item['status'] == "APPROVED")
                            echo '<span class="label label-success">'.$item['status'].'</span>';
                            else if($item['status'] == "CANCELED")
                            echo '<span class="label label-danger">'.$item['status'].'</span>';
                            else
                            echo '<span class="label label-warning">'.$item['status'].'</span>';
                            ?></td>                           
                            <td>
                             <?php 
                             if($chkPg){
                                 ?>
                                 <button type="button" class="btn btn-primary" onclick="showDetails(<?php  echo $item['id_trans_reference']; ?>)" data-toggle="modal" data-target="#exampleModal">Products</button>
                                 <?php

                             }  
                              
                             ?>   

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Transfer</th>
                    <th>De POS </th>
                    <th>Pour POS</th>
                    <th>date Ajouter</th>
                    <th>Ajouter Par</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->


    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Products transfered</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="details">
            <thead>
                <tr>
                    <th>
                        Product
                    </th>
                    <th>
                        Quantity
                    </th>
                </tr>
            </thead>
            <tbody id="tbody2">
  
            </tbody>
            <tfoot>
                <tr>
                    <th>
                        Product
                    </th>
                    <th>
                        Quantity
                    </th>
                </tr>
            </tfoot>
        </table>
      </div>
      <div class="container-fluid">
          <textarea class="form-control" height="200" width="500" name="message" id="message" placeholder="comment..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" id="approveBtn" onclick="cancel()" class="btn btn-danger float-left">Cancel</button>
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" onclick="approve()" class="btn btn-primary">Approve</button>
        
      </div>
    </div>
  </div>
</div>
<script>
var idRef = 0;
function showDetails(id){
    //alert(id);
    $('#tbody2').children('tr').remove();;
    idRef = id;
    $.ajax({
            type: "post",
            url: "../controllers/TransferController.php",
            data: {detailId: id},
            dataType: "text",
            success: function (data) {
                
                data = $.parseJSON(data);
                console.log(data);
                
                //$("#pos").val(data['pos']);
                $.each(data,( index, value )=>{
                    console.log(value.id_product);
                    $('#tbody2').append(
                        "<tr><td>"+value.designation+"</td><td>"+value.quantity+"</td></tr>"
                    );
                });
                              
            }
    });
}
function approve(){
    //alert(idRef);
    const msg = $('#message').val();
    $.ajax({
            type: "post",
            url: "../controllers/TransferController.php",
            data: {
                action: "approve",
                message: msg,
                id_trans_reference: idRef
            },
            dataType: "text",
            success: function (data) {
                
                data = $.parseJSON(data);
                console.log(data);
                alert(data["info"]);
                alert(data["info"]);
                window.location.reload();
                //$("#pos").val(data['pos']);
                
               
            }
    });
}
function cancel(){
    //alert(idRef);
    const msg = $('#message').val();
    $('#message').addClass("has-error");
    if(msg == ""){
        alert("comment field must not be empty");
        return;
    }
    $.ajax({
            type: "post",
            url: "../controllers/TransferController.php",
            data: {
                action: "cancel",
                message: msg,
                id_trans_reference: idRef
            },
            dataType: "text",
            success: function (data) {
                
                data = $.parseJSON(data);
                console.log(data);
                alert(data["info"]);
                window.location.reload();
                
                //$("#pos").val(data['pos']);
                
               
            }
    });
}

</script>