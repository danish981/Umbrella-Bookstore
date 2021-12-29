<?php

spl_autoload_register(static function ($class) {
    $arr = ['goods', 'interfaces', 'orders', 'reviews', 'serve', 'customer', 'image', 'invoice'];
    foreach ($arr as $val) {
        $path = __DIR__ . "/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class OrderDetails extends Review implements Damage {

    private $book;
    private $quantity;

    public function __construct($book, $quantity, $openion = NULL, $reviewDegree = NULL) {
        parent::__construct($openion, $reviewDegree);
        $this->book = $book;
        $this->quantity = $quantity;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    public function addQuantity(int $quantity) {
        $this->quantity += $quantity;
    }

    public function damageAllData() {
        unset(
            $this->quantity,
            $this->book
        );
    }

    public function getDetailsPrice() {
        return $this->getBook()->getSellPrice() * $this->quantity;
    }

    public function getBook(): Book {
        return $this->book;
    }

    public function setBook($book): void {
        $this->book = $book;
    }

}