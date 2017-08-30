<?php
namespace Application\Database;
use PDO;
use PDOException;
use Application\Entity\Customer;
use Application\Entity\Product;
use Application\Entity\Purchase;

class CustomerOrmService_2 extends CustomerService
{
    
    protected $products = array();
    protected $purchPreparedStmt = NULL;
    protected $prodPreparedStmt = NULL;
    
    public function fetchPurchaseById($purchId)
    {
        if (!$this->purchPreparedStmt) {
            $sql = 'SELECT * FROM purchases WHERE id = :id';
            $this->purchPreparedStmt = 
                    $this->connection->pdo->prepare($sql);
        }
        $this->purchPreparedStmt->execute(['id' => $purchId]);
        $result = $this->purchPreparedStmt->fetch(PDO::FETCH_ASSOC);
        return Purchase::arrayToEntity($result, new Purchase());
    }
    
    public function fetchProductById($prodId) 
    {
        if (!isset($this->products[$prodId])) {
            if (!$this->prodPreparedStmt) {
                $sql = 'SELECT * FROM products WHERE id = :id';
                $this->prodPreparedStmt = 
                        $this->connection->pdo->prepare($sql);
            }
            $this->prodPreparedStmt->execute(['id' => $prodId]);
            $result = $this->prodPreparedStmt
                    ->fetch(PDO::FETCH_ASSOC);
            $this->products[$prodId] = 
                    Product::arrayToEntity($result, new Product());
        }
        return $this->products[$prodId];
    }
    
    
    public function fetchPurchasesForCustomer(Customer $cust)
    {
        $sql = 'SELECT id '
                . 'FROM purchases AS u '
                . 'WHERE u.customer_id = :id '
                . 'ORDER BY u.date';
        $stmt = $this->connection->pdo->prepare($sql);
        $stmt->execute(['id' => $cust->getId()]);
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cust->addPurchaseLookup(
                    $result['id'],
                    function ($purchId, $service) {
                        $purchase = $service->fetchPurchaseById($purchId);
                        $product  = $service->fetchProductById(
                                $purchase->getProductId());
                        $purchase->setProduct($product);
                        return $purchase;
                    });
        }
        return $cust;
    }
}