<?php
namespace Application\Database;

use Exception;
use PDO;

class Connection
{
    const ERROR_UNABLE = 'ERRO: Unable to create database connection';
    
    public $pdo;
    
    /**
     * Creates PDO connection
     * 
     * @param array $config = key/value pais whice are used to buld the
     *                        DSN i.e. ['host' => $host, 'dbname' =>
     *                        $dbname, etc. ]
     */
    public function __construct(array $config)
    {
        // make sure driver is set
        if (!isset($config['driver'])) {
            $message = __METHOD__ . ' : ' . self::ERROR_UNABLE . PHP_EOL;
            throw new Exception($message);
        }
        
        $dsn = $config['driver']
                . ':host=' . $config['host']
                . ';dbname=' . $config['dbname'];
        try { 
            $this->pdo = new PDO($dsn,
                    $config['user'],
                    $config['password'],
                    [PDO::ATTR_ERRMODE => $config['errmode']]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }
    
    public static function factory(
            $driver, $dbname, $host, $user, $pwd, array $options = [])
    {
        // build DSN
        $dsn = sprintf('%s:dbname=%s;host=%s', $driver, $dbname, $host);
        try {
            return new PDO($dsn, $user, $pwd, $options);
        } catch (PDOException $e) {
            error_log($e->getMessage);
        }
    }
}
