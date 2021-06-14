<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$username = $_SESSION['user']['username'];
$pos = $response->getPOSByUsername($username);
$row=$response->getAllStockPOS($pos);
?>

<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Mon stock</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Stock available</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display nowrap" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
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
                                $p = $response->getOneProductById($item['id_product']);
                                echo $p['designation'];
                                ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php
                                $rate = $response->getRate();
                                if((int)$p['id_category'] !== 4 and (int)$p['id_category'] !== 3 )
                                    echo $rate[0]['rate'] * $p['price'];
                                else
                                    echo $p['price'];
                                ?></td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</div>
</div>
</div>
