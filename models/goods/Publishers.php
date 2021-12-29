<?php

spl_autoload_register(function ($class) {
    $arr = ['goods', 'interfaces', 'orders', 'reviews', 'serve', 'customer', 'image', 'invoice'];
    foreach ($arr as $val) {
        $path = __DIR__ . "/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class Publishers {
    private $name;
    private $address;
    private $id;

    public function __construct($name, $id = NULL, $address = NULL) {
        $this->name = $name;
        $this->address = $address;
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getId() {
        return $this->id;
    }

}