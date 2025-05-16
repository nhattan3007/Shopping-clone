<?php

return array(
    'base'=> 'Shopping-clone/',
    'baseURL'=> 'http://localhost/Shopping-clone/',
    'assets'=> 'Shopping-clone/Assests',
    'db'=> array(
        'host'=> 'localhost',
        'name'=> 'test',
        'username'=> 'root',
        'password'=> '',
    )
);
include_once  __DIR__ . '/Core/db.php';
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