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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Nombre d'article</th>
                    <th>Prix total</th>
                    <th>Reference</th>
                    <th>date</th>
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
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</div>
</div>
</div>
