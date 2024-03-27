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
            <button name="continue-update" class="btn btn-green">Salvar</button>
        </div>
    </div>
</div>