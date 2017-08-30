<?php
namespace Application\Entity;

class Product extends Base
{
    const TABLE_NAME = 'products';
    protected $sku = '';
    protected $title = '';
    protected $description = '';
    protected $price = 0.0;
    protected $special = 0;
    protected $link = '';
    
    protected $mapping = [ 
        'id'            => 'id',
        'sku'           => 'sku',
        'title'         => 'title',
        'description'   => 'description',
        'price'         => 'price',
        'special'       => 'special',
        'link'          => 'link',
    ];
    
    public function getSku() {
        return $this->sku;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getSpecial() {
        return $this->special;
    }

    public function getLink() {
        return $this->link;
    }

    public function getMapping() {
        return $this->mapping;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setSpecial($special) {
        $this->special = $special;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function setMapping($mapping) {
        $this->mapping = $mapping;
    }


}