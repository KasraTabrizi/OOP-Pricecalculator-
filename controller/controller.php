<?php
    require '../model/model.php';

//DETECT IF THE CALCULATE BUTTON HAS BEEN PRESSED
if($_SERVER["REQUEST_METHOD"] === 'POST'){

    if(isset($_POST['login'])){

    }

    if(isset($_POST['calculate'])){
        
    }
        

    if(isset($_POST['calculate'])){
        $customer = $_POST['customer_dropdown'];
        $product = $_POST['product_dropdown'];
        $amount = $_POST['amount'];
        $retrievedData = array();
    
        //Calculate everything and put all the price, discount and names into an array to use it for creating the table
        $retrievedData = processData($customers, $products, $groups, $departments, $companies, $customer, $product, $amount);
    }
    
}

?>