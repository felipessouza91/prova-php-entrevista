<?php
try {
    ini_set('display_errors', 0);

    require 'connection.php';

    $connection = new Connection();
    
    $connection->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_POST['id'];

    $connection->query("DELETE FROM `users` WHERE `id` = $user_id");

    $connection->query("DELETE FROM `user_colors` WHERE `user_id` = $user_id");

    echo json_encode( [ "error" => false ] );

} catch(PDOException $e) {
    echo json_encode( [ "error" => true, "message" => $e->getMessage() ] );
}