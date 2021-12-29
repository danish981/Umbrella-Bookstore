<?php

spl_autoload_register(function ($class) {
    $arr = ['goods', 'interfaces', 'orders', 'reviews', 'serve', 'image', 'invoice'];
    foreach ($arr as $val) {
        $path = __DIR__ . "/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class Address {
    private $country;
    private $city;
    private $street;
    private $buildNo;
    
    /**
     * Address constructor.
     * @param $country
     * @param $city
     * @param $street
     * @param $buildNo
     */
    public function __construct($country, $city, $street, $buildNo) {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->buildNo = $buildNo;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getCity() {
        return $this->city;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getBuildNo() {
        return $this->buildNo;
    }

    public function __toString() {
        return <<<EOD
the country is $this->country , city is $this->city, street is $this->street and build NO is 
$this->buildNo
EOD;
    }

}