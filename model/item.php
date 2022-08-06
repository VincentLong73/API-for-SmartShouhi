<?php

class Item{
    public $id;
    public $name;
    public $cost;
    public $invoiceId;

    function __construct($id, $name, $cost, $invoiceId){
        $this->id = $id;
        $this->name = $name;
        $this->cost = $cost;
        $this->invoiceId = $invoiceId;
    }
 }
?>