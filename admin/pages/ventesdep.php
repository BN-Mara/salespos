<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$vente_txt = "";
if(isset($_GET['when'])){
    $when = $_GET['when'];
    if($when == 'today'){
        $row=$response->todaySales();
        $vente_txt = "Ventes d'aujourd'hui";
        $total = $response->todayTotalPriceSales();
        $quantity = $response->todaySalesQte();

    }
    if($when == 'thismonth'){
        $row=$response->thisMonthSales();
        $vente_txt = "Ventes de ce Mois";
        $total = $response->thisMonthTotalPriceSales();
        $quantity = $response->thisMonthSalesQte();

    }
    if($when == 'thisweek'){
        $row=$response->thisWeekSales();
        $vente_txt = "Ventes de cette semaine";
        $total = $response->thisWeekTotalPriceSales();
        $quantity = $response->thisWeekSalesQte();
    }

}else{
    $row=$response->getAllSaleReference();
    $vente_txt = "Toutes les ventes";
    $total = $response->totalPriceSales();
    $quantity = $response->totalSalesQuantity();
}


?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $vente_txt; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Toutes les comandes</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Motant Total: <?php echo $total; ?> CDF</h3>  <h3 class="box-title"> | Quantité: <?php echo $quantity; ?> Articles commandés</h3>
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
                    <th>Reference</th>
                    <th>ID Client</th>
                    <th>Nbre d'article</th>
                    <th>Total payé</th>
                    <th>POS</th>
                    <th>Date</th>
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
                            <td><?php echo $item['reference']; ?></td>
                            <td><?php
                                $c = $response->getOneClientById($item['id_client']);
                                echo $c['firstname'].' '.$c['lastname'];
                                ?></td>
                            <td><?php echo $item['nbre_article']; ?></td>
                            <td> <?php echo $item['total_price']; ?> CDF</td>
                            <td><?php
                                $posid = $response->getPOSByUsername($item['addedBy']);
                                $pos = $response->getOnePOSById($posid);
                                echo $pos['designation'];
                                ?></td>
                            <td><?php echo $item['creation_date']; ?></td>
                            <td>
                            <button type="button" class="btn btn-primary" onclick="getdetails(<?php echo $item['id_ref'];?>)" data-toggle="modal" data-target="#exampleModal">
                            View
                            </button>
                            </td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Reference</th>
                    <th>ID Client</th>
                    <th>Nbre d'article</th>
                    <th>Total payé</th>
                    <th>POS</th>
                    <th>Date</th>
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
  <div class="modal-dialog" role="document" style="width:70%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sales details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
      <div class="table-responsive" id="modalbd">
        <table class="table display nowrap" id="ordersdataTable">
        <thead>
        <tr>
        <th>Product</th>
        <th>unit price</th>
        <th>imei</th>
        <th>iccid</th>
        <th>msisdn</th>
        <th>serial</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
        <th>Product</th>
        <th>unit price</th>
        <th>imei</th>
        <th>iccid</th>
        <th>msisdn</th>
        <th>serial</th>
        </tr>
        </tfoot>
        <tbody>
        
        </tbody>

        
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<script>

 function getdetails(idref){
   
        //alert(idref);
        $.ajax({
            type: "post",
            url: "../controllers/CommonController.php",
            data: "idRef=" + idref,
            success: function (datas) {
                
                console.log(datas);
                datas = JSON.parse(datas);
                
              $('#ordersdataTable tbody').html('');
                datas.forEach((data,index)=>{
                    var tr  = '<tr><td>'+data['designation']+'</td><td>'+data['unit_price']+'</td><td>'+data['imei']+'</td><td>'+data['iccid']+'</td><td>'+data['msisdn']+'</td><td>'+data['serial']+'</td></tr>'
                    
                    $('#ordersdataTable tbody').append(tr);

                });
 
$('#ordersdataTable').DataTable(
  {
  dom: 'Blfrtip',
  buttons: [
  'copy', 'csv', 'excel', 'pdf', 'print'
  ]
}
);

// FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
//var divContainer = document.getElementById("modalbd");
//divContainer.innerHTML = "";
//divContainer.appendChild(table);
                
            }
        });
    }

</script>
