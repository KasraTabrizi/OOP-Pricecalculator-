<?php

    require 'classes.php';

    //CREATE TABLE AND SEND TO THE VIEW
    function createTable($retrievedData, $companies){
        echo "<caption>Pricing Table</caption>";
        foreach($retrievedData as $key => $value){
            if(strpos($key, 'Name')){
                $piece = str_replace("Name", "", $key);
                echo "<th colspan='2'>".ucfirst($piece)."</th>";
            }
        }
 
        echo "<th colspan='2'>Prices</th>
              </tr><tr>";

        foreach($retrievedData as $key => $value){
            if(!is_numeric($value) && $key != 'productDescription'){ 
                if(($value !== 'variable') && ($value !== 'fixed')){
                    echo "<td>Name</td>";
                    echo "<td>".$value."</td>";
                }
            }
        }

        echo "<td>Price for 1 Unit</td>";
        echo "<td>".$retrievedData['priceOneUnit']."</td>";
        echo "</tr><tr><td></td><td></td>";

        $key = array_keys($retrievedData);
        for($i = 0; $i < count($retrievedData) ; $i++){
            if($retrievedData[$key[$i]] === 'variable'){ 
                echo "<td>Discount</td>";
                echo "<td>".$retrievedData[$key[$i + 1]]."%</td>";
            }
            if($retrievedData[$key[$i]] === 'fixed'){ 
                echo "<td>Discount</td>";
                echo "<td>".$retrievedData[$key[$i + 1]]."&euro;</td>";
            }
        }
        echo "<td>Description</td><td>".$retrievedData['productDescription']."</td>";
        echo "<td>Amount</td><td>".$retrievedData['amount']."</td>";
        echo "</tr>";
        echo "<tr>";
        foreach($retrievedData as $key => $value){
            if($key == 'amount'){
            break;
            }
            if(strpos($key, 'Name')){
                echo "<td></td><td></td>";
            }
        }
        echo "<td>Price</td><td>".$retrievedData['productPrice']."</td><td>Discount per peice for 10 or more Units</td><td>10%</td></tr>";
        echo "<tr>";
        foreach($retrievedData as $key => $value){
            if($key == 'product'){
            break;
            }
            if(strpos($key, 'Name')){
                echo "<td></td><td></td>";
            }
        }
        echo "<td>Price with amount discount</td><td>".$retrievedData['priceMoreUnits']."</td></tr>";
    }

    //CALCULATE THE PRICE OF THE PRODUCT FOR EACH DISCOUNT
    function calculatePrice($retrievedData){
        $discountAboveTenUnits = 0.9;
        $priceMoreUnits;
        $priceProduct = $retrievedData['productPrice']; 
        $priceOneUnit = $priceProduct;
        foreach($retrievedData as $key => $value){
            if($value == 'fixed' && $key == 'companyDiscountType'){
                $priceOneUnit -= $retrievedData['companyDiscountValue'];
            }
            elseif($value == 'fixed'){
                $next = str_replace("Type", "Value", $key);
                $priceOneUnit -= $retrievedData[$next];
            }
        } 
        foreach($retrievedData as $key => $value){
            if($value == 'variable' && $key == 'companyDiscountType'){
                $priceOneUnit *= (100 - $retrievedData['companyDiscountValue']) / 100;
            }
            elseif($value == 'variable'){
                $next = str_replace("Type", "Value", $key);
                $priceOneUnit *= (100 - $retrievedData[$next]) / 100;
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
        return $retrievedData;
    }

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


    function nameFound($loginName){
        $found = false;

        $jsonString = file_get_contents('../customers.json');
        $jsonDecode = json_decode($jsonString);

        foreach($jsonDecode as $customer){
            if($customer->name === $loginName){
                $found = true;
            }
        }
        return $found;
    }


    function addAccount($loginName, $groupID){
        $jsonString = file_get_contents('../customers.json');
        $jsonDecode = json_decode($jsonString);
        $jsonDecode[] = ['id' => count($jsonDecode), 'name' => $loginName, 'group_id' => $groupID];
        $jsonData = json_encode($jsonDecode);
        file_put_contents('../customers.json', $jsonData);
    }

    function alertMessage(){
        return 'placeholder="Username doesn\'t exist"';
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