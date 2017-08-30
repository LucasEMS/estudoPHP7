<?php
define('DB_CONFIG_FILE', '/../data/config/db.config.php');
define('DEFAULT_PHOTO', 'person.gif');
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');
use Application\Database\Mapper\ { FieldConfig, Mapping };
use Application\Database\Connection;

$conn = new Connection(include __DIR__ . DB_CONFIG_FILE);

$conn->pdo->query('DELETE FROM customer_11');
$conn->pdo->query('DELETE FROM profile_11');

$mapper = new Mapping('prospects_11', ['customer_11', 'profile_11']);

$mapper->addField(new FieldConfig('email', 'customer_11', 'email'))
        ->addField(new FieldConfig('first_name', 'customer_11', 'name', 
                function ($row) { return trim(($row['first_name'] ?? '')
                . ' ' . ($row['last_name'] ?? ''));}))
        ->addField(new FieldConfig('last_name'))
        ->addField(new FieldConfig('status', 'customer_11', 'status',
                function ($row) { return $row['status'] ?? 'Unknown'; }))
        ->addField(new FieldConfig(NULL, 'customer_11', 'level', 'BEG'))
        ->addField(new FieldConfig(NULL, 'customer_11', 'password', 
                function ($row) { return $row['phone']; }))
        ->addField(new FieldConfig('address', 'profile_11', 'address'))
        ->addField(new FieldConfig('city', 'profile_11', 'city'))
        ->addField(new FieldConfig('state_province', 'profile_11', 'state_province', 
                function ($row) { return $row['state_province'] ?? 'Unknown'; } ))
        ->addField(new FieldConfig('postal_code', 'profile_11', 'postal_code'))
        ->addField(new FieldConfig('phone', 'profile_11', 'phone'))
        ->addField(new FieldConfig('country', 'profile_11', 'country'))
        ->addField(new FieldConfig(NULL, 'profile_11', 'photo', DEFAULT_PHOTO))
        ->addField(new FieldConfig(NULL, 'profile_11', 'dob', date('Y-m-d')));
                
$idCallback = function ($row) { return $row['id']; };
$mapper->addField(new FieldConfig('id', 'customer_11', 'id',
        $idCallback))
       ->addField(new FieldConfig(NULL, 'customer_11', 'profile_id',
        $idCallback))
       ->addField(new FieldConfig('id', 'profile_11', 'id', 
        $idCallback));

$sourceSelect   = $mapper->getSourceSelect();
$custInsert     = $mapper->getDestInsert('customer_11');
$profileInsert  = $mapper->getDestInsert('profile_11');

$sourceStmt     = $conn->pdo->prepare($sourceSelect);
$custStmt       = $conn->pdo->prepare($custInsert);
$profileStmt    = $conn->pdo->prepare($profileInsert);

$sourceStmt->execute();

while ($row = $sourceStmt->fetch(PDO::FETCH_ASSOC)) {
    $custData = $mapper->mapData($row, 'customer_11');

    $custStmt->execute($custData);
    $profileData = $mapper->mapData($row, 'profile_11');
    $profileStmt->execute($profileData);
    echo "Processing: {$custData['name']}\n";
    
}