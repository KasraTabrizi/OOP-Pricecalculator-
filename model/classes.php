<?php

//CLASS CUSTOMER
class Customer{
    private $id;
    private $name;
    private $groupId;

    public function __construct($id, $name, $groupId){
        $this->id = $id;
        $this->name = $name;
        $this->groupId = $groupId;
    }

    public getId(){
        return $this->id; 
    }

    public getName(){
        return $this->name;
    }

    public getGroupId(){
        return $this->groupId;
    }

}

//CLASS PRODUCT
class Product{
    private $id;
    private $name;
    private $description;
    private $price;

    public function __construct($id, $name, $description, $price){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public getId(){
        return $this->id; 
    }

    public getName(){
        return $this->name;
    }

    public getDescription(){
        return $this->description;
    }

    public getPrice(){
        return $this->price;
    }
}

//CLASS DEPARTEMENT
class Departement{
    private $id;
    private $name;
    private $description;
    private $discountType;
    private $discountValue;
    private $groupId;   

    public function __construct($id, $name, $description, $discountType, $discountValue, $groupId){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->discountType = $discountType;
        $this->discountValue = $discountValue;
        $this->groupId = $groupId;
    }

    public getId(){
        return $this->id; 
    }

    public getName(){
        return $this->name;
    }

    public getDescription(){
        return $this->description;
    }

    public getDiscountType(){
        return $this->discountType;
    }

    public getDiscountValue(){
        return $this->discountValue;
    }

    public getGroupId(){
        return $this->groupId;
    }
}

//CLASS COMPANY
class Company{
    private $id;
    private $name;
    private $description;
    private $discountType;
    private $discountValue; 

    public function __construct($id, $name, $description, $discountType, $discountValue){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->discountType = $discountType;
        $this->discountValue = $discountValue;
    }

    public getId(){
        return $this->id; 
    }

    public getName(){
        return $this->name;
    }

    public getDescription(){
        return $this->description;
    }

    public getDiscountType(){
        return $this->discountType;
    }

    public getDiscountValue(){
        return $this->discountValue;
    }
}

?>