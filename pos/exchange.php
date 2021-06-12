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
                <select class="form-control" id="product" name="product">

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
                    <select class="form-control" id="product" name="newproduct">

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
            <input class="form-control" name="oldimei" type="text" placeholder="Old IMEI">
            </p>
        </div>
        <div class="col-6">
            <p>
            <label for="newimei">New IMEI</label>
            <input class="form-control" name="newimei" type="text" placeholder="New IMEI">
            </p>
        </div>

    </div>
        <p>
            <input class="btn btn-primary" name="exchange" type="submit" value="Valider">
        </p>
</form>

</div>
    </div>
    </div>
</div>
</div>
</div>