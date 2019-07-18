$('#add-image').click(function(){
    const index = +$('#widgets-counter').val();

    const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);

    $('#annonce_images').append(tmpl);

    $("#widgets-counter").val(index + 1);

    handleDeleteButtons();
})

function handleDeleteButtons(){
    // Au click sur le bouton avec l'attribut data-action="delete"
    $('button[data-action="delete"]').click(function(){

        // On récupèère la cible contenu dans l'attribut data-target
        const target = this.dataset.target;

        // On supprime la cible
        $(target).remove();

    })
}

function updateCounter(){
    const count = +$('#annonce_images div.form-group').length;

    $('#widgets_counter').val(count);
}

updateCounter();

handleDeleteButtons();