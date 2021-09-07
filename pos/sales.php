<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 27/06/2020
 * Time: 18:05
 */
//$taux = $response->getRate();
?>

<div class="container" style="margin-top: 30px">

    <form>
        <h3>Client</h3>
        <div class="row">

            <div class="col-lg-6">
                <label>
                    Noms 
                    <input class="form-control" type="text" value="<?php if(isset($_SESSION['client_name'])){echo $_SESSION['client_name'];}
                    if(isset($_SESSION['newclient_name'])){echo $_SESSION['newclient_name'];}?>" placeholder="nom complet du client" id="cust_name" style="width:100%">
                (nom postnom prenom)
                </label>
            </div>
            <div class="col-lg-6">
                <label>
                    Numero de telephone
                    <input class="form-control" type="text" value="<?php if(isset($_SESSION['client_phone'])){echo $_SESSION['client_phone'];}
                    if(isset($_SESSION['newclient_phone'])){echo $_SESSION['newclient_phone'];}?>" id="cust_phone" placeholder="Numero de telephone" style="width:100%">
                </label>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-6">
        <ul class="list-group" id="checkname"></ul>
        </div>
        <div class="col-6">
            <ul class="list-group" id="checkphone"></ul>
        </div>
    </div>
    <hr>


    <div class="w3-container">
        <div id="product_imei" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                <div class="w3-center"><br>
                    <span onclick="document.getElementById('product_imei').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                    <b>INFOS SUPPLEMENTAIRES DES PRODUITS</b>
                </div>
            <?php
            //$keys = array_keys($_SESSION["cart_item"]);
            //var_dump($keys[0]);
            //foreach()
            if(false/*isset($_SESSION["cart_item"]) && count($_SESSION["cart_item"])==1 && $_SESSION["cart_item"][(array_keys($_SESSION["cart_item"])[0])]["category"] == 4*/){
                ?>
                <form class="w3-container" method="post" action="cart.php">
                <button class="w3-btn w3-border-green w3-border" name="valider" type="submit">Valider</button>
                <form>
    <?php
            }else{

            
            ?>
                <form class="w3-container" method="post" action="cart.php">

                        <?php
                        //var_dump(count($_SESSION["cart_item"]));

                        if(isset($_SESSION["cart_item"])){
                            //die($_SESSION["cart_item"]);
                           
                        $total_quantity = 0;
                        $isevc = true;

                        foreach ($_SESSION["cart_item"] as $item){
                        //$item_price = $item["quantity"]*$item["price"];
                        //var_dump($item["quantity"]);
                        //$item["quantity"];
                        ?>

                        <div class="w3-section tab" id="tab">
                            <?php
                            for($i=0; $i < $item["quantity"]; $i++) {
                                
                                if($item["category"] != 4){
                                    
                                ?>

                        
                            <?php
                           
                            if($item["category"] == 3){
                                
                                ?>
                            <label><b>Serial pour scratch <?php echo $item['name']." (".($i+1).")"; ?> </b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                   placeholder="scratch serial"
                                   id="<?php echo "serial_" . $item['id_produit'] . $i; ?>"
                                   name="<?php echo "serial_" . $item['id_produit'] . $i; ?>" required
                                   ?>)">

                            <?php
                            }
                            else{
                                if($item["category"] != 5)
                                {
                                ?>
                                
                                <label><b>IMEI pour <?php echo $item['name']." (".($i+1).")"; ?></b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number"
                                       placeholder="IMEI de produit"
                                       id="<?php echo "imei_" . $item['id_produit'] . $i; ?>"
                                       name="<?php echo "imei_" . $item['id_produit'] . $i; ?>" required 
                                       onKeyDown="if(this.value.length==15) return false;"
                                       onclick="removeAfterImei(this.id)"
                                       onBlur="checkImeiPOS(this.value,this.id,<?php echo $item['id_produit'];?>)">
                                <label><b>Numero SIM </b></label>
                                <?php 
                                       }else{
                                           ?>
                                           <label><b>MSISDN pour <?php echo $item['name']." (".($i+1).")"; ?></b></label>
                                    <?php   
                                    }
                                       ?>
                                
                                <input class="w3-input w3-border w3-margin-bottom" type="number"
                                       placeholder="Numero de la SIM remise au client"
                                       id="<?php echo "num_" . $item['id_produit'] . $i; ?>"
                                       name="<?php echo "num_" . $item['id_produit'] . $i; ?>" required 
                                       onKeyDown="if(this.value.length==9) return false;"
                                       onclick="removeAfterMsisdn(this.id)"
                                       onBlur="checkMsisdnPOS(this.value,this.id,<?php echo $item['id_produit']; ?>)">
                                <label><b>ICCID </b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number"
                                       placeholder="Numero de la SIM remise au client"
                                       id="<?php echo "iccid_" . $item['id_produit'] . $i; ?>"
                                       name="<?php echo "iccid_" . $item['id_produit'] . $i; ?>" required 
                                       onKeyDown="if(this.value.length==10) return false;"
                                       onclick="removeAfterIccid(this.id)"
                                       onBlur="checkIccidPOS(this.value,this.id,<?php echo $item['id_produit']; ?>)">

                            <?php
                            }
                            ?>
                            
                                    <?php
                                }else{
                                    $countevc = 0;
                                    if($countevc == 0){

                                    
                                    ?>
                                    <label><b>Numero</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number"
                                       placeholder="Numero a recharger"
                                       id="<?php echo "evc_" . $item['id_produit'] . $i; ?>"
                                       name="<?php echo "evc_" . $item['id_produit'] . $i; ?>"
                                       onKeyDown="if(this.value.length==13) return false;"
                                       onkeyup="evccheck(this.value,this.id)" required >
                                    <?php
                                    break;
                                    $countevc +=1;
                                    }
                                }
                                
                            }
                            ?>
                                </div>
                                <?php
                        }
                        }
                        ?>



                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button class="w3-btn w3-border-green w3-border" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button class="w3-btn w3-border-green w3-border" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </form>
                <?php
            }
            ?>
            </div>
        </div>
    </div>

    <div class="">
        <?php
        echo '<h1 class="text-center">'.$showing."</h1>";

        ?>
        <p></p>
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        <br>
        <ul class="list-group" id="myList">
            <?php

            if($produits){
                foreach ($produits as $row1) {
                    ?>
                    <li class="list-group-item">
                        <form method="POST" action="cart.php">
                            <input  type="hidden" name="produit" value="<?php echo $row1['id_product']; ?>" >
                            <div class="row">
                                
                                        <div class="col-lg-4" ><?php echo $row1['designation']; ?></div>
                                        <div class="col-lg">
                                            <?php $pr = ($row1['price'] * $taux[0]['rate']); echo $pr." CDF"; ?>
                                        </div>
                                        <div class="col-lg">
                                        <span class="text-primary"> Quantite</span> <input class="form-control" id="<?php echo "qt_".$row1['id_product'];  ?>" type="number" name="qt" min="1" step="any" value="1" required >
                                        </div>
                                       
                                        <div class="col-lg">
                                        <?php
                                        if($row1['id_category']  == 4){

                                       ?>
                                            <span class="text-success">Montant CDF</span> <input class="form-control" id="amount" type="number" name="amount" min="1" value="" onkeyUp="setAmountQuantity(this.value,<?php echo $row1['id_product'] ?>,<?php echo $pr ?>)" >
                                            <?php
                                         }
                                        ?>
                                        </div>
                                        
                                        <div class="col-lg"><input type="submit" class="btn btn-primary form-control mx-auto" name="addtocart" value="ADD" style="margin-top: 1rem;width: 7rem"></div>
                                    
                            </div>
                        </form>
                    </li>

                    <?php
                }
            }

            ?>
        </ul>
    </div>
<p></p>

</div>

<div id="cart" class="w3-row-padding ">
    <div class="w3-col l8" style="margin-bottom: 10px">
        <div class="w3-card-2 w3-white rounded-lg" >
            <header class="w3-container w3-center">
                <h3>COMMANDE</h3>
                <hr>

            </header>

            <?php
            if(isset($_SESSION["cart_item"])){
                $total_quantity = 0;
                $total_price = 0;
                ?>
                <table class="w3-table-all w3-small" cellpadding="10" cellspacing="1" >
                    <tbody>
                    <tr class="w3-blue-gray">
                        <th style="text-align:left;">Name</th>
                        <th style="text-align:left;">Code</th>
                        <th style="text-align:left;">Qte</th>
                        <th style="text-align:left;">Prix</th>
                        <th style="text-align:left;">total</th>
                        <th style="text-align:center;">Supp.</th>
                    </tr>
                    <?php
                    foreach ($_SESSION["cart_item"] as $item){
                        $item_price = $item["quantity"]*$item["price"];
                       
                        ?>
                        <tr>
                            <td><?php echo $item["name"]; ?></td>
                            <td><?php echo $item["code"]; ?></td>
                            <td style="text-align:left;"><?php echo $item["quantity"]; ?></td>
                            <td  style="text-align:left;"><?php echo "".number_format($item["price"],1)." CDF"; ?></td>
                            <td  style="text-align:left;"><?php echo "". number_format($item_price,1)." CDF"; ?></td>
                            <td style="text-align:center;"><a href="cart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="images/remove.png" alt="Remove Item" width="20" height="20" /></a></td>
                        </tr>
                        <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["price"]*$item["quantity"]);
                        
                        
                    }
                    ?>

                    </tbody>
                </table>
                <?php
            } else {
                ?>
                <div class="w3-container w3-center"><p style="color: green">AUCUN PRODUIT DANS LA COMMANDE</p></div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="w3-col l4 w3-card-2 w3-white rounded-lg">
        <table class="w3-table w3-striped" cellpadding="10" cellspacing="1">
            <tr>
                <td>Taxe </td><td>  0.00 CDF </td>
            </tr>
            <tr>
                <td>TOTAL GNERAL  </td><td><?php echo "".number_format($total_price, 2)." CDF"; ?></td>
            </tr>
        </table>
            <p>

                <button onclick="document.getElementById('product_imei').style.display='block'" class="btn btn-success w3-right" style="margin-top:0.5rem">CONFIRMER</button>

            </p>

        <br><br>

    </div>



</div>
<script>

function evccheck(val,id){
    if(val > 8){
        document.getElementById('nextBtn').disabled = false;
    }else{
        document.getElementById('nextBtn').disabled = true;
    }
}
function setAmountQuantity(amt,id_qt,pr){
    var id = "qt_"+id_qt;
    var qt = amt/pr
    qt = parseFloat(qt).toFixed(3);
    qt = Math.floor(qt);
   document.getElementById(id).value = qt;

}
    $(document).ready(function(){
        //alert("hello");
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#cust_name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            //alert(value);
                //("#checkname").html
                $.ajax({
                    type: "post",
                    url: " cart.php",
                    data: "getname=" + value,
                    success: function (data) {
                        if(data != "no"){
                            $("#checkname").html(data);
                        }
                        else{
                            $("#checkname").html('');
                            //$("#cust_name").val(value);
                        }
                    }
                });

        });

        $("#cust_phone").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            //alert(value);

                //("#checkname").html
                $.ajax({
                    type: "post",
                    url: "cart.php",
                    data: "getphone=" + value,
                    success: function (data) {
                        if(data != "no"){
                            $("#checkphone").html(data);
                        }
                        else{
                            $("#checkphone").html('');
                            //$("#cust_phone").val(value);
                        }
                    }
                });

        });
        

    });
    function valid_client(client){
        //alert(client);
        $.ajax({
            type: "post",
            url: "cart.php",
            data: "setclient=" + client,
            success: function (data) {
                data = $.parseJSON(data);
                $("#cust_name").val(data['lastname']+' '+data['firstname']);
                $("#cust_phone").val(data['phone']);
                $("#checkphone").html('');
                $("#checkname").html('');
            }
        });
    }
    function removeAfterImei(fieldId){
        $(".validationImei").remove();
    }
    function removeAfterIccid(fieldId){
        $(".validationIccid").remove();
    }
    function removeAfterMsisdn(fieldId){
        $(".validationMsisdn").remove();
    }
    function removeAfterSerial(fieldId){
        $(".validationSerial").remove();
    }

    var errorExtra = [false,false];
    checkErrorExtra();
    function checkErrorExtra(){
        if(errorExtra[0] && errorExtra[1]){
            document.getElementById('nextBtn').disabled = false;
            
        }else{
            document.getElementById('nextBtn').disabled = true;
        }
    }

    
    function checkImeiPOS(value,fieldId,id){
        //alert(fieldId);
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
                   errorExtra[0] = false;
                   checkErrorExtra();
               }else{
                    errorExtra[0] = true;
                    checkErrorExtra();
               }
            }
        });

    }
    function checkIccidPOS(value,fieldId,id){
        //alert(value+id);
        var formData = {
            check_extra_iccid:"check_extra_iccid",
            id_product: id,
            iccid: value
        };
        $.ajax({
            type: "post",
            url: "cart.php",
            data: formData,
            success: (data) =>{
                data = $.parseJSON(data);
               console.log(data);
               if(data.iccid == 0){
                   //document.getElementById(fieldId). ="invalid";
                   $('#'+fieldId).after("<span class='validationIccid' style='color:red; padding-bottom:10px'> ICCID n\'est pas dans votre stock.<br></span>");
                   //$('#nextBtn').prop("disabled", true )
                   errorExtra[1] = false;
                   checkErrorExtra()
               }else{
                     errorExtra[1] = true;
                     checkErrorExtra()
               }
            }
        });

    }
    function checkMsisdnPOS(value,fieldId,id){
        //alert(value+id);
        var formData = {
            check_extra_msisdn:"check_extra_msisdn",
            id_product: id,
            msisdn:value
        };
        $.ajax({
            type: "post",
            url: "cart.php",
            data: formData,
            success: (data) =>{
                data = $.parseJSON(data);
               console.log(data);                              
               if(data.msisdn == 0){
                   //document.getElementById(fieldId). ="invalid";
                   $('#'+fieldId).after("<span class='validationMsisdn' style='color:red; padding-bottom:10px'> MSISDN n'est pas dans votre stock.<br></span>");
                   //$('#nextBtn').prop("disabled", true )
                   errorExtra[2] = false;
                   checkErrorExtra();
               }else{
                     errorExtra[2] = true;
                     checkErrorExtra();
               }
            }
        });

    }


</script>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
            document.getElementById("nextBtn").type = "submit";
            document.getElementById("nextBtn").name ="valider";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
   
        
    var id_client = '<?php echo isset($_SESSION["id_client"])? $_SESSION["id_client"] : ""; ?>';
        if(id_client !== ''){
            document.getElementById("client").value = id_client;
        }
   
</script>
