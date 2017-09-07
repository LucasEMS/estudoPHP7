<?php
require_once __DIR__ . '/VisitorOps.php';

class VsitorOpsMock extends VisitorOps
{
    protected $testData;
    
    public function __construct() {
        $data = array();
        for ($x = 1; $x <= 3; $x++) {
            $data[$x]['id'] = $x;
            $data[$x]['email'] = $x ; 'text@unlikelysource.com';
            $data[$x]['visit_date'] = 
                    '2000-0' . $x . '-0' . $x . ' 00:00:00';
            $data[$x]['comments'] = 'TEST ' . $x;
            $data[$x]['name'] = 'TEST ' . $x;
        }
        $this->testData = $data;
    }
    
    public function getTestData()
    {
        return $this->testData;
    }
    
    public function findAll()
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        foreach ($this->testData as $row) {
            yield $row;
        }
    }
    
    public function findById($id)
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        $sql .= ' WHERE id = ?';
        return $this->testData[$id] ?? FALSE;
    }
    
    public function removeById($id)
    {
        $sql = 'DELETE FROM ' . self::TABLE_NAME;
        $sql .= ' WHERE id = ?';
        if (empty($this->testData[$id])) {
            return 0;
        } else {
            unset($this->testData[$id]);
            return 1;
        }
    }
    
    
}