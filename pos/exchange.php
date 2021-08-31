<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 26/07/2020
 * Time: 12:53
 */

$response = new Dao_Carte();
$factures = $response->getAllSaleReference();
$products = $response->getAllToSale();
$plaintes = $response->getAllPlainte();
?>

<div class="container" >

<div class="row">

<!-- Area Chart -->
<div class="col-12">
    <div class="card shadow mb-4 white">
    <!-- Card Header - Dropdown -->

    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Product Exchange</h6>
    </div>
    <div class="card-body">


<div class="container">
    <form method="post" action="cart.php">
        <div class="row">
            <div class="col-12">
                <p>
                    <label for="facture">N<sup>o</sup> Plainte</label>
                    <select class="form-control" id="plainte" name="plainte">

                        <?php

                        if($plaintes){
                            foreach ($plaintes as $row) {
                                ?>
                                <option value="<?php echo($row['id_plainte']); ?>" ><?php echo $row['id_plainte']; ?> </option>

                                <?php
                            }
                        }

                        ?>
                    </select>
                </p>
            </div>

        </div>
    <div class="row">
        <div class="col-12">
            <p>
            <label for="facture">N<sup>o</sup> Facture</label>
            <select class="form-control" id="facture" name="facture">

                <?php

                if($factures){
                    foreach ($factures as $row) {
                        ?>
                        <option value="<?php echo($row['id_ref']); ?>" ><?php echo $row['reference']; ?> </option>

                        <?php
                    }
                }

                ?>
            </select>
            </p>
        </div>

    </div>
        <div class="row">
            <div class="col-12">
                <p>
                <label for="product">Ancien Produit</label>
                <select class="form-control" id="oldproduct" name="product">

                    <?php

                    if($products){
                        foreach ($products as $row) {
                            ?>
                            <option value="<?php echo($row['id_product']); ?>" ><?php echo $row['designation']; ?> </option>

                            <?php
                        }
                    }

                    ?>
                </select>
                </p>
            </div>


        </div>
        <div class="row">
            <div class="col-12">
                <p>
                    <label for="product">Nouveau Produit</label>
                    <select class="form-control" id="newproduct" name="newproduct">

                        <?php

                        if($products){
                            foreach ($products as $row) {
                                ?>
                                <option value="<?php echo($row['id_product']); ?>" ><?php echo $row['designation']; ?> </option>

                                <?php
                            }
                        }

                        ?>
                    </select>
                </p>
            </div>


        </div>
    <div class="row">
        <div class="col-6">
            <p>
            <label for="oldimei">Old IMEI</label>
            <input class="form-control" name="oldimei" type="text" placeholder="Old IMEI" id="oldimei" 
            onblur="checkImeiPOSOdlProduct(this.value,this.id)"
            onclick="removeAfterImei(this.id)">
            </p>
        </div>
        <div class="col-6">
            <p>
            <label for="newimei">New IMEI</label>
            <input class="form-control" name="newimei" type="text" placeholder="New IMEI" id="newimei" 
            onblur="checkImeiPOSNewProduct(this.value,this.id)"
            onclick="removeAfterImei(this.id)">
            </p>
        </div>

    </div>
        <p>
            <input class="btn btn-primary" id="exchange" name="exchange" type="submit" value="Valider" disabled>
        </p>
</form>

</div>
    </div>
    </div>
</div>
</div>
</div>
<script>
    //11112345
    
    var error_arr = [1,1];
    
    function checkErrorExtra(){
        console.log(error_arr);
        if(error_arr[1] == 0 && error_arr[0] == 0){
            if($("#oldimei").val() != $("#newimei").val())
            $("#exchange").prop('disabled', false);


        }else{
            $("#exchange").prop('disabled', true);
        }
    }
    function removeAfterImei(fieldId){
        $(".validationImei").remove();
    }
    function checkImeiPOSOdlProduct(value,fieldId){
        var oldpid = $('#oldproduct').val();
        checkImeiPOSProduct(value,fieldId, oldpid);
    }
    function checkImeiPOSNewProduct(value,fieldId){
        var newpid = $('#newproduct').val();
        checkImeiPOSProduct(value,fieldId,newpid);
    }

    function checkImeiPOSProduct(value,fieldId, id){
        //alert(fieldId);
        //var oldpid = $('#oldproduct').val();
        //var newproduct = $("#newproduct").text();
        //alert(id);
       var formData = {
            check_extra_imei:"check_extra_imei",
            id_product: id,
            imei:value
        };
        $.ajax({
            type: "post",
            url: "cart.php",
            data: formData,
            success: (data) =>{
                data = $.parseJSON(data);
               console.log(data);
               if(data.imei == 0){
                   //document.getElementById(fieldId). ="invalid";
                   $('#'+fieldId).after("<span class='validationImei' style='color:red; padding-bottom:10px'> IMEI n\'est pas dans votre stock.<br></span>");
                   //$('#nextBtn').prop("disabled", true )
                   //errorExtra[0] = false;
                   if (fieldId == "newimei")
                    error_arr[1] = 1;
                   if(fieldId == "oldimei")
                    error_arr[0] = 1;
                    checkErrorExtra();
               }else{
                   // errorExtra[0] = true;
                   if (fieldId == "oldimei")
                    error_arr[0] = 0;
                   if(fieldId == "newimei")
                    error_arr[1] = 0;

                    checkErrorExtra();
                    
               }
            }
        });
        

    }
</script>