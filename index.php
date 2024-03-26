<?php
ini_set('display_errors', 0);

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
                                id="<?= $user->user_id; ?>" class="btn editar" 
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

        <div id="remove_modal" class="modal">
            <div class="modal-content">
                <div class="modal-heading">
                    <span class="title">Tem certeza que deseja excluir o usuário?</span>
                </div>
                <div class="modal-buttons">
                    <button name="accept" class="btn Red">Sim</button>
                    <button name="refuse" class="btn">Cancelar</button>
                </div>
            </div>
        </div>
        
        <div id="create_modal" class="modal">
            <div class="modal-content">
                <div class="modal-heading">
                    <span class="title">Criar novo usuário</span>
                </div>
                <div class="modal-body">
                    <form id="create_modal_form">
                        <div class="input-group">
                            <label for="name">Nome </label>
                            <input type="text" value="" name="name">
                        </div>
                        <div class="input-group">
                            <label for="email">E-mail </label>
                            <input type="text" value="" name="email">
                        </div>
                        <div class="input-group break">
                            <label for="color">Selecione uma cor para o usuário</label>
                            <input type="hidden" name="color" id="color">
                            <ul class="colors-list">
                            <?php
                                $colors = $connection->query("SELECT * FROM `colors`");
                                foreach($colors as $color) :
                            ?>
                                <li class="color-group" onclick="pickColor(this.id)" attr-color-id="<?= $color->id; ?>" id="<?= $color->name; ?>">
                                    <div class="circle color <?= $color->name; ?> " name="color-circle"></div>
                                    <span class="color-name"><?= $color->name; ?></span>
                                </li>
                            <?php 
                                endforeach; 
                            ?>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-buttons">
                    <button name="cancel-create" class="btn">Cancelar</button>
                    <button name="create" class="btn btn-green">Cadastrar</button>
                </div>
            </div>
        </div>

        <div id="update_modal" class="modal">
            <div class="modal-content">
                <div class="modal-heading">
                    <span class="title">Editar usuário</span>
                </div>
                <div class="modal-body">
                    <form id="update_modal_form">
                        <div class="input-group">
                            <label for="name">Nome </label>
                            <input type="text" value="" name="new-user-name">
                        </div>
                        <div class="input-group">
                            <label for="email">E-mail </label>
                            <input type="text" value="" name="new-user-email">
                        </div>
                        <div class="input-group break">
                            <label for="color">Selecione uma cor para o usuário</label>
                            <input type="hidden" name="color">
                            <ul class="colors-list">
                            <?php
                                $colors = $connection->query("SELECT * FROM `colors`");
                                foreach($colors as $color) :
                            ?>
                                <li class="color-group" onclick="pickColor(this.id)" id="<?= $color->name; ?>" attr-color-id="<?= $color->id; ?>">
                                    <div class="circle color <?= $color->name; ?> " name="color-circle"></div>
                                    <span class="color-name"><?= $color->name; ?></span>
                                </li>
                            <?php 
                                endforeach; 
                            ?>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-buttons">
                    <button name="cancel-update" class="btn">Cancelar</button>
                    <button name="update" class="btn btn-green">Salvar</button>
                </div>
            </div>
        </div>

        <div id="success_modal" class="modal">
            <div class="modal-content">
                <div class="modal-heading">
                    <span class="title">Ação realizada com sucesso!</span>
                </div>
                <div class="modal-buttons">
                    <button class="dismiss btn btn-green" onclick="dismiss('#success_modal'); window.location.reload()">OK</button>
                </div>
            </div>
        </div>
        
        <div id="fail_modal" class="modal">
            <div class="modal-content">
                <div class="moal-heading">
                    <span class="title">Ocorreu um erro!</span>
                </div>
                <div class="modal-buttons">
                    <button class="dismiss btn" onclick="dismiss('#fail_modal'); window.location.reload()">OK</button>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        
        function get(e) {
            return document.querySelector(e);
        }
        
        function getAll(e) {
            return document.querySelectorAll(e);
        }

        function on(event, element, fn) {
            element.addEventListener(event, fn);
        }

        function dismiss(modal) {
            getAll(modal).forEach(e => {
                e.style.display = 'none';
            });
        }

        function open(modal) {
            dismiss('.modal');
            getAll(modal).forEach(e => {
                e.style.display = 'block';
            });
        }

        function pickColor(name) {  
            /**reset*/
            getAll('div[name=color-circle]').forEach( elem => elem.classList.remove('checked') ); 
            getAll('input[name=color]').forEach( elem => elem.value = "");
            /***/
            if( name.length === 0 ) return;
            let picked = get('#' + name);
            let color_id = picked.getAttribute('attr-color-id');
            getAll('input[name=color]').forEach( elem => elem.value = color_id);
            getAll('.' + name).forEach( elem => elem.classList.add('checked') );
            // const collection = document.getElementsByClassName(name);
            // for(let i=0; i < collection.length; i++) {
            //     collection[i].classList.add('checked');
            // }
        }

        function create(e) {
            e.preventDefault;
            
            open('#create_modal');
            
            const create = get('button[name=create]');
            on("click", create, () => {
                const data = new FormData( get('#create_modal_form') );
                fetch('create.php', {
                        method: 'POST',
                        body: data,
                        headers: {
                            'Accept': '*/*'
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        get('#success_modal > .modal-content > .modal-heading > span').innerHTML = "Usuário criado com sucesso!";
                        (response.error) ? open('#fail_modal') : open('#success_modal');
                    });
            });

            const cancel = get('button[name=cancel-create]');
            on("click", cancel, () => {
                dismiss('#create_modal');
            });
        }

        function update(e) {
            e.preventDefault;

            let user_name = e.getAttribute("attr-user-name");
            let user_email = e.getAttribute("attr-user-email");
            let color_name = e.getAttribute("attr-user-color-name");

            open('#update_modal');
            
            get('input[name=new-user-name]').value = user_name;
            get('input[name=new-user-email]').value = user_email;
            pickColor(color_name);

            const update = get('button[name=update]');
            on("click", update, () => {
                
                //keypress
                
                const data = new FormData( get( '#update_modal_form' ) );
                data.set( 'user_id', e.id );
                fetch('update.php', {
                        method: 'POST',
                        body: data,
                        headers: {
                            'Accept': '*/*'
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        get('#success_modal > .modal-content > .modal-heading > span').innerHTML = "Usuário atualizado com sucesso!";
                        (response.error) ? open('#fail_modal') : open('#success_modal');
                    });
            });

            const cancel = get('button[name=cancel-update]');
            on("click", cancel, () => {
                dismiss('#update_modal');
            });
        }
 
        function remove(e) {
            e.preventDefault;

            open('#remove_modal');

            const accept = get('button[name=accept]');
            const refuse = get('button[name=refuse]');

            on('click', accept, () => {
                const data = new FormData();
                data.set("id", e.id);
                fetch('remove.php', {
                        method: 'POST',
                        body: data,
                        headers: {
                            'Accept': '*/*'
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        get('#success_modal > .modal-content > .modal-heading > .title').innerHTML = "Usuário excluído!";
                        response.error ? open('#fail_modal') : open('#success_modal');
                    });
            });

            on('click', refuse, () => {
                dismiss('#remove_modal');
            });
        }
    </script>
</body>

</html>