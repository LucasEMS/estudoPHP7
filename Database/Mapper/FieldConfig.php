<?php
namespace Application\Database\Mapper;
use InvalidArgumentException;

class FieldConfig
{
    const ERROR_SOURCE = 'ERROR: need to specify desTable and/or source';
    const ERROR_DEST = 'ERROR; need to specify either '
            . 'both desTable and desCol or neither';
    
    public $key;
    public $source;
    public $destTable;
    public $destCol;
    public $default;
    
    public function __construct($source = NULL,
                                $destTable = NULL,
                                $destCol = NULL,
                                $default = NULL)
    {
        // generate key from source + desTable + destCol
        $this->key = $source . '.' . $destTable . '.' . $destCol;
        $this->source = $source;
        $this->destTable = $destTable;
        $this->destCol = $destCol;
        $this->default = $default;
        if (($destTable && !$destCol) ||
                (!$destTable && $destCol)) {
            throw new InvalidArgumentException(self::ERROR_SOURCE);
        }
        if (!$destTable && !$source) {
            throw new InvalidArgumentException(
                    self::ERROR_SOURCE);
        }
    }
    
    public function getDefault($row = array())
    {
        if (is_callable($this->default)) {
            return call_user_func($this->default, $row);
        } else {
            return $this->default;
        }
    }
    
    function setKey($key) {
        $this->key = $key;
    }

    function setSource($source) {
        $this->source = $source;
    }

    function setDestTable($desTable) {
        $this->destTable = $desTable;
    }

    function setDestCol($destCol) {
        $this->destCol = $destCol;
    }

    function setDefault($default) {
        $this->default = $default;
    }

    function getKey() {
        return $this->key;
    }

    function getSource() {
        return $this->source;
    }

    function getDestTable() {
        return $this->destTable;
    }

    function getDestCol() {
        return $this->destCol;
    }


}
