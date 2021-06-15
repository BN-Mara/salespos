<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$username = $_SESSION['user']['username'];
$pos = $response->getPOSByUsername($username);
$row=$response->salesPOS($pos);
?>

<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Ventes</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Mes ventes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display nowrap" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Nombre d'article</th>
                    <th>Prix total</th>
                    <th>Reference</th>
                    <th>date</th>
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
                            <td><?php
                                $cl = $response->getOneClientById($item['id_client']);
                                echo $cl['firstname']." ".$cl['lastname']." ".$cl['middlename'];
                                ?></td>
                            <td><?php echo $item['nbre_article']; ?></td>
                            <td><?php echo $item['total_price']; ?></td>
                            <td><?php echo $item['reference']; ?></td>
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
                <th>Client</th>
                    <th>Nombre d'article</th>
                    <th>Prix total</th>
                    <th>Reference</th>
                    <th>date</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
            url: "cart.php",
            data: "idRef=" + idref,
            success: function (datas) {
                
                datas = JSON.parse(datas);
                //console.log(datas);
                $('#ordersdataTable tbody').html('');
                datas.forEach((data,index)=>{
                    var tr  = '<tr><td>'+data['designation']+'</td><td>'+data['unit_price']+'</td><td>'+data['imei']+'</td><td>'+data['iccid']+'</td><td>'+data['msisdn']+'</td><td>'+data['serial']+'</td></tr>'
                    
                    $('#ordersdataTable tbody').append(tr);

                })
      
 
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