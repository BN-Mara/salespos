<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 27/06/2020
 * Time: 18:05
 */
$allpos = $response->getAllPOs();
?>

<div class="container" style="margin-top: 30px">
<h3>Transfer Stock</h3>
    <form>
        
        <div class="row">

            <div class="col-6">
            <label for="product">Select POS</label>
                <select class="form-control" id="pos" name="id_pos" onchange="setPOS(this.value)">
                    <option value="">-- Choisir --</option>
                    <?php

                    if($allpos){
                        foreach ($allpos as $row) {
                            ?>
                            <option value="<?php echo($row['id_pos']); ?>" <?php if(isset($_SESSION['id_pos_to']) && $_SESSION['id_pos_to'] == $row['id_pos']) {echo 'selected';} ?> ><?php echo $row['designation']." | ".$row['city']; ?> </option>

                            <?php
                        }
                    }

                    ?>
                </select>
            </div>
            <div class="col-6">
            <p class="text-success">Select the POS to which this sock will be transfered</p>
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
                    <b>AJOUTER IMEI DES PRODUITS</b>
                </div>

                <form class="w3-container" method="post" action="transfer.php">

                        <?php

                        if(isset($_SESSION["transfer_item"])){
                            //die($_SESSION["transfer_item"]);
                           
                        $total_quantity = 0;

                        foreach ($_SESSION["transfer_item"] as $item){
                        //$item_price = $item["quantity"]*$item["price"];
                        //var_dump($item["quantity"]);
                        //$item["quantity"];
                            for($i=0; $i < $item["quantity"]; $i++) {
                                
                                if($item["category"] != 4){
                                    
                                ?>

                        <div class="w3-section tab" id="tab">
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
                                       onKeyDown="if(this.value.length==10) return false;"
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
                            </div>
                                    <?php
                                }
                            }
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

            </div>
        </div>
    </div>

    <div class="fluid">
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
                        <form method="POST" action="transfer.php">
                            <input  type="hidden" name="produit" value="<?php echo $row1['id_product']; ?>" >
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td style="width: 60%"><?php echo $row1['designation']; ?></td>
                                        <td style="width: 20%">
                                            <?php $pr = ($row1['price'] * $taux[0]['rate']); echo $pr." CDF"; ?>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="qt" min="1" value="1" required style="width:100px">
                                        </td>
                                        <td><input type="submit" class="btn btn-primary form-control" name="addtocart" value="ADD" style="margin-left: 5px"></td>
                                    </tr>
                                    </tbody>
                                </table>
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
    <div class="w3-col l8 w3-white" style="margin-bottom: 10px">
        <div class="w3-card-2" >
            <header class="w3-container w3-center">
                <h3>COMMANDE</h3>
                <hr>

            </header>

            <?php
            if(isset($_SESSION["transfer_item"])){
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
                    foreach ($_SESSION["transfer_item"] as $item){
                        $item_price = $item["quantity"]*$item["price"];
                        ?>
                        <tr>
                            <td><?php echo $item["name"]; ?></td>
                            <td><?php echo $item["code"]; ?></td>
                            <td style="text-align:left;"><?php echo $item["quantity"]; ?></td>
                            <td  style="text-align:left;"><?php echo "".number_format($item["price"],1)." CDF"; ?></td>
                            <td  style="text-align:left;"><?php echo "". number_format($item_price,1)." CDF"; ?></td>
                            <td style="text-align:center;"><a href="transfer.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="images/remove.png" alt="Remove Item" width="20" height="20" /></a></td>
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
    <div class="w3-col l4 w3-card-2 w3-white">
        <table class="w3-table w3-striped" cellpadding="10" cellspacing="1">
            <tr>

                <td><?php echo $total_quantity; ?> articles </td>
                <td><?php echo "".number_format($total_price, 2)." CDF"; ?></td>

            </tr>
            <tr>
                <td>Taxe </td><td>  0.00 CDF </td>
            </tr>
            <tr>
                <td>TOTAL GNERAL  </td><td><?php echo "".number_format($total_price, 2)." CDF"; ?></td>
            </tr>
        </table>
            <p>

                <button onclick="document.getElementById('product_imei').style.display='block'" class="w3-btn w3-green w3-rest w3-right">CONFIRMER</button>

            </p>

        <br><br>

    </div>



</div>
<script>

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
                    url: " transfer.php",
                    data: "getname=" + value,
                    success: function (data) {
                        if(data != "no"){
                            $("#checkname").html(data);
                        }
                        else{
                            $("#checkname").html('');
                            $("#cust_name").val(value);
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
                    url: "transfer.php",
                    data: "getphone=" + value,
                    success: function (data) {
                        if(data != "no"){
                            $("#checkphone").html(data);
                        }
                        else{
                            $("#checkphone").html('');
                            $("#cust_phone").val(value);
                        }
                    }
                });

        });
        

    });
    function setPOS(pos){
        alert(pos);
        $.ajax({
            type: "post",
            url: "transfer.php",
            data: "setpos=" + pos,
            success: function (data) {
                console.log(data);
                data = $.parseJSON(data);
                $("#pos").val(data['pos']);
               
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
