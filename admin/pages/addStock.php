<?php include_once '../models/Dao_Carte.php' ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Ajouter Stock

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Ajouter Stock</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Stock pour POS</h3> <a href="layout.php?page=stock"><button class="btn btn-primary pull-right" >retour à la liste</button></a>
        </div>
        <!-- /.box-header -->
        <?php
        if(isset($_SESSION['info'])){
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $_SESSION['info']; ?> .
            </div>

            <?php
            unset($_SESSION['info']);
        }
        ?>
        <?php
        if(isset($_SESSION['infoerror'])){
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo $_SESSION['infoerror']; ?> .
            </div>

            <?php
            unset($_SESSION['infoerror']);
        }
        ?>
        <!-- form start -->
        <form role="form" method="post" action="../controllers/StockController.php" enctype="multipart/form-data" id="stockForm">
            <center>
                <div class="box-body" style="width:50%">
                    <input type="hidden" id="action" name="action" value="ajouter" >
                    <div class="form-group" >
                        <label for="exampleInputEmail1">Produit</label>
                        <select class="form-control" id="productId" name="id_product" onchange="productChanged(this)">
                        <option value="">--</option>
                            <?php

                            $response=new Dao_Carte();
                            $rows=$response->getAll();
                            if($rows){
                                foreach ($rows as $row) {
                                    ?>
                                    <option value="<?php echo $row['id_product'].",".$row['id_category']; ?>"><?php echo $row['designation']; ?> </option>
                                    <?php
                                }
                            }
                            else {
                                //die("no data");
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="exampleInputEmail1">Quantité</label>
                        <input type="number" class="form-control form-control" id="qte" name="qte" min="1">
                    </div>
                    <div class="form-group" >
                        <label for="exampleInputEmail1">POS</label>
                        <select class="form-control" name="id_pos" required>
                            <option value="">--</option>
                            <?php

                            $response=new Dao_Carte();
                            $rows=$response->getAllPOS();
                            if($rows){
                                foreach ($rows as $row) {
                                    ?>
                                    <option value="<?php echo $row['id_pos']; ?>"><?php echo $row['designation']; ?> </option>
                                    <?php
                                }
                            }
                            else {
                                //die("no data");
                            }
                            ?>
                        </select>
                    </div>

                    <!--<div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea type="text" class="form-control" id="nom" name="description" placeholder="description du produit">
                    </textarea>
                    </div>-->
                    
                    <div class="form-group" id="imeisField" style="display:none">
                        <label for="exampleInputEmail1">upload imeis</label>
                    <input  type="file" name="imei_csv" id="imei_csv" accept=".csv" onChange="validateAndUploadImei(this);">
                    </div>
                    <div class="form-group"  id="iccidsField" style="display:none">
                        <label for="exampleInputEmail1">upload iccids</label>
                    <input  type="file" name="iccid_csv" id="iccid_csv" accept=".csv" onChange="validateAndUploadIccid(this);" >
                    </div>
                    <div class="form-group"  id="serialsField" style="display:none">
                        <label for="exampleInputEmail1">upload serials</label>
                    <input  type="file" name="serial_csv" id="serial_csv" accept=".csv" onChange="validateAndUploadSerial(this);" >
                    </div>

                </div>

            </center>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="button" id="uploadcsv" class="btn btn-primary pull-right" onclick="validateAndUpload()">Ajouter</button>
            </div>
        </form>
    </div>
    <section class="content">

    </section>

</section>
<script>
    var qt = document.getElementById("qte");
    var imeisQt = 0;
    var iccidQt = 0;
    var  serialQt = 0;
    var errorArray = [false,false,false];
    function productChanged(val){
        $("#imei_csv").val(null);
        $("#iccid_csv").val(null);
        $("#serial_csv").val(null);
        imeisQt = 0;
        serialQt =  0;
        iccidQt = 0;
        if(val.value != ""){
        const mval = val.value.split(',');
        //alert(val.value);
        const category = mval[1];
        //alert(category);
        if(category == 4){
            document.getElementById("imeisField").style.display ="none";
            document.getElementById("iccidsField").style.display  ="none";
            document.getElementById("serialsField").style.display  ="none";
        }else if(category == 5){
            document.getElementById("imeisField").style.display ="none";
            document.getElementById("iccidsField").style.display  ="block";
            document.getElementById("serialsField").style.display  ="none";
        }else if(category == 3){
            document.getElementById("imeisField").style.display ="none";
            document.getElementById("iccidsField").style.display  ="none";
            document.getElementById("serialsField").style.display  ="block";
        }else{
            document.getElementById("imeisField").style.display ="block";
            document.getElementById("iccidsField").style.display  ="block";
            document.getElementById("serialsField").style.display  ="none";
            

        }
    }else{
        document.getElementById("imeisField").style.display ="none";
            document.getElementById("iccidsField").style.display  ="none";
            document.getElementById("serialsField").style.display  ="none";
    }
    }
    
function validateAndUpload(){
    //var file = input.files[0];
   /* var nme = document.getElementById("iccid_csv");
    var nme2 = document.getElementById("imei_csv");
    var impbtn = document.getElementById("uploadcsv");
    
    
    if(nme.value.length > 3 && nme2.value.length > 3 && qt.value > 0){
        impbtn.disabled = false;
    }else{
        impbtn.disabled = true;
    }*/
    //alert("clicked");
    var productWithCategory = $( "#productId" ).val();
    var splitPdtCtg = productWithCategory.split(",");
    var cat = splitPdtCtg[1];
    //alert(cat);
    if(cat == 4){
        document.getElementById('stockForm').submit();
    }else if(cat == 3){
        if(qt.value == serialQt){
            if (confirm("Etes vous sure de valider ces informations")) {
                //txt = "You pressed OK!";
                document.getElementById('stockForm').submit();
            } else {
                //txt = "You pressed Cancel!";
            }
            
        }else{
            alert("QUANTITE SERIALS DOIT ETRE EGALE A LA QUANTITE MENTIONEE");
        }
    }else{
        if(iccidQt == imeisQt && imeisQt == qt.value){
            if (confirm("Etes vous sure de valider ces informations")) {
                //txt = "You pressed OK!";
                document.getElementById('stockForm').submit();
            } else {
                //txt = "You pressed Cancel!";
            }
        }else{
            alert("QUANTITE IMEIs DOIT ETRE EGALE A QUANTITE ICCIDs");
        }

    }
   
    
    

}
function validateAndUploadImei(input){
    var file = input.files[0];
    //console.log(file);
    //var nme = document.getElementById("csv");
    const reader = new FileReader();
    reader.onload = (e) => {
        const text = e.target.result; // the CSV content as string
        const data = csvToArray(text);
        qt.value  = data.length;
        imeisQt = data.length;
  console.log(data);

};
reader.readAsText(file);

}
function validateAndUploadIccid(input){
    var file = input.files[0];
    //console.log(file);
    //var nme = document.getElementById("csv");
    const reader = new FileReader();
    reader.onload = (e) => {
        const text = e.target.result; // the CSV content as string
        const data = csvToArray(text);
        iccidQt  = data.length;
  console.log(data);

};
reader.readAsText(file);
}

function validateAndUploadSerial(input){
    var file = input.files[0];
    //console.log(file);
    //var nme = document.getElementById("csv");
    const reader = new FileReader();
    reader.onload = (e) => {
        const text = e.target.result; // the CSV content as string
        const data = csvToArray(text);
        qt.value  = data.length;
        serialQt = data.length;
  console.log(data);

};
reader.readAsText(file);
}

function csvToArray(str, delimiter = ",") {

  const headers = str.slice(0, str.indexOf("\n")).split(delimiter);

  const rows = str.slice(str.indexOf("\n") + 1).split("\n");

  const arr = rows.map(function (row) {
    const values = row.split(delimiter);
    const el = headers.reduce(function (object, header, index) {
      object[header] = values[index];
      return object;
    }, {});
    return el;
  });

  // return the array
  return arr;
}
 
 
</script>