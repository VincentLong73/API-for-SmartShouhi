<?php

class User{
    public $id;
    public $email;
    public $userName;
    public $fullName;
    public $phone;
    public $isAdmin;
    public $isActive;
    public $dob;


    public function __construct($id, $email, $userName, $fullName, $phone, $isAdmin, $isActive, $dob){
        $this->id = $id;
        $this->email = $email;
        $this->userName = $userName;
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->isAdmin = $isAdmin;
        $this->isActive = $isActive;
        $this->dob = $dob;
    }

 }
?>