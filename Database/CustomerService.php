<?php
namespace Application\Database;

use PDO;
use PDOException;
use Application\Entity\Customer;

class CustomerService
{
    protected $connection;
            
    public function __construct(Connection $connection) 
    {
        $this->connection = $connection;
    }
    
    public function fetchById($id)
    {
        $stmt = $this->connection->pdo
                ->prepare(Finder::select('customer')
                ->where('id = :id')::getSql());
        $stmt->execute(['id' => (int) $id]);
        return Customer::arrayToEntity(
                $stmt->fetch(PDO::FETCH_ASSOC)
                , new Customer());
    }
    
    public function fetchByLevel($level)
    {
        $stmt = $this->connection->pdo->prepare(
                Finder::select('customer')
                ->where('level = :level')::getSql());
        $stmt->execute(['level' => $level]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield Customer::arrayToEntity($row, new Customer());
        }
    }
    
    public function fetchByEmail($email)
    {
        $stmt = $this->connection->pdo->prepare(
                Finder::select('customer')
                ->where('email = :email')::getSql());
        $stmt->execute(['email' => $email]);
        return Customer::arrayToEntity(
                $stmt->fetch(PDO::FECTH_ASSOC), new Customer());
    }
    
    public function save(Customer $cust)
    {
        // check to see if customer ID > 0 and exists
        if ($cust->getId() && $this->fetchById($cust->getId())) {
            return $this->doUpdate($cust);
        } else {
            return $this->doInsert($cust);
        }
    }
    
    protected function doUpdate($cust)
    {
        // get properties in the form of an array
        $value = $cust->entityToArray();
        // build the SQL statement
        $update = 'UPDATE ' . $cust::TABLE_NAME;
        // unset ID as we want do not want this to be updated
        unset($values['id']);
        return $this->flush($update, $values, $where);
    }
    
    protected function doInsert($cust)
    {
        $values = $cust->entityToArray();
        $email  = $cust->getEmail();
        unset($values['id']);
        $insert = 'INSERT INTO ' . $cust::TABLE_NAME . ' ';
        if ($this->flush($insert, $values)) {
            return $this->fetchByEmail($email);
        } else {
            return FALSE;
        }
    }
    
    protected function flush($sql, $values, $where = '')
    {
        $sql .= ' SET ';
        foreach ($values as $column => $value) {
            $sql .= $column . ' = :' . $column . ',';
        }
        // get rid of trailing
        $sql     = substr($sql, 0, -1) . $where;
        $success = FALSE;
        try {
            $stmt = $this->connection->pdo->prepare($sql);
            $stmt->execute($values);
            $success = TRUE;
        } catch (PDOException $e) {
            error_log(__METHOD__ . ':' . __LINE__ . ':'
                   . $e->getMessage());
            $success = FALSE;
        } catch (Throwable $e) {
            error_log(__METHOD__ . ':' . __LINE__ . ':'
                   . $e->getMessage());
            $sucess = FALSE;
        }
        return $success;
    }
    
    public function remove(Customer $cust)
    {
        $sql =  'DELETE FROM ' . $cust::TABLE_NAME . ' WHERE id = :id';
        $stmt = $this->connection->pdo->prepate($sql);
        $stmt->execute(['id' => $cust->getId()]);
        return ($this->fetchById($cust->getId())) ? FALSE : TRUE;
    }
    
}