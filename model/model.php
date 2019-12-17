<?php

    require 'classes.php';

    //CREATE TABLE AND SEND TO THE VIEW
    function createTable(){
        var_dump($_POST);
    }

    //CALCULATE THE PRICE OF THE PRODUCT FOR EACH DISCOUNT
    function calculatePrice(){

    }

    //DECODE JSON FILES
    //DECODE CUSTOMERS.JSON
    $jsonString = file_get_contents('../customers.json');
    $jsonDecode = json_decode($jsonString);
    $customers = array();
    foreach($jsonDecode as $customer){
        array_push($customers, new Customer($customer->id, $customer->name, $customer->group_id));
    }

    //DECODE PRODUCTS.JSON
    $jsonString = file_get_contents('../products.json');
    $jsonDecode = json_decode($jsonString);
    $products = array();
    foreach($jsonDecode as $product){
        array_push($products, new Product($product->id, $product->name, $product->description, $product->price));
    }

    //DECODE PRODUCTS.JSON AND PUT INTO DEPARTMENTS AND COMPANY ARRAY
    $jsonString = file_get_contents('../groups.json');
    $jsonDecode = json_decode($jsonString);
    $departments = array();
    $company = array();
    foreach($jsonDecode as $group){
        if($group->id == 0 || $group->id == 12 || $group->id == 16 || $group->id == 20 || $group->id == 32 || $group->id == 35 || $group->id == 38){
            if(property_exists($group, 'variable_discount')){
                array_push($company, new Company($group->id, $group->name, 'variable', $group->variable_discount));
            }
            elseif(property_exists($group, 'fixed_discount')){
                array_push($company, new Company($group->id, $group->name, 'fixed', $group->fixed_discount));
            }
        }
        else{
            if(property_exists($group, 'variable_discount')){
                array_push($departments, new Department($group->id, $group->name, 'variable', $group->variable_discount, $group->group_id));
            }
            elseif(property_exists($group, 'fixed_discount')){
                array_push($departments, new Department($group->id, $group->name, 'fixed', $group->fixed_discount, $group->group_id));
            }
        }
    }

    //var_dump($company);
?>