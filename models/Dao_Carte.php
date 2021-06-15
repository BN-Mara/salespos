<?php

/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 11/02/2019
 * Time: 18:16
 */
require 'ConnexionBD.php';
class Dao_Carte extends Connexion
{


    /**
     * Dao_ constructor.
     */
    public function __construct()
    {
    }
    public function getAll()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE isDeleted <> 1");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAllByType($type)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE id_category = :produit_type AND isDeleted <> 1");
            $query->execute(array('produit_type'=>$type));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAllToSale()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE id_category NOT IN (3,4) AND isDeleted <> 1");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAllBySearch($search)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE name LIKE CONCAT('%', :search, '%') AND isDeleted <> 1");
            $query->execute(array('search'=>$search));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAllStock()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_stock");
            $query->execute();
            return $row = $query->fetchAll();

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getAllStockPOS($pos)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_stock WHERE id_pos = :pos");
            $query->execute(array('pos'=>$pos));
            return $row = $query->fetchAll();

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }






    public function addProduit(Product $product)
    {
        try
        {
            $sql = "INSERT INTO bn_product(code,designation,price,id_category,addedBy)
			VALUES (:code,:designation,:price,:id_category,:addedBy)";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'code'=>$product->getCode(),
                'designation'=>$product->getDesignation(),
                'price'=>$product->getPrice(),
                'id_category'=>$product->getIdCategory(),
                'addedBy'=>$product->getAddedBy()
            ));
            return 'success';

        }

        catch (Exception $e)
        {
            //return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function addStock(Stock $stock)
    {
        try
        {
            //$row = $this->getCodeProduit($code);
            //$id_produit = $row['id_produit'];

            //$qte = $qte + $stock->getQuantity();
            $sql = "INSERT INTO bn_stock(id_product,quantity,id_pos)
			VALUES (:id_product,:quantity,:id_pos)";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'id_product'=>$stock->getIdProduct(),
                'quantity'=>$stock->getQuantity(),
                'id_pos'=>$stock->getIdPos()

            ));
            return 'success';

        }

        catch (Exception $e)
        {
            return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }



    //modify by bn-mara
    public function editProduit(Product $product,$id)
    {
        try
        {
            //die($fichier->getCode());
            $sql1 = "INSERT INTO bn_product_hist SELECT * FROM bn_product WHERE id_product = :id_product";
            $query = $this->getConnexion()->prepare($sql1);
            $query->execute(["id_product"=>$id]);

            $sql = "UPDATE bn_product SET code=:code,designation=:designation,price=:price,id_category=:id_category, 
            modifyBy=:modifyBy, modificationTime = GETDATE() WHERE id_product = :id_produit";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'designation'=>$product->getDesignation(),
                'price'=>$product->getPrice(),
                'code'=>$product->getCode(),
                'id_category'=>$product->getIdCategory(),
                'id_produit'=>$id,
                'modifyBy'=>$product->getAddedBy()

            ));
            return 'success';

        } catch (Exception $e) {
            //return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addStockTransaction(Stock $stock,$addedBy)
    {
        try
        {
            $row = $this->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
            $id_stock = $row['id_stock'];

                $sql = "INSERT INTO bn_transaction(id_stock,quantity,id_pos,addedBy)
			VALUES (:id_stock,:quantity,:id_pos,:addedBy)";

                $query = $this->getConnexion()->prepare($sql);
                $query->execute(array(
                    'id_stock'=>$id_stock,
                    'quantity'=>$stock->getQuantity(),
                    'id_pos'=>$stock->getIdPos(),
                    'addedBy'=>$addedBy

                ));



            return 'success';

        }

        catch (Exception $e)
        {
            //return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function editProductStock(Stock $stock)
    {
        try
        {
            $row = $this->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
            $qt = (int)$row['quantity'] + (int)$stock->getQuantity();


                $sql = "UPDATE bn_stock SET quantity =:qte WHERE id_product=:id_product AND id_pos=:id_pos";

                $query = $this->getConnexion()->prepare($sql);
                $query->execute(array(
                    'id_product'=>$stock->getIdProduct(),
                    'id_pos'=>$stock->getIdPos(),
                    'qte'=>$qt
                ));



            return 'success';

        }

        catch (Exception $e)
        {
            return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function updateProduitQuantity($qt,$id,$id_pos)
    {
        try
        {


            $sql = "UPDATE bn_stock SET quantity = quantity - :quantity WHERE id_product = :id_produit AND id_pos=:id_pos";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'quantity'=>$qt,
                'id_produit'=>$id,
                'id_pos'=>$id_pos
                ));
            return 'success';

        } catch (Exception $e) {
            return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function getStockByIdProductAndIdPOS($id_product,$id_pos){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_stock WHERE id_product=:id AND id_pos=:id_pos");
            $query->execute(array('id'=>$id_product,'id_pos'=>$id_pos));

            return $row = $query->fetch();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }



    public function getOneProductById($id){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE id_product=:id");
            $query->execute(array('id'=>$id));

            return $row = $query->fetch();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }


    public function getOneProduitById($id){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE id_product=:id");
            $query->execute(array('id'=>$id));

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getStockByIdProduct($id){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_stock WHERE id_product=:id");
            $query->execute(array('id'=>$id));

            return $row = $query->fetch();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getStockQuantityByIdProduct($id){


        try {

            $query = $this->getConnexion()->prepare("SELECT quantity FROM bn_stock WHERE id_produit=:id");
            $query->execute(array('id'=>$id));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function deleteOneProduct($id,$deletedBy){


        try {

            $query = $this->getConnexion()->prepare("UPDATE bn_product SET isDeleted = 1, 
            deletedTime = GETDATE(), deletedBy=:deletedBy WHERE id_product=:id");
            $query->execute(array('deletedBy'=>$deletedBy,'id'=>$id));

            return "success";



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function findCodeProduit($code){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_product WHERE code=:code");
            $query->execute(array('code'=>$code));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getCodeProduit($code){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE code=:code");
            $query->execute(array('code'=>$code));

            return $row = $query->fetch();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function countAllProduit(){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_product");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }


    public function findCode($numero){
        try{
            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_product WHERE code=?");
            $query->execute([$numero]);
            $count_rows = $query->fetchColumn();
            return $count_rows;
        }catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getProductPriceById($id){
        try{
            $query = $this->getConnexion()->prepare("SELECT price FROM bn_product WHERE id_product=?");
            $query->execute([$id]);
            $count_rows = $query->fetchColumn();
            return $count_rows;
        }catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getProductCategoryById($id){
        try{
            $query = $this->getConnexion()->prepare("SELECT id_category FROM bn_product WHERE id_product=?");
            $query->execute([$id]);
            $count_rows = $query->fetchColumn();
            return $count_rows;
        }catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

    }


    public function getAllVoucherProduct(){
        try{
            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE id_category = 3");
            $query->execute();
            $count_rows = $query->fetchAll();
            return $count_rows;
        }catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getEVoucherProduct(){
        try{
            $query = $this->getConnexion()->prepare("SELECT * FROM bn_product WHERE id_category = 4");
            $query->execute();
            $count_rows = $query->fetchAll();
            return $count_rows;
        }catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

    }


    /* ********** CLIENT ***************************  */

    public function getAllCustomer()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_client");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }


    public function addClient(Client $client)
    {
        try
        {
            $sql = "INSERT INTO bn_client(firstname,middlename,lastname,address,idcard,phone,addedBy)
			VALUES (:firstname,:middlename,:lastname,:address,:idcard,:phone,:addedBy)";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'firstname'=>$client->getPrenom(),
                'middlename'=>$client->getPostom(),
                'lastname'=>$client->getNom(),
                'address'=>$client->getAdresse(),
                'phone'=>$client->getTel(),
                'idcard'=>$client->getIdcard(),
                'addedBy'=>$client->getAddedBy()

            ));

            $query = $this->getConnexion()->prepare("SELECT TOP 1 id_client FROM bn_client WHERE addedBy=:addedBy ORDER BY id_client DESC");
            $query->execute(array(
                    'addedBy'=>$client->getAddedBy()
                )

            );
            $id = $query->fetchColumn();

            return $id;

        }

        catch (Exception $e)
        {
            return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function getOneClientById($id){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_client WHERE id_client=:id");
            $query->execute(array('id'=>$id));

            return $row = $query->fetch();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function findClientByName($search){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_client WHERE firstname LIKE CONCAT(:search,'%') OR lastname LIKE CONCAT(:search1,'%') OR middlename LIKE CONCAT(:search2,'%')");
            $query->execute(array(
                'search'=>$search,
                'search1'=>$search,
                'search2'=>$search
            ));

            $row = $query->fetchAll();


            return $row;


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function findClientByPhone($search){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_client WHERE phone LIKE CONCAT('%',:search,'%')");
            $query->execute(array('search'=>$search));

            $row = $query->fetchAll();


            return $row;


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    /**************** PRODUCT SALE *********************************/

    public function getProductSaleQteById($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales WHERE id_product = :id_product");
            $query->execute(array('id_product'=>$id));
            return $row = $query->fetchColumn();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getTotalPriceProductSaleById($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales WHERE id_product = :id_product");
            $query->execute(array('id_product'=>$id));
            return $row = $query->fetchColumn();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    /* *************** VENTES *************************** */

    public function getAllOrder()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function addOrderCredit(SalesCredit $salesCredit)
    {
        try
        {
            //die($commande->getIdProduct());
            $sql = "INSERT INTO bn_sales_(id_product,amount,quantity,phone,total_amount,addedBy)
			VALUES (:id_product,:amount,:quantity,:phone,:total_amount,:addedBy)";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'id_product'=>$salesCredit->getIdProduct(),
                'amount'=>$salesCredit->getAmount(),
                'quantity'=>$salesCredit->getQuantity(),
                'phone'=>$salesCredit->getPhone(),
                'addedBy'=>$salesCredit->getAddedBy(),
                'total_price'=>$salesCredit->getTotal()

            ));
            return 'success';

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }


    public function addOrder(Commande $commande)
    {
        try
        {
            //die($commande->getIdProduct());
            $sql = "INSERT INTO bn_sales(id_client,id_product,id_ref,quantity,unit_price,total_price,imei,addedBy)
			VALUES (:id_client,:id_product,:id_ref,:quantity,:unit_price,:total_price,:imeis,:addedBy)";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'id_client'=>$commande->getIdClient(),
                'id_product'=>$commande->getIdProduct(),
                'id_ref'=>$commande->getIdRef(),
                'quantity'=>$commande->getQuantity(),
                'unit_price'=>$commande->getUnitPrice(),
                'total_price'=>$commande->getTotalPrice(),
                'imeis'=>$commande->getImeis(),
                'addedBy'=>$commande->getAddedBy()

            ));
            $query = $this->getConnexion()->prepare("SELECT TOP 1 id_sale FROM bn_sales WHERE id_ref =:id_ref AND id_product=:id_product ORDER BY id_sale DESC");
            $query->execute(array(
                    'id_ref'=>$commande->getIdRef(),
                    'id_product'=>$commande->getIdProduct()
                )

            );
            $id = $query->fetchColumn();

            return $id;

        }

        catch (Exception $e)
        {
            //return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function addOrderReference(SaleReference $saleRef)
    {

        try
        {
            //create reference code
            $ref  = $this->getOrderReferenceCode();
            $sql = "INSERT INTO bn_sales_reference(reference,nbre_article,total_price,id_client,addedBy)
			VALUES (:reference,:nbre_article,:total_price,:id_client,:addedBy)";

            $query = $this->getConnexion()->prepare($sql);
            //$this->getConnexion()->beginTransaction();
            //die($commande->getIdProduct());

            $query->execute(array(
                'reference'=>$ref,
                'nbre_article'=>$saleRef->getNbreArticle(),
                'total_price'=>$saleRef->getTotal(),
                'id_client'=>$saleRef->getIdClient(),
                'addedBy'=>$saleRef->getAddedBy()

            ));

            $query = $this->getConnexion()->prepare("SELECT TOP 1 id_ref FROM bn_sales_reference WHERE id_client =:id_client AND addedBy=:addedBy ORDER BY id_ref DESC");
            $query->execute(array(
                'id_client'=>$saleRef->getIdClient(),
                'addedBy'=>$saleRef->getAddedBy()
                )

            );
            $id = $query->fetchColumn();
            //$id = $this->getConnexion()->lastInsertId();
            //$this->getConnexion()->commit();

            return $id;

        }

        catch (Exception $e)
        {
            //return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }
    

    public function getOrderReferenceCode(){
        try {
             $chk = true;
            $code = "";
            $code = date('d-m-Y H:i:s');
            $code = str_replace('/', '', $code);
            $code = str_replace(':', '', $code);
            $code = str_replace('-', '', $code);
            $code = str_replace(' ', '', $code);
            $code = "AFRICELL".$code;
            /*while($chk){

                //$code = substr(md5(mt_rand()), 0, 8);
                $date = date('d-m-Y H:i:s');
                $date = str_replace('/', '', $date);
                $date = str_replace(':', '', $date);
                $date = str_replace('-', '', $date);
                $date = str_replace(' ', '', $date);
                $date = "AFRICELL".$date;
                $find = $this->findSaleReference($code);
                if($find < 1 ){
                    $chk = false;
                }

            }*/


            return $code;



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    
    public function getSaleReferenceById($id){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference WHERE id_ref=:id");
            $query->execute(array('id'=>$id));

            return $row = $query->fetch();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAllSaleReference(){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function totalPriceSales(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales_reference");
            $query->execute(array());
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function totalPriceSalesByProduct($id){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales WHERE id_product = :id_product");
            $query->execute(array("id_product"=>$id));
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function totalSalesQuantity(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference");
            $query->execute(array());
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getSalesPOS($pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference 
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function countSalesPOS($pos){
        try {



            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference 
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        
    }
    public function totalPriceSalesByProductPOS($id_product,$id_pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales INNER JOIN bn_user ON
bn_sales.addedBy = bn_user.username WHERE bn_sales.id_product = :id_product AND bn_user.id_pos=:id_pos");
            $query->execute(array(
                "id_product"=>$id_product,
                "id_pos"=>$id_pos
            ));
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function todaySales(){
        try {


            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference  WHERE
            CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function todaySalesQte(){
        try {


            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference WHERE
             CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function todayTotalPriceSales(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales_reference
 WHERE CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function countTodaySalesPOS($pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference 
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND CAST(bn_sales_reference.creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        
    }
    public function salesPOS($pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference 
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        
    }
    public function detailSalesPOS($idRef){
        try {

            $query = $this->getConnexion()->prepare("SELECT br.reference,br.total_price,bl.firstname, bl.lastname,bp.designation,bse.imei,bse.iccid,bse.msisdn, bse.serial, 
            bc.unit_price, br.creation_date, br.addedBy FROM bn_sales As bc
                        INNER JOIN bn_sale_extra As bse ON bc.id_sale = bse.id_sale
                        INNER JOIN bn_product As bp ON bc.id_product = bp.id_product
                        INNER JOIN bn_sales_reference As br ON br.id_ref = bc.id_ref
                        INNER JOIN bn_client As bl ON bc.id_client  = bl.id_client
                        WHERE bc.id_ref=:id");
            $query->execute(array('id'=>$idRef));
            return $row = $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function todaySalesPOS($pos){
        try {


            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference 
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND CAST(bn_sales_reference.creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        
    }
    public function todaySalesQtePOS($pos){
        try {


            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND CAST(bn_sales_reference.creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function todayTotalSalesPOS($pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales_reference 
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND CAST(bn_sales_reference.creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute(array('id'=>$pos));
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getQuantityProduitCommandePOS($id_product,$id_pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales INNER JOIN bn_user ON
 bn_sales.addedBy = bn_user.username WHERE bn_sales.id_product = :id_produit AND bn_user.id_pos=:id_pos");
            $query->execute(array(
                'id_produit'=>$id_product,
                'id_pos'=>$id_pos
            ));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function totalSalesPOS($pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            ");
            $query->execute(array('id'=>$pos));
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function totalSalesQuantityPOS($pos){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            ");
            $query->execute(array('id'=>$pos));
            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function countThisMonthSalesPOS($pos){
        try {

           // $pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND YEAR(bn_sales_reference.creation_date) = YEAR(GETDATE()) AND MONTH(bn_sales_reference.creation_date) = MONTH(GETDATE()) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        
    }

    public function thisMonthSales(){
        try {

            // $pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(bn_sales_reference.creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function countThisMonthSales(){
        try {

            // $pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(bn_sales_reference.creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function thisMonthSalesQte(){
        try {

            // $pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(bn_sales_reference.creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function thisMonthTotalPriceSales(){
        try {

            // $pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales_reference WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(bn_sales_reference.creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function countThisMonthSalesQtePOS($pos){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND YEAR(bn_sales_reference.creation_date) = YEAR(GETDATE()) AND MONTH(bn_sales_reference.creation_date) = MONTH(GETDATE()) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function countThisWeekSales(){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference WHERE DATEPART(day,creation_date) = DATEPART(day,GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function thisWeekSalesQte(){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference WHERE DATEPART(day,creation_date) = DATEPART(day,GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function thisWeekTotalPriceSales(){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales_reference WHERE DATEPART(day,creation_date) = DATEPART(day,GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function thisWeekSales(){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales_reference WHERE DATEPART(day,creation_date) = DATEPART(day,GETDATE()) ");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function countThisWeekSalesPOS($pos){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND DATEPART(day,bn_sales_reference.creation_date) = DATEPART(day,GETDATE()) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function countThisWeekSalesQtePOS($pos){
        try {

            //$pos = $this->get;

            $query = $this->getConnexion()->prepare("SELECT SUM(nbre_article) FROM bn_sales_reference
            INNER JOIN bn_user ON bn_sales_reference.addedBy = bn_user.username WHERE bn_user.id_pos=:id
            AND DATEPART(day,bn_sales_reference.creation_date) = DATEPART(day,GETDATE()) ");
            $query->execute(array('id'=>$pos));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }



    public function findSaleReference($code){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales_reference WHERE reference=:code");
            $query->execute(array('code'=>$code));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }


    public function countAllCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function countTodayCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales WHERE CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function todayCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales WHERE CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function todayTotalCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales WHERE CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function todayProduitCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales WHERE CAST(creation_date AS DATE) = CAST(GETDATE() AS DATE) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }



    public function countThisMonthCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function thisMonthCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisMonthTotalCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisMonthProduitCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(creation_date) = MONTH(GETDATE()) ");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function countThisYearCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE())");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisYearCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE())");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisYearTotalCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE())");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisYearProduitCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE())");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function countThisYearMonthCommande($month){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(creation_date) =:month ");
            $query->execute(array('month'=>$month));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function ThisYearMonthCommande($month){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales WHERE YEAR(creation_date) = YEAR(GETDATE()) AND MONTH(creation_date) =:month ");
            $query->execute(array('month'=>$month));

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function countThisWeekCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_sales WHERE DATEPART(day,creation_date) = DATEPART(day,GETDATE())");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisWeekCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_sales WHERE YEARWEEK(creation_date) = YEARWEEK(NOW())");
            $query->execute();

            return $row = $query->fetchAll();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function thisWeekTotalCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(total_price) FROM bn_sales WHERE YEARWEEK(creation_date) = YEARWEEK(NOW())");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function thisWeekProduitCommande(){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales WHERE YEARWEEK(creation_date) = YEARWEEK(NOW())");
            $query->execute();

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getQuantityProduitCommande($id){
        try {

            $query = $this->getConnexion()->prepare("SELECT SUM(quantity) FROM bn_sales WHERE id_product = :id_produit");
            $query->execute(array('id_produit'=>$id));

            return $row = $query->fetchColumn();



        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    /********* EXCHANGE PRODUCT ******************************* */
    public function addExchange(ProductExchange $pexchange)
    {
        try
        {
            //die($commande->getIdProduct());
            $sql = "INSERT INTO bn_sales_exchange(id_plainte,id_ref,id_product,id_product_new,oldimei,newimei,addedBy)
			VALUES (:id_plainte,:id_ref,:id_product,:id_newproduct,:oldimei,:newimei,:addedBy)";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'id_plainte'=>$pexchange->getIdPlainte(),
                'id_ref'=>$pexchange->getIdReference(),
                'id_product'=>$pexchange->getIdProduct(),
                'id_newproduct'=>$pexchange->getNewproduct(),
                'oldimei'=>$pexchange->getOldimei(),
                'newimei'=>$pexchange->getNewimei(),
                'addedBy'=>$pexchange->getAddedBy()

            ));
            return 'success';

        }

        catch (Exception $e)
        {
            //return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }


    /********* RATE ******************************* */
    public function getRate()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_rate");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getRateById($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_rate WHERE id_rate =:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetch();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function addRate(Xrate $xrate)
    {
        try
        {
            $query = $this->getConnexion()->prepare("INSERT INTO bn_rate(rate,addedBy)
			VALUES (:rate,:addedBy)");
            $query->execute(array(
                'rate'=>$xrate->getRate(),
                'addedBy'=>$xrate->getAddedBy()
            ));

            $rate = $this->getRate();

            $query = $this->getConnexion()->prepare("INSERT INTO bn_rate_hist(id_rate,rate,addedBy)
			VALUES (:id_rate,:rate,:addedBy)");
            $query->execute(array(
                'id_rate'=>$rate[0]['id_rate'],
                'rate'=>$xrate->getRate(),
                'addedBy'=>$xrate->getAddedBy()
            ));
            return 'success';

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function editRate(Xrate $xrate, $id)
    {
        try
        {
            $query = $this->getConnexion()->prepare("UPDATE bn_rate SET rate=:rate WHERE id_rate = :id
			");
            $query->execute(array(
                'rate'=>$xrate->getRate(),
                'id'=>$id
            ));

            $rate = $this->getRate();

            $query = $this->getConnexion()->prepare("INSERT INTO bn_rate_hist(id_rate,rate,addedBy)
			VALUES (:id_rate,:rate,:addedBy)");
            $query->execute(array(
                'id_rate'=>$rate[0]['id_rate'],
                'rate'=>$xrate->getRate(),
                'addedBy'=>$xrate->getAddedBy()
            ));

            return 'success';

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }


    /************** POS ************************************************/
    public function getAllPOS()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_pos");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getOnePOSById($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_pos WHERE id_pos =:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetch();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getOnePOSByUser($username)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT id_pos FROM bn_user WHERE username =:username");
            $query->execute(array('username'=>$username));
            return $row = $query->fetchColumn();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function addPOS(Pos $pos)
    {
        try
        {
            $query = $this->getConnexion()->prepare("INSERT INTO bn_pos(designation,city,province)
			VALUES (:designation,:city,:province)");
            $query->execute(array(
                'designation'=>$pos->getDesignation(),
                'city'=>$pos->getCity(),
                'province'=>$pos->getProvince(),
            ));
            return 'success';

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function editPOS(Pos $pos, $id)
    {
        try
        {
            $query = $this->getConnexion()->prepare("UPDATE bn_pos SET designation=:designation, city=:city,
            provinc=:province WHERE id_pos = :id
			");
            $query->execute(array(
                'designation'=>$pos->getDesignation(),
                'city'=>$pos->getCity(),
                'province'=>$pos->getProvince(),
                'id'=>$id
            ));
            return 'success';

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }

    /************** IMEI ************ */

    public function addImei(Imei $imei)
    {
        try
        {
            $query = $this->getConnexion()->prepare("INSERT INTO bn_imei(id_product,imei,id_pos,addedBy)
			VALUES (:id_product,:imei,:id_pos,:addedBy)");
            $query->execute(array(
                'id_product'=>$imei->getIdProduct(),
                'imei'=>$imei->getImei(),
                'id_pos'=>$imei->getIdPos(),
                'addedBy'=>$imei->getAddedBy(),
            ));
            return 'success';

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function editImei(Imei $imei)
    {
        try
        {
            //$row = $this->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
            //$qt = (int)$row['quantity'] + (int)$stock->getQuantity();


            $sql = "UPDATE bn_imei SET imei =:imei WHERE id_product=:id_product AND id_pos=:id_pos";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'id_product'=>$imei->getIdProduct(),
                'id_pos'=>$imei->getIdPos(),
                'imei'=>$imei->getImei()
            ));



            return 'success';

        }

        catch (Exception $e)
        {
            return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function getAllImei()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_imei");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getImeiByIdProuct($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_imei WHERE id_product =:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getImeiByIdPos($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_imei WHERE id_pos =:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getImeiByIdProductAndIdPOS($id_product,$id_pos){


        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_imei WHERE id_product=:id AND id_pos=:id_pos");
            $query->execute(array('id'=>$id_product,'id_pos'=>$id_pos));

            return $row = $query->fetch();

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    /*************** SALE IMEI *******************/


    public function addSaleImei(SaleImei $saleimei)
    {
        try
        {
            $query = $this->getConnexion()->prepare("INSERT INTO bn_sale_extra(id_sale,id_product,imei,msisdn,iccid,serial)
			VALUES (:id_sale,:id_product,:imei,:msisdn,:iccid,:serial)");
            $query->execute(array(
                'id_sale'=>$saleimei->getIdSale(),
                'id_product'=>$saleimei->getIdProduct(),
                'imei'=>$saleimei->getImei(),
                'msisdn'=>$saleimei->getMsisdn(),
                'iccid'=>$saleimei->getIccid(),
                'serial'=>$saleimei->getSerial()

            ));

            /*
             * $query = $this->getConnexion()->prepare("SELECT TOP 1 id_sale_imei FROM bn_sales_imei WHERE id_sale =:id_sale AND id_product=:id_product ORDER BY id_ref DESC");
            $query->execute(array(
                    'id_sale'=>$saleimei->getIdSale(),
                    'id_product'=>$saleimei->getIdProduct()
                )

            );
            $id = $query->fetchColumn();
            */
            return "success";

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function updateSaleImeiIdSale($id_sale,$id_product)
    {
        try
        {
            //$row = $this->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
            //$qt = (int)$row['quantity'] + (int)$stock->getQuantity();


            $sql = "UPDATE bn_sale_extra SET id_sale =:id_sale WHERE id_product=:id_product AND id_sale=0";

            $query = $this->getConnexion()->prepare($sql);
            $query->execute(array(
                'id_sale'=>$id_sale,
                'id_product'=>$id_product
            ));



            return 'success';

        }

        catch (Exception $e)
        {
           // return $e->getMessage();
            die('Erreur : ' . $e->getMessage());
        }


    }



    /************* CATEGORY PRODUCT **************/
    public function getAllCategory()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_category");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    /* ************PLAINTE******************************* */
    public function getAllPlainte()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_plainte");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getPlainteByConsern($consern)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_plainte WHERE type_plainte = :type_plainte ");
            $query->execute(array('type_plainte'=>$consern));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getPlainteTypeById($id_type)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_typeplainte WHERE id_type = :id_type ");
            $query->execute(array('id_type'=>$id_type));
            return $row = $query->fetch();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getPlainteByStatus($st)
{

    try {

        $query = $this->getConnexion()->prepare("SELECT * FROM bn_plainte WHERE status = :status ");
        $query->execute(array('status'=>$st));
        return $row = $query->fetchAll();


    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }


}
    public function getPlainteById($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_plainte WHERE id_plainte = :id ");
            $query->execute(array('id'=>$id));
            return $row = $query->fetch();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function countPlainteByStatus($st)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT COUNT(*) FROM bn_plainte WHERE status = :status ");
            $query->execute(array('status'=>$st));
            return $row = $query->fetchColumn();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function addPlainte(Plainte $plainte)
    {
        try
        {
            $query = $this->getConnexion()->prepare("INSERT INTO bn_plainte(id_client,id_type,id_subtype,description,solution,status,addedBy)
			VALUES (:id_client,:id_type,:id_subtype,:description,:solution,:status,:addedBy)");
            $query->execute(array(
                'id_client'=>$plainte->getIdClient(),
                'id_type'=>$plainte->getIdType(),
                'description'=>$plainte->getDescription(),
                'addedBy'=>$plainte->getAddedBy(),
                'solution'=>$plainte->getSolution(),
                'status'=>$plainte->getStatus(),
                'id_subtype'=>$plainte->getIdSubtype()
            ));


            $query = $this->getConnexion()->prepare("SELECT TOP 1 id_plainte FROM bn_plainte WHERE id_client =:id_client AND addedBy=:addedBy ORDER BY id_plainte DESC");
            $query->execute(array(
                    'id_client'=>$plainte->getIdClient(),
                    'addedBy'=>$plainte->getAddedBy()
                )

            );
            $id = $query->fetchColumn();



            return $id;

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function addPlainteExtra(PlainteExtra $plainteex)
    {
        try
        {
            $query = $this->getConnexion()->prepare("INSERT INTO plainte_extra(id_plainte,facture,serial,imei,msisdn,evc)
			VALUES (:id_plainte,:facture,:serial,:imei,:msisdn,:evc)");
            $query->execute(array(
                'id_plainte'=>$plainteex->getIdPlainte(),
                'facture'=>$plainteex->getFacture(),
                'imei'=>$plainteex->getImei(),
                'serial'=>$plainteex->getSerial(),
                'msisdn'=>$plainteex->getMsisdn(),
                'evc'=>$plainteex->getEvc()
            ));


            return "success";

        }

        catch (Exception $e)
        {
            //return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function updatePlainteStatus($id){
        try
        {
            //$logout = date("Y-m-d h:i:s");
            $query = $this->getConnexion()->prepare("UPDATE bn_plainte SET status=1 WHERE id_plainte=:id");
            $query->execute(array('id'=>$id));
            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function updatePlainteSolution($solution,$status,$id){
        try
        {
            //$logout = date("Y-m-d h:i:s");
            $query = $this->getConnexion()->prepare("UPDATE bn_plainte SET solution=:solution,status = :status WHERE id_plainte=:id");
            $query->execute(array(
                'solution'=>$solution,
                'status'=>$status,
                'id'=>$id
                ));

            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }

    }


    /**************** TYPE PLAINTE ********************/
    public function getAllPlainteType()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_typeplainte");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAllPlainteSubType()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_subtype_plainte");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getOnePlainteTypeById($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_typeplainte WHERE id_type =:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetch();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getPlainteSubTypeByType($id)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_subtype_plainte WHERE id_type =:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }


    /* **************USER*************************** */

    public function getAllUsers()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user 
            LEFT JOIN bn_pos ON bn_user.id_pos = bn_pos.id_pos");
            $query->execute();
        
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getUsersByPOS($id_pos)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user WHERE id_pos = :id_pos ");
            $query->execute(array('id_pos'=>$id_pos));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function getPOSByUsername($username)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT id_pos FROM bn_user WHERE username = :username ");
            $query->execute(array('username'=>$username));
            return $row = $query->fetchColumn();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function AddUser(User $user)
    {
        try
        {
            $pw = password_hash($user->getPassword(),PASSWORD_DEFAULT);
            $query = $this->getConnexion()->prepare("INSERT INTO bn_user(username,password,role,status,names,pages,addedBy,id_pos)
			VALUES (:username,:password,:role,:status,:nom,:pages,:addedBy,:id_pos)");
            $query->execute(array(
                'username'=>$user->getUsername(),
                'password'=>$pw,
                'role'=>$user->getRole(),
                'status'=>$user->getStatus(),
                'nom'=>$user->getNoms(),
                'pages'=>$user->getPages(),
                'addedBy'=>$user->getAddedBy(),
                'id_pos'=>$user->getIdPos()
            ));
            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function editUser(User $user, $id){
        try
        {

            $query = $this->getConnexion()->prepare("UPDATE bn_user SET username=:username,role=:role,
			status=:status,names=:nom,pages=:pages, id_pos=:id_pos WHERE id=:id");
            $query->execute(array(
                'username'=>$user->getUsername(),
                'role'=>$user->getRole(),
                'status'=>$user->getStatus(),
                'nom'=>$user->getNoms(),
                'pages'=>$user->getPages(),
                'id_pos'=>$user->getIdPos(),
                'id'=>$id));
            return 'success';

        }

        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
            return 'failed';

        }

    }

    public function getOneUserById($id){

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user WHERE id=:id");
            $query->execute(array('id'=>$id));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    public function findUsername($username){

        try {

            $query = $this->getConnexion()->prepare("SELECT username FROM bn_user WHERE username =:username");
            $query->execute(array('username'=>$username));
            return $row = $query->fetchColumn();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }
    public function getUserByUsername($username)
    {
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user WHERE username=:username");
            $query->execute(array('username'=>$username));
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getOneUserByPassword($username,$pswd){

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user WHERE username=:username");
            $query->execute(array('username'=>$username));
            $row = $query->fetch();
            if($row && password_verify($pswd,$row['password'])){
                return $row;
            }else{
                return false;
            }




        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }

    public function deleteOneUserById($id){

        try {

            $query = $this->getConnexion()->prepare("DELETE FROM bn_user WHERE id=?");
            $query->execute([$id]);
            //$row = $query->fetchAll();
            return "success";


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


    }

    /******** user logins *******/
    public function addLogin(Logins $login)
    {
        try
        {
            //$id = $this->getConnexion()->lastInsertId();
            $query = $this->getConnexion()->prepare("INSERT INTO bn_login(username,usercheck,ip)
			VALUES (:username,:usercheck,:ip)");

            //$this->getConnexion()->beginTransaction();
            $query->execute(array(
                'username'=>$login->getUser(),
                'usercheck'=>$login->getUsercheck(),
                'ip'=>$login->getIp()));
            //$id = $this->getConnexion()->lastInsertId();

            //$this->getConnexion()->commit();


            return "success";

        }


        catch (Exception $e)
        {

            die('Erreur : ' . $e->getMessage());
            return 'failed';
        }


    }
    public function addAppLogin(Logins $login)
    {
        try
        {
            //$id = $this->getConnexion()->lastInsertId();
            $query = $this->getConnexion()->prepare("INSERT INTO migration_app_login(user,usercheck,ip) 
            VALUES (:user,:usercheck,:ip)");

            //$this->getConnexion()->beginTransaction();
            $query->execute(array(
                'user'=>$login->getUser(),
                'usercheck'=>$login->getUsercheck(),
                'ip'=>$login->getIp()));
            //$id = $this->getConnexion()->lastInsertId();

            //$this->getConnexion()->commit();


            return "success";

        }


        catch (Exception $e)
        {

            die('Erreur : ' . $e->getMessage());
            return 'failed';
        }


    }
    public function getLoginId($username)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT id FROM bn_login WHERE username=:username ORDER BY id DESC ");
            $query->execute(array('username'=>$username));
            $id = $query->fetchColumn();
            return $id;


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAppLoginId($username)
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT id FROM migration_app_login WHERE user=:username ORDER BY id DESC LIMIT 1 ");
            $query->execute(array('username'=>$username));
            $id = $query->fetchColumn();
            return $id;


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getLogins()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_login");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function getAppLogins()
    {

        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM migration_app_login");
            $query->execute();
            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function updateLogout($id){
        try
        {
            //$logout = date("Y-m-d h:i:s");
            $query = $this->getConnexion()->prepare("UPDATE bn_login SET logout= NOW() WHERE id=:id");
            $query->execute(array('id'=>$id));
            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function updateAppLogout($id){
        try
        {
            //$logout = date("Y-m-d h:i:s");
            $query = $this->getConnexion()->prepare("UPDATE migration_app_login SET logout= NOW() WHERE id=:id");
            $query->execute(array('id'=>$id));
            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function updateGranted($id){
        try
        {
            //$logout = date("Y-m-d h:i:s");
            $query = $this->getConnexion()->prepare("UPDATE bn_login SET granted=:granted WHERE id=:id");
            $query->execute(array('granted'=>1,'id'=>$id));
            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function updateAppGranted($id){
        try
        {
            //$logout = date("Y-m-d h:i:s");
            $query = $this->getConnexion()->prepare("UPDATE migration_app_login SET granted=:granted WHERE id=:id");
            $query->execute(array('granted'=>1,'id'=>$id));
            return 'success';

        }

        catch (Exception $e)
        {
            return 'failed';
            die('Erreur : ' . $e->getMessage());
        }

    }
    /********************** SOS ****************************************/



    /**************** Messsages ***************************/

    /****************Pages****************************/

    public function getPages(){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_pages");
            $query->execute();

            return $row = $query->fetchAll();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

    }
    public function findPagesByUsername($username){
        try {

            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user WHERE username=:username");
            $query->execute(array('username'=>$username));






            return $row = $query->fetch();


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function checkPagesByUsername($username,$page){
        $find = false;
        try {


            $query = $this->getConnexion()->prepare("SELECT * FROM bn_user WHERE username=:username");
            $query->execute(array('username'=>$username));

            $row = $query->fetch();
            if($row){

                $pos = strpos($row['pages'],$page);
                if($pos !== false)
                    $find = true;


            }





            return $find;


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /* ************************ Departement ***********************/

}