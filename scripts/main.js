"use strict";

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

function keyup(e) {
    on("keyup", e, (e) => {
        let action = e.target.id;
        switch(e.key) {
            case 'Escape':
                get(`button[name=cancel-${action}]`).click();
                break;
            case 'Enter':
                get(`button[name=continue-${action}]`).click();
                break;
        }
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
}

function create(e) {

    open('#create_modal');
    
    const continueCreate = get('button[name=continue-create]');
    on("click", continueCreate, () => {
        const form = get('#create_modal_form');
        const data = new FormData( form );
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
                get('#success_modal > .modal-content > .modal-heading > .title').innerHTML = "Usuário criado com sucesso!";
                (response.error) ? open('#fail_modal') : open('#success_modal');
            });
    });

    const cancelCreate = get('button[name=cancel-create]');
    on("click", cancelCreate, () => {
        dismiss('#create_modal');
    });
}

function update(e) {
    e.preventDefault;

    let user_name = e.getAttribute("attr-user-name");
    let user_email = e.getAttribute("attr-user-email");
    let color_name = e.getAttribute("attr-user-color-name");

    open('#update_modal');

    //keyup(e);
    
    get('input[name=new-user-name]').value = user_name;
    get('input[name=new-user-email]').value = user_email;
    pickColor(color_name);

    const update = get('button[name=continue-update]');
    on("click", update, () => {
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
                get('#success_modal > .modal-content > .modal-heading > .title').innerHTML = "Usuário atualizado com sucesso!";
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

    //keyup(e);

    const remove = get('button[name=continue-remove]');
    const cancel = get('button[name=cancel-remove]');

    on('click', remove, () => {
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
                if(response.error) open('#fail_modal');
                dismiss('#remove_modal');
                window.location.reload();
                // get('#success_modal > .modal-content > .modal-heading > .title').innerHTML = "Usuário excluído!";
                // response.error ? open('#fail_modal') : open('#success_modal');
            });
    });

    on('click', cancel, () => {
        dismiss('#remove_modal');
    });
}