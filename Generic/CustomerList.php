<?php
namespace Application\Generic;

use PDO;
use Application\Database\Connection;
use Application\Database\ConnectionAwareInterface;

class CustomerList implements ConnectionAwareInterface
{
    protected $connection;
    protected $key      = 'id';
    protected $value    = 'name';
    protected $table    = 'customer';
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function list()
    {
        $list = [];
        $stmt = $this->connection->pdo->query(
                'SELECT id, name FROM customer');
        while ($customer = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[$customer['id']] = $customer['name'];
        }
        return $list;
    }
}
