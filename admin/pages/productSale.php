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
        <p>
        <button class="btn btn-secondary" id="today">Today</button>&nbsp; <button class="btn btn-secondary" id="this_week">this week</button>&nbsp;
        <button class="btn btn-secondary" id="this_month">this month</button>
          </p>
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
      <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title" id="chart-title"></b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="prod-bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
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
        ajaxCall(pos,fromDate,toDate);
        
       
    }


    $("#today").on("click",()=>{
      ////console.log(localStorage);
      //alert("hello");
      tableLoading();
      var fromD = $.datepicker.formatDate('yy-mm-dd', new Date());
      var toD = $.datepicker.formatDate('yy-mm-dd', new Date());
        //alert(d);
      ajaxCall(getPOS(),fromD,toD);
    });

    $("#this_week").on("click",()=>{
      tableLoading();
      //alert(moment('yy-mm-dd').day(1));
      //const d = new Date();
      var formatted_date = (date)=>{
                var m = ("0"+ (date.getMonth()+1)).slice(-2); // in javascript month start from 0.
                var d = ("0"+ date.getDate()).slice(-2); // add leading zero 
                var y = date.getFullYear();
                return  y +'-'+m+'-'+d; 
        }
 
        var curr_date =new Date();                
        var day = curr_date.getDay();                
        var diff = curr_date.getDate() - day + (day == 0 ? -6:1); // 0 for sunday                
        var week_start_tstmp = curr_date.setDate(diff);                            
        var week_start = new Date(week_start_tstmp);                 
        var week_start_date =formatted_date(week_start);                 
        var week_end  = new Date(week_start_tstmp);  // first day of week                  
        week_end = new Date (week_end.setDate(week_end.getDate() + 6));                 
        var week_end_date =formatted_date(week_end);     
        //alert(date=week_start_date + ' to '+week_end_date);    // date range for current week 
       /*
         var week_end_date =formatted_date(new Date()); // limit current week date range upto current day.
       */
      ajaxCall(getPOS(),week_start_date,week_end_date);
    });

    $("#this_month").on("click",()=>{
      tableLoading();
      var formatted_date = (date)=>{
                var m = ("0"+ (date.getMonth()+1)).slice(-2); // in javascript month start from 0.
                var d = ("0"+ date.getDate()).slice(-2); // add leading zero 
                var y = date.getFullYear();
                return  y +'-'+m+'-'+d; 
        }
      var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        formated_firstDay = formatted_date(firstDay);
        formated_lastDay = formatted_date(lastDay);
        //alert(formated_firstDay);
      ajaxCall(getPOS(),formated_firstDay,formated_lastDay);
    });

    function ajaxCall(pos,fromDate,toDate){
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
    var datas = mdata;
    /*for(var i=1;i<31;i++){
        datas.push([i,i*2]);
    }
    console.log(datas);
    */


    var bar_data = {
      data : datas,
      color: '#3c8dbc'
    }
    $.plot('#prod-bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
        bars: {
          show    : true,
          barWidth: 0.5,
          align   : 'center'
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 0
      }
    })
    /* END BAR CHART */

}
function tableLoading(){
    $('#tbody').html('<tr><td colspan="3"><div class="text-center" style="position:relative"><p align="center"><i class="fa fa-refresh fa-spin"></i></p></div></td></tr>');
    return 1;
}

function getPOS(){
    var pos = $('#pos_filter').val();
    return pos;
}
</script>