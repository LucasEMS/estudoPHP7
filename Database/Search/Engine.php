<?php
namespace Application\Database\Search;
use PDO;
use Application\Database\Connection;

class Engine
{
    const ERROR_PREPARE = 'ERROR: unable to prepare statement';
    const ERROR_EXECUTE = 'ERROR: unable to execute statement';
    const ERROR_COLUMN  = 'ERROR: column name not on list';
    const ERROR_OPERATOR= 'ERROR: operator not on list';
    const ERROR_INVALID = 'ERROR: invalid search criteria';
    
    protected $connection;
    protected $table;
    protected $columns;
    protected $mapping;
    protected $statement;
    protected $sql = '';
    
    protected $operators = [
        'LIKE'      => 'Equals',
        '<'         => 'Less Than',
        '>'         => 'Greater Than',
        '<>'        => 'Not Equals',
        'NOT NULL'  => 'Exists',
    ];
    
    public function __construct(Connection $connection, 
            $table, array $columns, array $mapping)
    {
        $this->connection = $connection;
        $this->setTable($table);
        $this->setColumns($columns);
        $this->setMapping($mapping);
    }
    
    
    public function prepareStatement(Criteria $criteria)
    {
        $this->sql = 'SELECT * FROM ' . $this->table . ' WHERE ';
        $this->sql .= $this->mapping[$criteria->key] . ' ';
        switch ($criteria->operator) {
            case  'NOT NULL' :
                $this->sql .= ' IS NOT NULL OR ';
                break;
            default :
                $this->sql .= $criteria->operator . ' :'
                    . $this->mapping[$criteria->key] . ' OR ';
        }
        
        $this->sql = substr($this->sql, 0, -4) 
                . ' ORDER BY ' . $this->mapping[$criteria->key];
        $statement = $this->connection->pdo->prepare($this->sql);
        return $statement;
    }
    
    public function search(Criteria $criteria)
    {
       
        if (empty($criteria->key) || empty($criteria->operator)) {
           
            yield ['error' => self::ERROR_INVALID];
            return FALSE;
        }
         
        try {
            if (!$statement = $this->prepareStatement($criteria)) {
                yield ['error' => self::ERROR_PREPARE];
                return FALSE;
            }
            
            $params = array();
            switch ($criteria->operator) {
                case 'NOT NULL' :
                    // do nothing:: already in statement
                    break;
                case 'LIKE' :
                    $params[$this->mapping[$criteria->key]] = 
                        '%' . $criteria->item . '%';
                    break;
                default :
                    $params[$this->mapping[$criteria->key]] = 
                        $criteria->item;
            }
            $statement->execute($params);

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                yield $row;
            }
            
        } catch (Throwable $e) {
            error_log(__METHOD__ . ':' . $e->getMessage());
            throw new Exception(self::ERROR_EXECUTE);
        }
        return TRUE;
    }
    
    
    function setConnection($connection) {
        $this->connection = $connection;
    }

    function setTable($table) {
        $this->table = $table;
    }

    function setColumns($columns) {
        $this->columns = $columns;
    }

    function setMapping($mapping) {
        $this->mapping = $mapping;
    }

    function setStatement($statement) {
        $this->statement = $statement;
    }

    function setSql($sql) {
        $this->sql = $sql;
    }

    function setOperators($operators) {
        $this->operators = $operators;
    }

    function getConnection() {
        return $this->connection;
    }

    function getTable() {
        return $this->table;
    }

    function getColumns() {
        return $this->columns;
    }

    function getMapping() {
        return $this->mapping;
    }

    function getStatement() {
        return $this->statement;
    }

    function getSql() {
        return $this->sql;
    }

    function getOperators() {
        return $this->operators;
    }



}

