<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 27/06/2020
 * Time: 18:05
 */
?>

<div class="container" style="margin-top: 30px">

    <div class="w3-third w3-container" style="margin-bottom: 20px">
        <button onclick="document.getElementById('register').style.display='block'" type="button" class=" btn btn-primary">AJOUTER CLIENT</button>
    </div>
    <div class="w3-third">

        <div class="w3-container w3-hide-small" style="margin-bottom: 20px;margin-top: -20px">
            <span style="font-size: 18px;font-weight: 900; margin-bottom: 10px;">Selectionner un Client</span>
            <form method="POST" action="cart.php">
                <div class="row">
                    <div class="col-7">
                <select class="form-control" id="client" name="client">

                    <?php

                  if($clients){
                        foreach ($clients as $row1) {
                            ?>
                            <option value="<?php echo($row1['id_client']); ?>" ><?php echo $row1['lastname'].' '.$row1['firstname']; ?> </option>

                            <?php
                        }
                    }

                    ?>
                </select>
                        </div>
                    <div class="col-3">
                <button type="submit" class="btn btn-primary" name="validerClient" style="float: left">valider</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="w3-container w3-hide-large w3-hide-medium" style="margin-bottom: 20px;">
            <span style="font-size: 18px;font-weight: 900; margin-bottom: 10px;">Selectionner un Client</span>
            <form method="POST" action="index.php">

                <select class="w3-select w3-border" id="client" name="client" style="width: 50%">

                    <?php

                    if($clients){
                        foreach ($clients as $row1) {
                            ?>
                            <option value="<?php echo($row1['id_customer']); ?>" ><?php echo $row1['name']; ?> </option>

                            <?php
                        }
                    }

                    ?>
                </select>
                <button type="submit" class="btn btn-primary w3-rest" name="validerClient" style="margin-left: 5px">valider</button>
            </form>
        </div>
    </div>
    <div class="w3-third w3-container" style="margin-bottom: 10px">
        <?php
        if(isset($_SESSION['client_name'])){
            echo "CLIENT: <strong>".$_SESSION['client_name']."</strong>";
        }
        else{
            echo "<< Aucun client selectioné >>";
        }

        ?>
    </div>

    <div class="w3-container">
        <div id="product_imei" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                <div class="w3-center"><br>
                    <span onclick="document.getElementById('product_imei').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                    <b>AJOUTER IMEI DES PRODUITS</b>
                </div>

                <form class="w3-container" method="post" action="cart.php">
                    <div class="w3-section">
                        <?php

                        if(isset($_SESSION["cart_item"])){
                        $total_quantity = 0;

                        foreach ($_SESSION["cart_item"] as $item){
                        //$item_price = $item["quantity"]*$item["price"];
                        $item["quantity"];
                            for($i=0; $i < $item["quantity"]; $i++) {
                                ?>

                                <label><b>IMEI pour <?php echo $item['name']; ?></b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                       placeholder="IMEI de produit"
                                       name="<?php echo "imei_" . $item['id_produit'] . $i; ?>" required>
                                <label><b>Numero SIM </b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                       placeholder="Numero de la SIM remise au client"
                                       name="<?php echo "num_" . $item['id_produit'] . $i; ?>" required>

                                <?php
                            }
                        }
                        }
                        ?>




                        <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit" name="valider">VALIDER</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="container">
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
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td style="width: 60%"><?php echo $row1['designation']; ?></td>
                                        <td style="width: 20%">
                                            <?php echo "$ ".$row1['price']; ?>
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
                            <td  style="text-align:left;"><?php echo "$ ". number_format($item_price,1)." CDF"; ?></td>
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
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>