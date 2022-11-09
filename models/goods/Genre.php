<?php

spl_autoload_register(function ($class) {
    $arr = ['goods', 'interfaces', 'orders', 'reviews', 'serve', 'customer', 'image', 'invoice'];
    foreach ($arr as $val) {
        $path = __DIR__ . "/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class Genre {
    private string $description;
    private $id;

    public function __construct($description, $id = NULL) {
        $this->description = $description;
        $this->id = $id;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function getId() {
        return $this->id;
    }

}