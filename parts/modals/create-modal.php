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
            <button name="continue-create" class="btn btn-green">Cadastrar</button>
        </div>
    </div>
</div>
