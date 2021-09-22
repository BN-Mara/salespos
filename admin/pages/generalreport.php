<?php include_once '../models/Dao_Carte.php' ?>
<?php

$response=new Dao_Carte();
$vente_txt = "";
$row=$response->getAll();

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $vente_txt; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tous les produits</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
        <div class="row">
                <div class="col-lg-4 form-group">
                    <label>POS</label>
                <select id="pos_filter" class="form-control">
            <!--<option>--</option>-->
                <?php
                $poses = $response->getAllPOS();
                foreach($poses as $pos){
                    ?>
                   <option value="<?php echo  $pos['id_pos']; ?>">
                   <?php echo $pos['designation']; ?>
                   </option>
                    <?php
                }

                ?>

            </select>
                </div>
                <div class="col-lg-4 ">
                    <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label>From</label>
                            <input type="date" id="fromdate" name="fromdate" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group-sm">
                            <label>To</label>
                            <input type="date" id="todate" name="todate" class="form-control">
                        </div>
                    </div>
            </div>
            <div class="col-lg-4"></div>
            </div>
        </div>
        <!-- /.box-header -->
    
        <!-- form start -->

        <div class="box-body" id="boxbody">
            <table id="example0" class="table table-bordered table-striped">
                <thead>
                    <tr><th colspan="3"><div class="text-center" style="position:relative" id="ttitle"> POS</div></th></tr>
                <tr>

                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Price (CDF)</th>
                    


                </tr>
                </thead>
                <tbody id="tbody">
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
                            <td><?php echo $item['designation']; ?></td>
                            <td><?php
                                
                                $qte = $response-> getPOSProductSaleQteById($item['id_product'],1);
                                if($qte){
                                    echo $qte;

                                }else
                                echo "0";
                                
                                ?></td>
                            <td><?php
                                
                                $t = $response->getPOSTotalPriceProductSaleById($item['id_product'],1);
                                if($t){
                                    echo $t;

                                }else
                                echo "0";
                                ?></td>

                        </tr>

                    <?php }}?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Price (CDF)</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- /.box-body -->



    </div>

      <!-- Bar chart -->
      <!-- BAR CHART -->
      <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.nav-tabs-custom -->
</section>
<script>
    var t = "";
    
    $(document).ready(function(){ 
        $('#ttitle').html($('#pos_filter option:selected').text());
        $('#chart-title').html($('#pos_filter option:selected').text());
        
         
    t = $('#example0').DataTable({
      dom: 'Blfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
    });

    findReport();
    $('#pos_filter, #fromdate, #todate').change(function() {
       // alert("hello");
        /*var form = this.closest("form");
        $.post("search.php", form.serialize(), function(data) {
            $('#show_data').html(data);
        });  */
        findReport();
    });  
});
 function findReport(){
        //alert(client);
        $('#ttitle').html($('#pos_filter option:selected').text());
        $('#chart-title').html($('#pos_filter option:selected').text());
        $('#tbody').html('<tr><td colspan="3"><div class="text-center" style="position:relative"><p align="center"><i class="fa fa-refresh fa-spin"></i></p></div></td></tr>');
        var pos = $('#pos_filter').val();
        var fromDate = $('#fromdate').val();
        var toDate = $('#todate').val();
        
        var formData = {
            'pos_id':pos,
            'fromdate':fromDate,
            'todate':toDate,
            'action':"report_sales"
        }
        $.ajax({
            type: "post",
            url: "../controllers/CommonController.php",
            data: formData,
            success: function (data) {
                //console.log(data);
                
                data = $.parseJSON(data);
                //console.log(data);
               //$('#tbody').html('');
               //$('#example2').children('tr').remove();
               var datas = [];
               t.clear().draw();

                data.forEach((v,i)=>{
                    //console.log($('#example2'));
                    datas.push([v.designation,v.qte < 1?"0":v.qte])
                    //t.row.add("<tr><td>"+v.designation+"</td><td>"+v.qte+"</td><td>"+v.total+"</td></tr>");
                    t.row.add([
                        v.designation,
                        v.qte < 1?"0":v.qte,
                        v.total < 1?"0":v.total
                    ]).draw(true);
                });
                myChart(datas);
               // $('#boxbody table').remove();
                //$('#boxbody').html(data);
                //$('#boxbody table').attr('id',"example2");             
                
            }
        });
    }
    
function myChart(mdata){
    var datas = [];//mdata;
    var mlabel = [];
    var colors = "";
    for(var i=0;i<30;i++){
       colors = random_rgba();
        datas.push({
            label: 'product '+i,
            fillColor           : ''+colors,
          strokeColor         : ''+colors,
          pointColor          : ''+colors,
          pointStrokeColor    : ''+colors,
          pointHighlightFill  : '#fff',
          pointHighlightStroke: ''+colors,
          data                : [65+i, 59+i, 80+i, 81+i, 56+i, 55+i, 40+i,7+i,8+i,9+i,
          9+i,8+i,9+i,8+i,7+i,8+i,9+i,5+i,4+i,78+i,4,5+i,8+i,42+i,47,88+i,77+i,99+i,44,55,44]

        });
        mlabel[i] = ''+i;
    }
    console.log(datas);
    var areaChartData = {
      labels  : mlabel,
      datasets: datas
    }


       //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

}
var arrColors = [];   
function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    var cl = 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
    for(var k = 0; k < arrColors.length; k++){
        if(cl == arrColors[k]){
            random_rgba();
        }
    }
    arrColors.push(cl);
    return cl;
}


</script>