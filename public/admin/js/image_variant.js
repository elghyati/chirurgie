function handleAddButtons() {
    console.log('handleAddButtons');
    $('.image_variant_adder').unbind();
    $('.image_variant_adder').click(function () {
//    console.log("#add-image_variant.click - start");
        //Récupérer le dernier induce de sous formulaires de #variant_images 
        const index = +$("#widgets-images_variant-counter").val(); //Le + pour convertir la valeur en un entier
        console.log(index);

        //Récupérer le prototype des sous-formulaires
//        console.log($(this).parent().parent().children('div.first'));
        console.log($(this).parent().prev().children('div'));
        const form = $(this).parent().prev().children('div');
//        const form = $(this).parent().parent().children('div.first');
        console.log(form);
        console.log(form.data('prototype'));
//        block_admin_article_variants_0_images_0
//    const tmpl = $('#admin_article_variants_0_images').data('prototype').replace(/__name__/g, index);
        var tmpl = form.data('prototype').replace(/__name__/g, index);
//        const tmpl = form.data('prototype').replace(/_images__name__/g, '_images_' + index);
//        const tmpl = tmpl.replace(/__name__/g, index);
        tmpl = tmpl.replace(/images_(\d+)/g, 'images_' + index);
        tmpl = tmpl.replace(/\[images\]\[(\d+)\]/g, '[images][' + index + ']');
        console.log(tmpl);
        $("#widgets-images_variant-counter").val(index + 1);
        form.append(tmpl);
//    $('#admin_article_variants_0_images').append(tmpl);
        handleDeleteButtons();
//    console.log("#add-image.click - end");
    });
}
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
//    const count = $('#admin_variant_images div.form-group').length;
    const artVariantImgs = $('[id ^=admin_article_variants_][id $=_images] fieldset');
//    const artVariantImgs = $('[id ^=admin_article_variants_][id $=_images] div.form-group');
//    const artVariantImgs = $('#admin_article_variants_\d_images');

    console.log(artVariantImgs);
    const count = artVariantImgs.length;
    console.log(count);
//    '[id ^=aName][id $=EditMode]'
//    "input[name^='news']" 
//    admin_article_variants_16_images
    $("#widgets-images_variant-counter").val(count);
    console.log('updateCounter() - end');
}
//console.log('Document ready');
handleAddButtons();
handleDeleteButtons();
updateCounter();
