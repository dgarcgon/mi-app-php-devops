<?php

$appEnv = getenv('APP_ENV') ?: 'local';

$result = [
    "message" => "Hola DevOps con MySQL!",
    "environment" => $appEnv,
    "hostname" => gethostname(),
    "php_version" => phpversion(),
    "timestamp" => date('Y-m-d H:i:s')
];

try {

    $pdo = new PDO(
        "mysql:host=db;dbname=devopsdb;charset=utf8mb4",
        "devops",
        "devopspass"
    );

    $stmt = $pdo->query("SELECT NOW() AS mysql_now");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $result["database"] = "Conectado";
    $result["mysql_time"] = $row["mysql_now"];

} catch (Exception $e) {

    $result["database"] = "ERROR";
    $result["error"] = $e->getMessage();

}

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT) ;
