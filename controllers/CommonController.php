<?php
session_start();
include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{  
    $dao = new Dao_Carte();
    if(isset($_POST['idRef'])){
        
        $common = new CommonController($dao);
        $data = $common->getSalesDetails($_POST['idRef']);
        echo $data;
    }
    if(isset($_POST['action']) && $_POST['action'] == "report_sales"){
        $common = new CommonController($dao);
        $common->getSalesReport();
    }

}

class CommonController{
    private $dao;

    public function __construct(Dao_Carte $dao)
    {
        $this->dao = $dao;
    }
    public function getSalesDetails($idRef){
        $data = $this->dao->detailSalesPOS($idRef);
        $data = json_encode($data);
        return $data;

    }
    public function getSalesReport(){
        $pos = $_POST["pos_id"];
        $fromDate = $_POST["fromdate"];
        $toDate = $_POST["todate"];
        if($toDate == "" || $toDate  == null){
            $toDate = date('Y-m-d');
        }
        //$toDate == date('Y-m-d');
        //die(var_dump($toDate));
        $arrayData = array();
        $products = $this->dao->getAll();
        if($products){
            $count = 0;
            foreach($products as $p){
                $qte = $this->dao->getPOSProductSaleQteByIdDate($p['id_product'],$pos,$fromDate,$toDate);
                $total = $this->dao->getPOSTotalPriceProductSaleByIdDate($p['id_product'],$pos,$fromDate,$toDate);
                $arrayData[$count] = ['product'=>$p['id_product'],'designation'=>$p['designation'],'qte'=>$qte,'total'=>$total];
                $count++;
            }
        }

        echo json_encode($arrayData);
        //$mtable = $this->makeHtmlTable($arrayData);
        //echo $mtable;
    }
    public function makeHtmlTable($data){
        $rows = $this->tableRow($data);
        $html = '<table id="example2" class="table table-bordered table-striped">';
        $html .='<thead>';
        $html .='<tr>';
        $html .='<th>Item</th>';
        $html .='<th>Quantity</th>';
        $html .='<th>Total Price (CDF)</th>';            
        $html .='</tr>';
        $html .='</thead>';
        $html .='<tbody id="tbody">';
        $html .= $rows;
        $html .='</tbody>';
        $html .='<tfoot>';
        $html .='<tr>';
        $html .='<th>Item</th>';
        $html .='<th>Quantity</th>';
        $html .= '<th>Total Price (CDF)</th>';
        $html .= '</tr>';
        $html .= '</tfoot>';
        $html .= '</table>';
        $html .='</div>';
        return $html;
        
    }
    public function tableRow($data){
        $rows = "";
        foreach($data as $d){
            $rows.="<tr><td>".$d['designation']."</td><td>".$d['qte']."</td><td>".$d['total']."</td></tr>";
        }
        return $rows;
    }
    
}