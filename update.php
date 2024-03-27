<?php
try {
    ini_set('display_errors', 0);
    
    require 'connection.php';

    $connection = new Connection();
    
    $connection->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_POST['user_id'];
    $user_name = $_POST['new-user-name'];
    $user_email = $_POST['new-user-email'];
    $color_id = $_POST['color'];
    
    $connection->query("UPDATE `users` SET name = '$user_name', email = '$user_email' WHERE id = $user_id");

    $user_colors = $connection->query("SELECT COUNT(*) as count FROM `user_colors` WHERE `user_id` = $user_id")->fetch();

    if( $user_colors->count ) {
        $connection->query("UPDATE `user_colors` SET color_id = $color_id WHERE user_id = $user_id");
    } else {
        if( ! empty( $color_id ) ) { 
            $connection->query("INSERT INTO `user_colors` (`user_id`, `color_id`) VALUES ($user_id, $color_id)");
        }
    }

    echo json_encode( [ "error" => false ] );

} catch(PDOException $e) {
    echo json_encode( [ "error" => true, "message" => $e->getMessage() ] );
}