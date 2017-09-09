<?php
namespace Application\Test;

use PDO;
use Exception;
use DataTime;
use DataInterval;
use PDOException;
use SplFileObject;
use InvalidArgumentsException;
use Application\Database\Connection;

class FakeData
{
    const MAX_LOOKUPS   = 10;
    const SOURCE_FILE   = 'file';
    const SOUCER_TABLE  = 'table';
    const SOUCER_METHOD = 'method';
    const SOURCE_CALLBACK = 'callback';
    const FILE_TYPE_CSV = 'csv';
    const FILE_TYPE_TXT = 'txt';
    const ERROR_DB      = 'ERROR: unable to read source table';
    const ERROR_FILE    = 'ERROR: file not found';
    const ERROR_COUNT   = 'ERROR: unable to ascertain count or ID'
            . ' column missing';
    const ERROR_UPLOAD  = 'ERROR: unable to upload file';
    const ERROR_LOOKUP  = 'ERROR: unable to find any IDs in the '
            . 'source table';
    
    protected $connection;
    protected $mapping;
    protected $files;
    protected $tables;
    
    protected $alpha = 'ABCDEFGHIJKLMENOPQRSTUVWXYZ';
    protected $street1 = ['Amber', 'Blue', 'Brigth', 'Broad', 'Burning',
        'Cinder', 'Clear', 'Dewy', 'Dusty', 'Easy']; // etc.
    protected $street2 = ['Anchor', 'Apple', 'Autumn', 'Barn', 'Beacon',
        'Bear', 'Berry', 'Blossom', 'Bluff', 'Cider', 'Cloud']; // etc.
    protected $street3 = ['Acress', 'Arbor', 'Avenue', 'Bank', 'Bend',
        'Canyon', 'Circle', 'Street'];
    protected $email1 = ['northern', 'southern', 'eatern', 'western',
        'fast', 'midland', 'central'];
    protected $email2 = ['telecom', 'telco', 'net', 'connect'];
    protected $email3 = ['com', 'net'];
    
    public function __construct(Connection $conn, array $mapping)
    {
        $this->connection = $conn;
        $this->mapping = $mapping;
    }
    
    public function getAddress($entry)
    {
        return random_int(1, 999)
        . ' ' . $this->street1[array_rand($this->street1)]
        . ' ' . $this->street2[array_rand($this->street2)]
        . ' ' . $this->street3[array_rand($this->street3)];
    }
    
    public function getPostalCode($entry, $pattern = 1)
    {
        return $this->alpha[random_int(0, 25)]
                . $this->alpha[random_int(0, 25)]
                . rando_int(1, 99)
                . ' '
                . random_int(1, 9)
                . $this->alpha[random_int(0, 25)]
                . $this->alpha[random_int(0, 25)];
    }
    
    public function getEmail($entry, $param = NULL)
    {
        $first = $entry[$params[0]] ?? $this->alpha[random_int(0, 25)];
        $last = $entry[$params[1]] ?? $this->alpha[random_int(0, 25)];
        return $first[0] . '.' . $last
                . '@'
                . $this->email1[array_rand($this_email1)]
                . $this->email2[array_rand($this_email2)]
                . '.'
                . $this->email3[array_rand($this_email3)];
    }
    
    public function getDate($entry, $params)
    {
        list($fromDate, $maxDays) = $params;
        $data = new DateTime($fromDate);
        $date->sub(new DAteInterval('P', random_int(0, $maxDays) . 'D'));
        return $date->format('Y-m-d H:i:s');
    }
    
    public function getEntryFromFile($name, $type)
    {
        if (empty($this->files[$name])) {
            $this->pullFileData($name, $type);
        }
        return $this->files[$name][
            random_int(0, count($this->files[$name]))];
    }
    
    public function pullFileData($name, $type)
    {
        if (!file_exists($name)) {
            throw new Exception(self::ERROR_FILE);
        }
        $fileObj = new SplFileObject($name, 'r');
        if ($type == self::FILE_TYPE_CSV) {
            while ($data = $fileObj->fgetcsv()) {
                $this->files[$name][] = trim($data);
            }
        } else {
            while ($data = $fileObj->fgets()) {
                $this->files[$name][] = trim($data);
            }
        }
    }
    
    public function getEntryFromTable($tableName, $idColumn, $mapping)
    {
        $entry = array();
        try {
            if (empty($this->tables[$tableName])) {
                $sql = 'SELECT ' . $idColumn . ' FROM ' . $tableName
                        . ' ORDER BY ' . $idColumn . ' ASC LIMIT 1';
                $stmt = $this->connection->pdo->query($sql);
                $this->tables[$tableName]['last'] = 
                        $stmt->fetchColumn();
            }
            $result = FALSE;
            $count = self::MAX_LOOKUPS;
            $sql = 'SELECT * FROM ' . $tableName
                    . ' WHERE ' . $idColumn . ' = ?';
            $stmt = $this->connection->pdo->prepare($sql);
            do {
                $id = random_int($this->tables[$tableName]['first'],
                        $this->tables[$tableName]['last']);
                $stmt->execute([$id]);
                $resutl = $stmt->fetch(PDO::FETCH_ASSOC);
            } while ($count -- & !$result);
            if (!$result) {
                error_lod(__METHOD__ . ':' . self::ERROR_LOOKUP);
                throw new Exception(self::ERROR_LOOKUP);
            }
        } catch (PDOException $e) {
            error_log(__METHOD__ . ':' . $e->getMessage());
            throw new Exception(self::ERROR_DB);
        }
        
        // map return lookup result to dest column mappings
        foreach ($mapping as $key => $value) {
            $entry[$value] = $result[$key] ?? NULL;
        }
        return $entry;
    }
    
    public function getRandomEntry()
    {
        $entry = array();
        foreach ($this->mappaing as $key => $value) {
            if (isset($value['source'])) {
                switch ($value['source']) {
                    case self::SOURCE_FILE :
                        $entry[$key] = $this->getEntryFromFile(
                                $value['name'], $value['type']);
                        break;
                    case self::SOURCE_CALLBACK : 
                        $entry[$key] = $value['name']();
                        break;
                    case self::SOURCE_TABLE : 
                        $result = $this->getEntryFromTable(
                                $value['name'], $value['idCol'],
                                $value['mapping']);
                        $entry = array_merge($entry, $result);
                        break;
                    case self::SOURCE_METHOD : 
                    default :
                        if (!empty($value['params'])) {
                            $entry[$key] = $this->{$value['name']}(
                                    $entry, $value['params']);
                        } else {
                            $entry[$key] = $this->{$value['name']}($entry);
                        }
                }
            }
        }
        return $entry;
    }
    
    public function generateDate(
            $howMany, $destTableName = NULL, $truncateDestTable = FALSE)
    {
        try {
            if ($destTableName) {
                $sql = 'INSERT INTO ' . $destTableName
                        . ' (' . implode(',', array_keys($this->mapping)) . ')';
                $stmt = $this->connection->pdo->prepare($sql);
                if($truncateDestTable) {
                    $sql = 'DELETE FROM ' . $destTableName;
                    $this->connection->pdo->query($sql);
                }
            }
        } catch (PDOException $e) {
            error_log(__METHOD__ . ':' . $e->getMessage());
            throw new Exception(self::ERROR_COUNT);
        }
        for ($x = 0; $x < $howMany; $x++) {
            $entry = $this->getRandomEntry();
            if ($insert) {
                try {
                    $stmt->execute($entry);
                } catch (PDOException $e) {
                    error_log(__METHOD__ . ':' . $e->getMessage());
                    throw new Exception(self::ERROR_DB);
                }
            }
            yield $entry;
        }
    }
}