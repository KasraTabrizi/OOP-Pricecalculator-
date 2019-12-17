<?php

    require 'classes.php';

    //CREATE TABLE AND SEND TO THE VIEW
    function createTable(){
        var_dump($customers);
    }

    //CALCULATE THE PRICE OF THE PRODUCT FOR EACH DISCOUNT
    function calculatePrice($customer, $product, $amount){
        var_dump($customers);
    }

    function processData($customers, $products, $groups, $departments, $companies, $customer, $product, $amount){
        $retrievedData = array();
        $loop = true;
        //var_dump($customers);
        array_push($retrievedData, $customers[intval($customer)]->getName()); //push customer name in array
        $customerGroupId = $customers[intval($customer)]->getGroupId(); //get group ID of customer
        // var_dump($customerGroupId);
        // var_dump($departments);
        while($loop){ //this loop checks in which departments the customer is in and in which company the departement is
            if($customerGroupId == 0 || $customerGroupId == 12 || $customerGroupId == 16 || $customerGroupId == 20 || $customerGroupId == 32 || $customerGroupId == 35 || $customerGroupId == 38){
                foreach($companies as $company){
                    if($company->getId() == $customerGroupId){
                        array_push($retrievedData, $company->getName());
                        array_push($retrievedData, $company->getDiscountType());
                        array_push($retrievedData, $company->getDiscountValue());
                    }
                }
                $loop = false;
            }
            else{
                foreach($departments as $department){
                    if($department->getId() == $customerGroupId){
                        array_push($retrievedData, $department->getName());
                        array_push($retrievedData, $department->getDiscountType());
                        array_push($retrievedData, $department->getDiscountValue());
                        $customerGroupId = $department->getGroupId();
                    }
                }
            }
        }

        return $retrievedData; //return the array
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
    $groups = $jsonDecode;
    $departments = array();
    $companies = array();
    foreach($jsonDecode as $group){
        if($group->id == 0 || $group->id == 12 || $group->id == 16 || $group->id == 20 || $group->id == 32 || $group->id == 35 || $group->id == 38){
            if(property_exists($group, 'variable_discount')){
                array_push($companies, new Company($group->id, $group->name, 'variable', $group->variable_discount));
            }
            elseif(property_exists($group, 'fixed_discount')){
                array_push($companies, new Company($group->id, $group->name, 'fixed', $group->fixed_discount));
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

    //var_dump($customers);

?>