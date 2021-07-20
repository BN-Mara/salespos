<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 26/07/2020
 * Time: 12:53
 */

$response = new Dao_Carte();
$factures = $response->getAllSaleReference();
$products = $response->getPOSProducts($pos);;
$plaintes = $response->getAllPlainte();
$allpos =  $response->getAllPOS();
?>

<div class="container" >

<div class="row">

<!-- Area Chart -->
<div class="col-12">
    <div class="card shadow mb-4 white">
    <!-- Card Header - Dropdown -->

    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Transfert Stock</h6>
    </div>
    <div class="card-body">


<div class="container">
    <form method="post" action="cart.php">       
    <div class="row">
        <div class="col-6">
        <p>
                <label for="product">Produit</label>
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
        <div class="col-6">
            <p>
            <label for="newimei">Quantite</label>
            <input class="form-control" name="quantity" type="text" placeholder="New IMEI">
            </p>
        </div>

    </div>
    <div class="row">
            <div class="col-12">
                <p>
                    <label for="product">Transferer a</label>
                    <select class="form-control" id="product" name="newproduct">

                        <?php

                        if($allpos){
                            foreach ($allpos as $row) {
                                ?>
                                <option value="<?php echo($row['id_pos']); ?>" ><?php echo $row['designation']; ?> </option>

                                <?php
                            }
                        }

                        ?>
                    </select>
                </p>
            </div>


        </div>
        <p>
            <input class="btn btn-primary" name="transfer" type="submit" value="Valider">
        </p>
        
</form>
</div>

    </div>
    </div>
</div>
</div>
</div>