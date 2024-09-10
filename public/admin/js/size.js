$('#add-size').click(function () {
//    console.log("#add-size.click - start");
    //Récupérer le dernier induce de sous formulaires de #article_sizes 
    const index = +$("#widgets-sizes-counter").val(); //Le + pour convertir la valeur en un entier
    //Récupérer le prototype des sous-formulaires
    const tmplorigin = $('#admin_article_sizes').data('prototype').replace(/__name__/g, index);
    tmpl = tmplorigin.replace('type=', 'value="S" type=');
    $("#widgets-sizes-counter").val(index + 1);
    console.log(tmpl);
    $('#admin_article_sizes').append(tmpl);
    handleDeleteButtons();
//    console.log("#add-size.click - end");
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
//    console.log('updateCounter() - start');
    const count = $('#admin_article_sizes div.form-group').length;
    $("#widgets-sizes-counter").val(count);
//    console.log('updateCounter() - end');
}
//console.log('Document ready');
handleDeleteButtons();
updateCounter();
