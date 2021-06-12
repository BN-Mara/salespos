<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$username = $_SESSION['user']['username'];
$pos = $response->getPOSByUsername($username);
$row=$response->getAllPlainte();
?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Complaint list</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Complaints</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID Complaint</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Solution</th>
                        <th>Status</th>
                        <th>Date</th>
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
                                <td><?php echo $item['id_plainte']; ?></td>
                                <td><?php
                                    $p = $response->getPlainteTypeById($item['id_type']);
                                    echo $p['designation'];
                                    ?></td>
                                <td><?php echo $item['description']; ?></td>
                                <td><?php echo $item['solution']; ?></td>
                                <td><?php echo $item['status']; ?></td>
                                <td><?php echo $item['creation_date']; ?></td>

                            </tr>

                        <?php }}?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID Complaint</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Solution</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
</div>
