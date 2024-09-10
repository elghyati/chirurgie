$('#add-image').click(function () {
//    console.log("#add-image.click - start");
    //Récupérer le dernier induce de sous formulaires de #article_images 
    const index = +$("#widgets-images-counter").val(); //Le + pour convertir la valeur en un entier
    //Récupérer le prototype des sous-formulaires
    const tmpl = $('#admin_article_images').data('prototype').replace(/__name__/g, index);
    $("#widgets-images-counter").val(index + 1);
    // console.log(tmpl);
    $('#admin_article_images').append(tmpl);
    handleDeleteButtons();
//    console.log("#add-image.click - end");
});
function handleDeleteButtons() {
//    console.log('handleDeleteButtons() - start');
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
//    console.log('handleDeleteButtons() - end');
}
function updateCounter() {
    console.log('updateCounter() - start');
    const count = $('#admin_article_images div.form-group').length;
    console.log(count);
    $("#widgets-images-counter").val(count);
    console.log('updateCounter() - end');
}
//console.log('Document ready');
handleDeleteButtons();
updateCounter();
