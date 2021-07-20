<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 27/06/2020
 * Time: 18:13
 */
?>
<div class="container"  id="contact">

<div class="row">

<!-- Area Chart -->
<div class="col-12">
    <div class="card shadow mb-4 white">
    <!-- Card Header - Dropdown -->

    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Complaint</h6>
    </div>
    <div class="card-body">

    <form method="post" id="form_id">
        <div class="row" style="margin-bottom: 20px">

        <div class="col-4">
            <button onclick="document.getElementById('register').style.display='block'" type="button" class="btn btn-primary">New Customer</button>
        </div>

            <div class="col-8 form-group">
                <label > Select customer</label>
                    <select class="form-control" id="client" name="client">
                    <option value="">-- Choose --</option>

                        <?php

                        if($clients){
                            foreach ($clients as $row1) {
                                ?>
                                <option value="<?php echo($row1['id_client']); ?>" ><?php echo $row1['lastname']; ?> </option>
                                <?php
                            }
                        }

                        ?>
                    </select>
                    
            </div>
        </div>
            <div class="row">
                <div class="col-12">
                    <p>
                        <label for="plainte_type">Category</label>
                        <select class="form-control" id="plainte_type" name="plainte_type">
                        <option value="">-- Choose --</option>

                            <?php
                            $dao = new Dao_Carte();
                            $types = $dao->getAllPlainteType();

                            if($types){
                                foreach ($types as $row) {
                                    ?>
                                    <option value="<?php echo($row['id_type']); ?>" ><?php echo $row['designation']; ?></option>

                                    <?php
                                }
                            }

                            ?>
                        </select>
                    </p>
                </div>


            </div>
            <div class="row">
                <div class="col-8 form-group">
                    <label for="plainte_subtype">Type</label>
                <select class="form-control" id="plainte_subtype" name="plainte_subtype" onchange="show_extra(this)" required>
                <option value="">-- Choose --</option>
                    <?php
                    $dao = new Dao_Carte();
                    $types = $dao->getPlainteSubTypeByType(1);

                    if($types){
                        foreach ($types as $row1) {
                            ?>
                            <option value="<?php echo $row1['id_subtype']; ?>" ><?php echo $row1['designation']; ?> </option>

                            <?php
                        }
                    }

                    ?>
                </select>
                </div>
                    <div class="col-4 form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" onchange="complete(this)">
                            <option value="PENDIG">PENDING</option><option value="COMPLETE">COMPLETE</option>
                        </select>
                     </div>
                 </div>

                 <div class="container" id="block_evc" style="display:none">
                 <div class="row">
                    <div class="col-12 form-group">
                        <label for="pl_evc">EVC </label>
                        <input class="form-control" id="pl_evc" name="pl_evc" placeholder="EVC number">

                    </div>
                 </div>
                 </div>

                <div class="container" id="block_facture" style="display:none">
                 <div class="row">
                    <div class="col-12 form-group">
                        <label for="pl_facture">Invoice Number</label>
                        <select class="form-control"  id="pl_facture" name="pl_facture">
                        <option value="">-- Choose --</option>

                            <?php
                            $dao = new Dao_Carte();
                            $types = $dao->getAllSaleReference();

                            if($types){
                                foreach ($types as $row1) {
                                    ?>
                                    <option value="<?php echo($row1['id_ref']); ?>" ><?php echo $row1['reference']; ?> </option>

                                    <?php
                                }
                            }

                            ?>
                        </select>
                    </div>
                </div>
                </div>

            <div class="container" id="phone_prob" style="display:none;">
                <div class="row">
                <div class="col-6 form-group">
                    <label for="pl_imei">IMEI</label>
                    <input class="form-control" id="pl_imei" name="pl_imei" placeholder="IMEI de phone">
                </div>
                    <div class="col-6 form-group">
                        <label for="pl_numero">Customer number</label>
                        <input class="form-control" id="pl_numero" name="pl_numero" placeholder="numero de telephone du client">

                </div>

                </div>
            </div>
            <div class="container" id="scratch_prob" style="display:none;">
               
                <div class="row">
                    <div class="col-6">
                        <label for="pl_serial">Serial</label>
                        <input class="form-control" id="pl_serial" name="pl_serial" placeholder="Serial du scratch">
                    </div>
                    <div class="col-6">
                        <label for="pl_numero1">Number</label>
                        <input class="form-control" id="pl_numero1" name="pl_numero1" placeholder="numero qui recharge le scratch">

                    </div>

                </div>
            </div>
                 <p></p>
            <div class="row">
            <div class="col-12">
                 <p><textarea class="form-control" type="text" placeholder="commentaire..." required name="description" id="description" style="height: 200px;"></textarea></p>
            </div>
            </div>
            <div class="row">
            <div class="col-12" id="solution" style="display:none">
                <p><textarea class="form-control" type="text" placeholder="decrivez la solution..."  name="solution" id="solution" style="height: 200px;"></textarea></p>
            </div>
            </div>
            <div class="container" style="margin-bottom: 20px">
                     <button class="btn btn-success" type="submit" name="send">
                         <i class="fa fa-paper-plane"></i> ENVOYER
                     </button>
                 </div>
             </form>
    </div>
</div>
</div>
</div>









<script>

  /*  $(document).on('submit','form', function(){
        
        setTimeout(function(){
            window.location = "index.php?page=plainte";
        }, 3000);
        
    });*/
    function complete(sel){
        var sol = document.getElementById("solution");
        if(sel.value == "COMPLETE"){

            sol.style.display = "block";
        }else{
            sol.style.display = "none";
        }

    }

    $(document).ready(function(){
        //alert("hello");
        $('#form_id').submit((event)=>{
    event.preventDefault();
    //alert($("#client").val());
    var customer = $("#client").val();
    if(customer ==""){
        alert("client must be selected");
        return false;
    }

    var plainte_type = $("#plainte_type").val();
    var plainte_subtype = $("#plainte_subtype").val();
    var status = $( "#status option:selected" ).text();
    var pl_facture = $("#pl_facture").val();
    var pl_imei = $("#pl_imei").val();
    var pl_numero = $("#pl_numero").val();
    var pl_serial = $("#pl_serial").val();
    var pl_numero1 = $("#pl_numero1").val();
    var pl_evc = $("#pl_evc").val();
    var description = $("#description").val();
    var solution = $("#solution").val();
    //alert(plainte_type);
    if(status == ""){
        status = "PENDING";

    }

    var formData = {
        client: customer,
        plainte_type: plainte_type,
        plainte_subtype: plainte_subtype,
        status: status,
        pl_facture: pl_facture,
        pl_imei: pl_imei,
        pl_numero: pl_numero,
        pl_serial: pl_serial,
        pl_numero1: pl_numero1,
        pl_evc:pl_evc,
        description: description,
        solution: solution,
        send:"send"  
    };
    //console.log(formData);
    $.ajax({
      type: "POST",
      url: "sendmail.php",
      data: formData,
      success: function (data) {                        
            console.log(data);
            const data2 = $.parseJSON(data);
            if(data2.msg == "success"){
                alert("Complaint sent successfully");

                const num_pl = FormatNumberLength(data2.num,4)  

                var divContents = "<h1 align='center'>Complaint No  "+num_pl+"</h1>";
        divContents+="<table>";

        divContents+="<tr><td><b>Client</b></td><td>:"+$( "#client option:selected" ).text()+"</td></tr>";
        divContents+="<tr><td><b>Category</b></td><td>:"+$( "#plainte_type option:selected" ).text()+"</td></tr>";
        divContents+="<tr><td><b>Subcategory</b></td><td>:"+$( "#plainte_subtype option:selected" ).text()+"</td></tr>";
        divContents+="<tr><td><b>Status</b></td><td>:"+$( "#status option:selected" ).text()+"</td></tr>";
        divContents+="<tr><td><b>Invoice No</b></td><td>:"+formData.pl_facture != "" ? $( "#pl_facture option:selected" ).text() : "" +"</td></tr>";
        divContents+="<tr><td><b>Phone number</b></td><td>:"+formData.pl_numero+formData.pl_numero1+"</td></tr>";
        divContents+="<tr><td><b>Scratch Serial</b></td><td>:"+formData.pl_serial+"</td></tr>";
        divContents+="<tr><td><b>EVC</b></td><td>:"+formData.pl_evc+"</td></tr>";
        divContents+="<tr><td><b>Imei</b></td><td>:"+formData.pl_imei+"</td></tr>";
        divContents+="<tr><td><b>Description</b></td><td>:"+formData.description+"</td></tr>";
        divContents+="<tr><td><b>Solution</b></td><td>:"+formData.solution+"</td></tr>";
        divContents+="</table>";
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Complaint</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('<br><br><hr>');
            printWindow.document.write('<img src="images/Logoafricell.png">');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            $('#form_id').trigger("reset");
            }
                       
        },
        
    });
    
   
    //event.preventDefault();
});
function FormatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}

        $("#plainte_type").on("change", function() {

            $("#phone_prob").hide('fast');
            $("#scratch_prob").hide('fast');
            $('#block_facture').hide('fast');
            var value = $(this).val().toLowerCase();
            //alert(value);
            if(value != "") {
                //("#checkname").html
                $.ajax({
                    type: "post",
                    url: "sendmail.php",
                    data: "id_cat=" + value,
                    success: function (data) {
                        data = $.parseJSON(data);
                        //alert(data[0].id_subtype);
                        //$("#plainte_subtype").html(data);
                        $("#plainte_subtype").empty();
                        $('#plainte_subtype').append('<option>-- Choose --</option>')
                        
                       for (var i = 0; i < data.length; i++) {
                            $('#plainte_subtype').append('<option id=' + data[i].sysid + ' value=' + data[i].id_subtype + '>' + data[i].designation + '</option>');
                        }
                    }
                });
            }
        });
    });

    function show_extra(sel){
        //alert($( "#plainte_subtype option:selected" ).text());
        var subcat = $( "#plainte_subtype option:selected" ).text();
        var cat = $( "#plainte_type option:selected" ).text();
        var subcatval = $("#plainte_subtype").val();
        //alert(subcatval);
        if(cat.trim() == "VENTE" && subcat != "-- Choose --"){
           //alert(cat);

        //$("#block_facture").show('fast');
        if(subcat.includes("SCRATCH")){
            //alert("EVC");
            $("#block_facture").show('fast');
            $("#scratch_prob").show('fast');
            $("#phone_prob").hide('fast');
            $("#block_evc").hide('fast');


        }else if(subcat.includes("EVC")){

            
            $("#block_evc").show('fast');
            $("#block_facture").hide('fast');
            $("#scratch_prob").hide('fast');
            $("#phone_prob").hide('fast');
            

        }
        else{
            $("#block_facture").show('fast');
            $("#phone_prob").show('fast');
            $("#scratch_prob").hide('fast');
            $("#block_evc").hide('fast');

        }
        
        }
        else{
            $("#block_facture").hide('fast');
            $("#phone_prob").hide('fast');
            $("#scratch_prob").hide('fast');
            $("#block_evc").hide('fast');
        }
    }
</script>




