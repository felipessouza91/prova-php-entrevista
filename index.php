<?php
ini_set('display_errors', 1);

require 'connection.php';

$connection = new Connection();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Prova-PHP</title>
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = $connection->query(
                                            "SELECT 
                                                u.`name` as user_name, 
                                                u.`id` as user_id, 
                                                u.`email` as user_email, 
                                                c.`name` as color_name, 
                                                c.`id` as color_id 
                                            FROM `users` u 
                                            LEFT JOIN `user_colors` uc ON uc.`user_id` = u.`id` 
                                            LEFT JOIN `colors` c ON c.`id` = uc.`color_id`
                                            ORDER BY u.`id` ASC"
                                        );
                foreach ($users as $user) :
                ?>
                    <tr>
                        <td>
                            <div class="circle <?= $user->color_name; ?>"></div>
                        </td>
                        <td name="user_id" id="<?= $user->user_id; ?>"><?= $user->user_id; ?></td>
                        <td name="user_name" id="<?= $user->user_name; ?>"><?= $user->user_name; ?></td>
                        <td name="user_email" id="<?= $user->user_email; ?>"><?= $user->user_email; ?></td>
                        <td>
                            <button 
                                name="editar" 
                                class="btn editar" 
                                id="<?= $user->user_id; ?>" 
                                onclick="update(this)" 
                                attr-user-email="<?= $user->user_email; ?>" 
                                attr-user-name="<?= $user->user_name; ?>"
                                attr-user-color-name="<?= $user->color_name; ?>"
                            >
                                Editar
                            </button>
                            <button name="excluir" id="<?= $user->user_id; ?>" class="btn excluir" onclick="remove(this)">
                                Excluir
                            </button>
                        </td>
                    </tr>

                <?php
                endforeach;
                ?>
            </tbody>
        </table>
        
        <button class="btn purple create" id="create" onclick="create(this)">Criar +</button>

    </div>

    <?php 
        include_once('./parts/modals/create-modal.php');
        include_once('./parts/modals/update-modal.php'); 
        include_once('./parts/modals/remove-modal.php');
        include_once('./parts/modals/success-modal.php'); 
        include_once('./parts/modals/fail-modal.php');
    ?> 

    <script type="text/javascript" src="./scripts/main.js"></script>

</body>

</html>