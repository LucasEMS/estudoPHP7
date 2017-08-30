<?php
namespace Application\Entity;

class Purchase extends Base
{
    const TABLE_NAME = 'purchases';
    protected $transaction = '';
    protected $date = NULL;
    protected $quantity = 0;
    protected $salePrice = 0.0;
    protected $customerId = 0;
    protected $productId = 0;
    
    protected $product = NULL;
    
    protected $mappign = [
        'id'            => 'id',
        'transaction'   => 'transaction',
        'date'          => 'date',
        'quantity'      => 'quantity',
        'sale_price'    => 'salePrice',
        'customer_id'   => 'customerId',
        'product_id'    => 'productId',
    ];
    
    public function getProduct()
    {
        return $this->product;
    }
    
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
    public function getTransaction() {
        return $this->transaction;
    }

    public function getDate() {
        return $this->date;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getSalePrice() {
        return $this->salePrice;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function getMappign() {
        return $this->mappign;
    }

    public function setTransaction($transaction) {
        $this->transaction = $transaction;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setSalePrice($salePrice) {
        $this->salePrice = $salePrice;
    }

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function setMappign($mappign) {
        $this->mappign = $mappign;
    }


}

