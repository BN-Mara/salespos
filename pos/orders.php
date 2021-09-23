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
          <p>
        <button class="btn btn-secondary" id="today">Today</button>&nbsp; <button class="btn btn-secondary" id="this_week">this week</button>&nbsp;
        <button class="btn btn-secondary" id="this_month">this month</button>
          </p>
            <table class="table display nowrap" id="dataTableSales" width="100%" cellspacing="0">
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
                <tbody id="tbodysales">
                <?php
                //print_r($row);
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
                                $creationd = $response->getSaleReferenceById($item['id_ref']);
                                echo $cl['firstname']." ".$cl['lastname']." ".$cl['middlename'];
                                ?></td>
                            <td><?php echo $item['nbre_article']; ?></td>
                            <td><?php echo $item['total_price']; ?></td>
                            <td><?php echo $creationd['reference']; ?></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Order details</h5>
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
        <th>Evc number</th>
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
        <th>Evc number</th>
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
localStorage.setItem("pos",<?php echo $pos; ?>);
var t = $("#dataTableSales").DataTable({});
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
                    var tr  = '<tr><td>'+data['designation']+'</td><td>'+data['unit_price']+'</td><td>'+data['imei']+'</td><td>'+data['iccid']+'</td><td>'+data['msisdn']+'</td><td>'+data['serial']+'</td><td>'+data['evcnumber']+'</td></tr>'
                    
                    $('#ordersdataTable tbody').append(tr);

                })
      
 
                $('#ordersdataTable').DataTable(
  {
  /*dom: 'Blfrtip',
  buttons: [
  'copy', 'csv', 'excel', 'pdf', 'print'
  ]*/
}
);

// FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
//var divContainer = document.getElementById("modalbd");
//divContainer.innerHTML = "";
//divContainer.appendChild(table);
                
            }
        });
    }

    $("#today").on("click",()=>{
      ////console.log(localStorage);
      //alert("hello");
      tableLoading();
      
      ajaxCall("today",localStorage.getItem("pos"))
    });

    $("#this_week").on("click",()=>{
      tableLoading();
      ajaxCall("this_week",localStorage.getItem("pos"));
    });

    $("#this_month").on("click",()=>{
      tableLoading();
      ajaxCall("this_month",localStorage.getItem("pos"));
    })

    function ajaxCall(when,pos){
      var formData = {
        action:"report_sales_pos",
        mtime:when,
        pos:pos
      };
      $.ajax({
        type:"post",
        url:"../controllers/CommonController.php",
        data:formData,
        success:(data)=>{
          data = $.parseJSON(data);
          console.log(data);
               //var datas = [];
               t.clear().draw();
               if(data.length > 0){
                data.forEach((v,i)=>{
                  
                    //console.log($('#example2'));
                    //datas.push([v.designation,v.qte < 1?"0":v.qte])
                    //t.row.add("<tr><td>"+v.designation+"</td><td>"+v.qte+"</td><td>"+v.total+"</td></tr>");
                    t.row.add([
                        v.lastname+" "+v.middlename+" "+v.firstname,
                        v.nbre_article,
                        v.total_price,
                        v.reference,
                        v.creation_date,
                        `<button type="button" class="btn btn-primary" onclick="getdetails(`+ v.id_ref+`)" data-toggle="modal" data-target="#exampleModal">
                            View
                            </button>`
                    ]).draw(true);
                });
               }

          //console.log(t);
        }
      });
    }
    
    function tableLoading(){
      $("#tbodysales").html(`<tr><td colspan="6"><center><div class="spinner-border" role="status">
  <span class="sr-only">Loading...</span>
</div></center></td></tr>`);
return 1;
    }


</script>