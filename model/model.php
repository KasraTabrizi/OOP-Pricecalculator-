<?php

    require 'classes.php';

    //CREATE TABLE AND SEND TO THE VIEW
    function createTable($retrievedData, $companies){
        var_dump($retrievedData);
        echo "<tr><th colspan='2'>Customer</th>";
        //echo "<th colspan='2'>".$retrievedData[0]."</th>";
        foreach($retrievedData as $key => $value){
            if($value === 'amount'){
                break;
            }
            if($key > 0 && !is_numeric($value)){ //if is true if key is equal or greater than 1 AND $value is not a number
                if(($value !== 'variable') && ($value !== 'fixed')){
                    foreach($companies as $company){
                        if($value === $company->getName()){
                            echo "<th colspan='2'>".$value."</th>";
                            break;
                        }
                        else{
                            echo "<th colspan='2'>Departement</th>";
                            break;
                        }
                    }
                }
            }
        }
        echo "<th colspan='2'>Product</th> 
              <th colspan='2'>Prices</th>
              </tr>";
        echo "<tr>
              <td>Name</td>
              <td>".$retrievedData[0]."</td>";
        
        foreach($retrievedData as $key => $value){
            if($value === 'amount'){
            break;
            }
            if($key > 0 && !is_numeric($value)){ //if is true if key is equal or greater than 1 AND $value is not a number
                if(($value !== 'variable') && ($value !== 'fixed')){
                    echo "<td>Name</td>";
                    echo "<td>".$value."</td>";
                }
            }
        }

        echo "<td>Price for 1 Unit</td>";
        echo "<td>".$retrievedData[1]."</td>";
        echo "</tr>";
    }

    //CALCULATE THE PRICE OF THE PRODUCT FOR EACH DISCOUNT
    function calculatePrice($retrievedData){
        $discountAboveTenUnits = 0.9;
        $priceMoreUnits;
        $priceProduct = $retrievedData['productPrice']; 
        //var_dump($priceProduct);
        $priceOneUnit = $priceProduct;
        foreach($retrievedData as $key => $value){
            if($value == 'fixed' && $key == 'companyDiscountType'){
                $priceOneUnit -= $retrievedData['companyDiscountValue'];
                var_dump($retrievedData['companyDiscountValue']);
            }
            elseif($value == 'fixed'){
                $next = str_replace("Type", "Value", $key);
                $priceOneUnit -= $retrievedData[$next];
                var_dump($retrievedData[$next]);
            }
        } 
        foreach($retrievedData as $key => $value){
            if($value == 'variable' && $key == 'companyDiscountType'){
                $priceOneUnit *= (100 - $retrievedData['companyDiscountValue']) / 100;
                var_dump($retrievedData['companyDiscountValue']);
            }
            elseif($value == 'variable'){
                $next = str_replace("Type", "Value", $key);
                $priceOneUnit *= (100 - $retrievedData[$next]) / 100;
                var_dump($retrievedData[$next]);
            }
        }
        if($priceOneUnit <= 0){
               $priceOneUnit = 0;     
        }
        $retrievedData['priceOneUnit'] = round($priceOneUnit, 2);

        foreach($retrievedData as $key => $value){
            if($key === 'amount'){
                $value = $retrievedData['amount'];
                if($value >= 10){
                    $priceOneUnit = ($priceOneUnit * $discountAboveTenUnits) * $value ;
                }
                else{
                    $priceOneUnit *= $value ;
                }
            }
        }
        $retrievedData['priceMoreUnits'] = round($priceOneUnit, 2);
        var_dump($retrievedData);
        return $retrievedData;
    }

    //PROCESS DATA OUT OF THE OBJECTS AND PUT IT INTO AN ARRAY FOR THE CALCULATIONS
    // function processData($customers, $products, $groups, $departments, $companies, $customer, $product, $amount){
    //     $retrievedData = array();
    //     $loop = true;
    //     //var_dump($customers);
    //     array_push($retrievedData, $customers[intval($customer)]->getName()); //push customer name in array
    //     $customerGroupId = $customers[intval($customer)]->getGroupId(); //get group ID of customer
    //     // var_dump($customerGroupId);
    //     // var_dump($departments);
    //     while($loop){ //this loop checks in which departments the customer is in and in which company the departement is
    //         if($customerGroupId == 0 || $customerGroupId == 12 || $customerGroupId == 16 || $customerGroupId == 20 || $customerGroupId == 32 || $customerGroupId == 35 || $customerGroupId == 38){
    //             foreach($companies as $company){
    //                 if($company->getId() == $customerGroupId){
    //                     array_push($retrievedData, $company->getName());
    //                     array_push($retrievedData, $company->getDiscountType());
    //                     array_push($retrievedData, $company->getDiscountValue());
    //                 }
    //             }
    //             $loop = false;
    //         }
    //         else{
    //             foreach($departments as $department){
    //                 if($department->getId() == $customerGroupId){
    //                     array_push($retrievedData, $department->getName());
    //                     array_push($retrievedData, $department->getDiscountType());
    //                     array_push($retrievedData, $department->getDiscountValue());
    //                     $customerGroupId = $department->getGroupId();
    //                 }
    //             }
    //         }
    //     }
    //     array_push($retrievedData, 'amount');
    //     array_push($retrievedData, intval($amount));
    //     array_push($retrievedData, $products[intval($product)]->getName());
    //     array_push($retrievedData, $products[intval($product)]->getDescription());
    //     array_push($retrievedData, $products[intval($product)]->getPrice());
        
    //     return calculatePrice($retrievedData); //return the array
    // }

    //PROCESS DATA OUT OF THE OBJECTS AND PUT IT INTO AN ARRAY FOR THE CALCULATIONS
    function processData($customers, $products, $groups, $departments, $companies, $customer, $product, $amount){
        $retrievedData = array();
        $loop = true;
        $counter = 0;
        $retrievedData['customerName'] = $customers[intval($customer)]->getName();
        $customerGroupId = $customers[intval($customer)]->getGroupId(); //get group ID of customer
        while($loop){ //this loop checks in which departments the customer is in and in which company the departement is
            if($customerGroupId == 0 || $customerGroupId == 12 || $customerGroupId == 16 || $customerGroupId == 20 || $customerGroupId == 32 || $customerGroupId == 35 || $customerGroupId == 38){
                foreach($companies as $company){
                    if($company->getId() == $customerGroupId){
                        $retrievedData['companyName'] = $company->getName();
                        $retrievedData['companyDiscountType'] = $company->getDiscountType();
                        $retrievedData['companyDiscountValue'] = $company->getDiscountValue();
                    }
                }
                $loop = false;
            }
            else{
                foreach($departments as $department){
                    if($department->getId() == $customerGroupId){
                        $retrievedData["department".$counter."Name"] = $department->getName();
                        $retrievedData["department".$counter."DiscountType"] = $department->getDiscountType();
                        $retrievedData["department".$counter."DiscountValue"] = $department->getDiscountValue();
                        $customerGroupId = $department->getGroupId();
                        $counter++;
                    }
                }
            }
        }
        $retrievedData['amount'] = intval($amount);
        $retrievedData['productName'] = $products[intval($product)]->getName();
        $retrievedData['productDescription'] = $products[intval($product)]->getDescription();
        $retrievedData['productPrice'] = $products[intval($product)]->getPrice();
        
        return calculatePrice($retrievedData); //return the array
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
?>