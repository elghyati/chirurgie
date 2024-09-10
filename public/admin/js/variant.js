$('#add-variant').click(function () {
    console.log("#add-variant.click - start");
    //Récupérer le dernier induce de sous formulaires de #article_variants 
    const index = +$("#widgets-variants-counter").val(); //Le + pour convertir la valeur en un entier
    //Récupérer le prototype des sous-formulaires
    const tmpl = $('#admin_article_variants').data('prototype').replace(/__name__/g, index);
    $("#widgets-variants-counter").val(index + 1);
    // console.log(tmpl);
    $('#admin_article_variants').append(tmpl);
    handleDeleteButtons();
    handleAnchorButtons();
//    $('select').select2();
    initSelect2();
    handleAddButtons();
    console.log("#add-variant.click - end");
});

function handleDeleteButtons() {
//    console.log('handleDeleteButtons() - start');
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        const ds = this.dataset;
        console.log(ds);
        console.log(target);
        $(target).remove();
    });
//    console.log('handleDeleteButtons() - end');
}
function handleAnchorButtons() {
    $('button[data-action="position"]').click(function () {

        const target = "#" + this.dataset.target.slice(7);
        const posTop = target + "_posTop";
        const posLeft = target + "_posLeft";
        console.log(posTop);
        console.log(posLeft);
        $(posTop).val(148);
        $(posLeft).val(500);
    });
//    console.log('handleDeleteButtons() - end');
}

function updateCounter() {
    console.log('updateCounter() - start');
//    const count = $('#admin_article_variants div.form-group').length;
    const count = $('#admin_article_variants div.form-group').length;
    console.log(count);
    $("#widgets-variants-counter").val(count);
    console.log('updateCounter() - end');
}
//console.log('Document ready');
handleDeleteButtons();
updateCounter();
handleAnchorButtons();