<?php

class Invoice{
    public $id;
    public $address;
    public $seller;
    public $timestamp;
    public $totalCost;
    //public $UserId;

    function __construct($id, $address, $seller, $timeStamp, $totalCost){
        $this->id = $id;
        $this->address = $address;
        $this->seller = $seller;
        $this->timestamp = $timeStamp;
        $this->totalCost = $totalCost;
    }
 }
?>