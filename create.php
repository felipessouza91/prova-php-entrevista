<?php
try {
    ini_set('display_errors', 1);
    
    require 'connection.php';

    $connection = new Connection();
    
    $connection->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $color_id = $_POST['color'];

    $user = $connection->query("INSERT INTO `users` (`name`, `email`) VALUES ('$user_name', '$user_email')");
    var_dump($user);
    // $user_id = $connection->getConnection()->lastInsertId();

    // $user_colors = $connection->query("SELECT COUNT(*) as count FROM `user_colors` WHERE `user_id` = $user_id")->fetch();

    // if( $user_colors->count ) {
    //     $connection->query("UPDATE `user_colors` SET color_id = $color_id WHERE `user_id` = $user_id");
    // } else {
    //     $connection->query("INSERT INTO `user_colors` (`user_id`, `color_id`) VALUES ($user_id, $color_id) ");        
    // }
    
    echo json_encode( [ "error" => false ] );

} catch(PDOException $e) {
    echo json_encode( [ "error" => true, "message" => $e->getMessage() ] );
}