<?php

spl_autoload_register(function ($class) {
    $arr = ['goods', 'interfaces', 'orders', 'reviews', 'serve', 'customer', 'image', 'invoice'];
    foreach ($arr as $val) {
        $path = __DIR__ . "/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class Review {
    protected $opinion;
    protected $degreeReview;

    protected function __construct($opinion, $degreeReview) {
        $this->opinion = $opinion;
        $this->degreeReview = $degreeReview;
    }

}