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

    public function getId(){
        return $this->id; 
    }

    public function getName(){
        return $this->name;
    }

    public function getGroupId(){
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

    public function getId(){
        return $this->id; 
    }

    public function getName(){
        return $this->name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getPrice(){
        return $this->price;
    }
}

//CLASS DEPARTEMENT
class Department{
    private $id;
    private $name;
    private $discountType;
    private $discountValue;
    private $groupId;   

    public function __construct($id, $name, $discountType, $discountValue, $groupId){
        $this->id = $id;
        $this->name = $name;
        $this->discountType = $discountType;
        $this->discountValue = $discountValue;
        $this->groupId = $groupId;
    }

    public function getId(){
        return $this->id; 
    }

    public function getName(){
        return $this->name;
    }

    public function getDiscountType(){
        return $this->discountType;
    }

    public function getDiscountValue(){
        return $this->discountValue;
    }

    public function getGroupId(){
        return $this->groupId;
    }
}

//CLASS COMPANY
class Company{
    private $id;
    private $name;
    private $discountType;
    private $discountValue; 

    public function __construct($id, $name, $discountType, $discountValue){
        $this->id = $id;
        $this->name = $name;
        $this->discountType = $discountType;
        $this->discountValue = $discountValue;
    }

    public function getId(){
        return $this->id; 
    }

    public function getName(){
        return $this->name;
    }
    
    public function getDiscountType(){
        return $this->discountType;
    }

    public function getDiscountValue(){
        return $this->discountValue;
    }
}

?>