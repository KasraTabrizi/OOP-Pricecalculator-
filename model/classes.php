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

class Product{
    
}

?>