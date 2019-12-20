<?php
    require '../model/model.php';

//DETECT IF THE CALCULATE BUTTON HAS BEEN PRESSED
if($_SERVER["REQUEST_METHOD"] === 'POST'){

    if(isset($_POST['login'])){
        if(nameFound($_POST['customerName'])){
            header("Location: home.php");
        }else{
            header("Location: index.php");
        }
    }

    if(isset($_POST['registration'])){
        header("Location: registration.php");
    }

    if(isset($_POST['register'])){
        addAccount($_POST['name'], $_POST['department_dropdown']);
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