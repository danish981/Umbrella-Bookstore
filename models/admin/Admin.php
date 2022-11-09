<?php

class Admin {
    private static $admins = [];
    private $id;
    private $name;
    private $pass;

    public function __construct($id, $name, $pass) {
        $this->id = $id;
        $this->name = $name;
        $this->pass = $pass;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPass() {
        return $this->pass;
    }

}