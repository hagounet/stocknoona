$(document).ready(function() {


    var $container = $('div#form_categories');

    var $lienAjout = $('<a href="#" id="ajout_categorie" class="btn btn-primary">Ajouter une catégorie</a>');
    $container.append($lienAjout);

    $lienAjout.click(function(e) {
    ajouterCategorie($container);
    e.preventDefault();
    return false;
    });

var index = $container.find(':input').length;

if (index == 0) {
    ajouterCategorie($container);
    } else {
    $container.children('div').each(function()
    {
        ajouterLienSuppression($(this));
    });
}

function ajouterCategorie($container)
            {
                // Dans le contenu de l'attribut « data-prototype », on remplace :
                // - le texte "__name__label__" qu'il contient par le label du champ
                // - le texte "__name__" qu'il contient par le numéro du champ
                var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Catégorie n°' + (index+1))
                .replace(/__name__/g, index));

                ajouterLienSuppression($prototype);

                // On ajoute le prototype modifié à la fin de la balise <div>
                $container.append($prototype);

                // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
                index++;
                }
// La fonction qui ajoute un lien de suppression d'une catégorie
function ajouterLienSuppression($prototype) {

    // Création du lien
    $lienSuppression = $('<a href="#" class="btn btn-danger">Supprimer</a>');

    // Ajout du lien
    $prototype.append($lienSuppression);

    $lienSuppression.click(function(e) {
    $prototype.remove();
    e.preventDefault();
    return false;
    });
}


});


