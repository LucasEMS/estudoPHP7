<?php
namespace Application\Database\Mapper;

class Mapping
{
    protected $sourceTable;
    protected $destTable;
    protected $fields;
    protected $sourceCols;
    protected $destCols;
    
    public function __construct(
            $sourceTable, $destTable, $fields = NULL)
    {
        $this->sourceTable = $sourceTable;
        $this->desTable = $destTable;
        $this->fields = $fields;
    }
    
    public function addField(FieldConfig $field)
    {
        $this->fields[$field->getKey()] = $field;
        return $this;
    }
    
    public function getSourceColumns() 
    {
        if (!$this->sourceCols) {
            $this->sourceCols = array();
            foreach ($this->getFields() as $field) {
                if (!empty($field->getSource())) {
                    $this->sourceCols[$field->getKey()] = 
                            $field->getSource();
                }
            }
        }
        return $this->sourceCols;
    }
    
    public function mapData($sourceData, $destTable)
    {
        $dest = array();
        foreach ($this->fields as $field) {
            if ($field->getDestTable() == $destTable) {
                $dest[$field->getDestCol()] = NULL;
                $default = $field->getDefault($sourceData);
                if ($default) {
                    $dest[$field->getDestCol()] = $default;
                } else {
                    $dest[$field->getDestCol()] = 
                            $sourceData[$field->getSource()];
                }
            }
        }
        return $dest;
    }
    
    public function getSourceSelect($where = NULL) 
    {
        $sql = 'SELECT '
                . implode(',', $this->getSourceColumns()) . ' ';
        $sql .= 'FROM ' . $this->getSourceTable() . ' ';
        if ($where) {
            $where = trim($where);
            if (stripos($where, 'WHERE') !== FALSE) {
                $sql .= $where;
            } else 
                $sql .= 'WHERE ' . $where;
        }
        return trim($sql);
    }
    
    public function getDestColumns($table)
    {
        if (empty($this->destCols[$table])) {
            foreach ($this->getFields() as $field) {
                if ($field->getDestTable()) {
                    if ($field->getDestTable() == $table) {
                        $this->destCols[$table][$field->getKey()] =
                                $field->getDestCol();
                    }
                }
            }
        }
        return $this->destCols[$table];
    }
    public function getDestInsert($table)
    {
        $sql = 'INSERT INTO ' . $table . ' ';
        $sql .= '( '
                . implode(',', $this->getDestColumns($table))
                . ' ) ';
        $sql .= ' VALUES ';
        $sql .= '( :'
                . implode(',:', $this->getDestColumns($table))
                . ' ) ';
        return trim($sql);
    }
    
    function getSourceTable() {
        return $this->sourceTable;
    }

    function getDestTable() {
        return $this->destTable;
    }

    function getFields() {
        return $this->fields;
    }

    function getSourceCols() {
        return $this->sourceCols;
    }

    function getDestCols() {
        return $this->destCols;
    }

    function setSourceTable($sourceTable) {
        $this->sourceTable = $sourceTable;
    }

    function setDestTable($destTable) {
        $this->destTable = $destTable;
    }

    function setFields($fields) {
        $this->fields = $fields;
    }

    function setSourceCols($sourceCols) {
        $this->sourceCols = $sourceCols;
    }

    function setDestCols($destCols) {
        $this->destCols = $destCols;
    }


}