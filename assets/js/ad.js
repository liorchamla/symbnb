const $ = require('jquery');
const ClassicEditor = require('@ckeditor/ckeditor5-build-classic');


/**
 * Mise en place de l'éditeur riche CKEditor
 */
let editor;

// Instanciation
ClassicEditor
    // On créé l'instance sur l'élément ad_content (textarea)
    .create( document.querySelector( '#ad_content' ) )
    // Une fois que c'est fait, on référence l'instance dans la variable editor
    .then(instance => editor = instance)
    .catch( error => {
        console.error( error );
    });

/**
 * Possibilité d'ajout d'autres images
 */
$('#add-image').click(function(){
    // On récupère le nombre d'images déjà présentes
    const index = $('#ad_images fieldset').length;
    // On récupère le prototype qui sert à afficher les contrôles pour une image
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
    // On créé un élément qui correspond au prototype
    const element = $(tmpl);
    // On l'ajoute à la div #ad_images
    $('#ad_images').append(element);
    
    // On réapplique les gestionnaires d'événement pour les boutons de suppression
    $('[data-action="delete"]').click(function(){
        $(this).parent().parent().parent().remove();
    })
});

/**
 * Gestion de la soumission dans le cas d'une description vide !
 */
$('form[name="ad"]').submit((e) => {
    const data = editor.getData();
    if(data.trim() === '' || data.trim() === '<p>&nbsp;</p>') {
        e.preventDefault();
        alert('Vous devez fournir une description détaillée pour votre bien !');
    }
})