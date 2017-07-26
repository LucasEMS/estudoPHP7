<?php
namespace Application\Generic;

use PDO;
use Exception;
use Application\Database\Connection;
use Application\Database\ConnectionAwareInterface;

class ListFactory
{
    const ERROR_AWARE = 'Class must be Connection Aware';
    public static function factory(
    ConnectionAwareInterface $class, $dbParams)
    {
        if ($class instanceof ConnectionAwareInterface) {
            // set up database connection
            $class->setConnection(new Connection($dbParams));
            return $class;
        } else {
            throw new Exception(self::ERROR_AWARE);
        }
        return FALSE;
    }
}
