

<?php

$db=new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$stmt = $db->prepare("SELECT * FROM subscription_package ORDER BY id DESC LIMIT 100");
if ($stmt->execute()) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $inbox_loaded = count($result);

    return $result;
    
} else {
    $inbox_loaded = 0;
    }
?>