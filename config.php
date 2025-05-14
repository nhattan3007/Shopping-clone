<?php

return array(
    'base'=> 'demo/',
    'baseURL'=> 'http://localhost/demo/',
    'assets'=> 'demo/assets',
    'db'=> array(
        'host'=> 'localhost',
        'name'=> 'productdb',
        'username'=> 'root',
        'password'=> '',
    )
);
include __DIR__ . '/Core/db.php';
$conn = new mysqli(
    $config['db']['host'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['name']
);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>