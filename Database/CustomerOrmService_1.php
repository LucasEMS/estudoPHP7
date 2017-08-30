<?php
namespace Application\Database;
use PDO;
use PDOException;
use Application\Entity\Customer;
use Application\Entity\Product;
use Application\Entity\Purchase;

class CustomerOrmService_1 extends CustomerService
{
    protected function fetchPurchasesForCustomer(Customer $cust)
    {
        $sql = 'SELECT u.*,r.*,u.id AS purch_id '
                . 'FROM purchases AS u '
                . 'JOIN products AS r '
                . 'ON r.id = u.product_id '
                . 'WHERE u.customer_id '
                . 'ORDER BY u.date';
        
        $stmt = $this->connection->pdo->prepare($sql);
        $stmt->execute(['id' => $cust->getId()]);
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = Product::arrayToEntity($result, new Product());
            $product->setId($result['product_id']);
            $purch = Purchase::arrayToEntity($result, new Purchase());
            $purch->setId($result['purch_id']);
            $purch->setProduct($product);
            $cust->addPurchase($purch);
        }
        return $cust;
    }
    
    public function fetchByIdAndEmbedPurchases($id)
    {
        return $this->fetchPurchasesForCustomer(
                $this->fetchById($id));
    }
}