<?php

spl_autoload_register(static function ($class) {
    $arr = ['goods', 'interfaces', 'orders', 'reviews', 'serve', 'image', 'invoice'];
    foreach ($arr as $val) {
        $path = __DIR__ . "/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class Customers {
    private $name;
    private $address;
    private $email;
    private $phone;
    private $password;

    public function __construct($name = NULL, Address $address = NULL, $email = NULL, $phone = NULL, $password = NULL) {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress(): Address {
        return $this->address;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getPassword() {
        return $this->password;
    }
}