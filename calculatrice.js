/************************************************
*    Auteur : BELLO Noah
*    Date du projet : 16/03/2023 - 25/03/2023
*    Nom du fichier : calculatrice.js
************************************************/

let calcul = document.getElementById("affiche_calcul_resultat"); // Récupération de l'élément pour ensuite l'utiliser pour écrire dedans et afficher le résultat

let buttons = document.getElementsByClassName("button"); // Récupération d'une liste de boutons

// Fonction pour afficher le calcul selon le bouton
function affichage_calcul(affichage, touche, index) {

    // Cas des opérateurs
    if ((touche[index].value == "+") || (touche[index].value == "-") || (touche[index].value == "x") || (touche[index].value == "/")) {

        affichage.value += " " + touche[index].value + " "; // Affichage dans le champ de calcul

    }

    // Cas de la parenthèse ouvrante
    else if (touche[index].value == "(") {

        affichage.value += touche[index].value + " "; // Affichage dans le champ de calcul

    }

    // Cas de la parenthèse fermante
    else if (touche[index].value == ")") {

        affichage.value += " " + touche[index].value; // Affichage dans le champ de calcul

    }

    // Cas des nombres négatifs
    else if (touche[index].value == "(-)") {

        affichage.value += "-"; // Affichage dans le champ de calcul
    
    }

    // Cas des nombres
    else {

        affichage.value += touche[index].value; // Affichage dans le champ de calcul

    }

}

// Boucle qui permet de donner une fonction pour chaque boutons qui n'est pas "C" et "="
for (let i = 1; i < buttons.length - 1; i++) { 

    // Permet de donnée la fonction lors d'un clique
    buttons[i].addEventListener("click", function () {

        affichage_calcul(calcul, buttons, i); // Utilisation de la fonction affichage_calcul

    });

}

// Fonction pour effacer le champ de calcul
let fonction_reset = function () {

    calcul.value = ""; // Enleve le champ par un "vide"

};

let resert = document.getElementById("resert"); // Récupération du bouton
resert.addEventListener("click", fonction_reset); // On lui donne la fonction lors d'un clique

// Initialisation des variables
let compteur = 1;
let recuperer_calcul_historique;

// Fonction pour afficher l'historique sous la calculatrice
let fonction_historique = function (calcul) {

    var historique1 = $("#affiche_calcul_resultat").val(); // Récupération du champ

    var historique = document.createElement("div"); // Création d'un élément pour stocker l'historique
    historique.setAttribute("id", "historique_" + compteur); // Rajout d'un id
    historique.setAttribute("class", "historique"); // Rajout d'une class
    document.getElementById("petit_historique").appendChild(historique); // Ajout dans l'arbre DOM, l'élément tout juste créer

    // Requête Ajax
    $.ajax({

        url: "historique.php",
        type: "POST",
        data: {

            calcul1: calcul,
            historique1: historique1,
            compteur1: compteur,
            test1: 0

        },
        success: function (response) {

            $("#historique_" + compteur).html(response); // Affichage de l'historique
            ++compteur;

            var calcul = document.getElementById("affiche_calcul_resultat"); // Récupération du champ
            recuperer_calcul_historique = document.getElementsByClassName("calcul"); // Récupération tous les champs historique

            // Boucle qui permet de donner une fonction pour chaque champ 
            for (let j = 0; j < recuperer_calcul_historique.length; j++) {

                // Permet de donnée la fonction lors d'un clique
                recuperer_calcul_historique[j].addEventListener("click", function () {

                    calcul.value = recuperer_calcul_historique[j].value; // Affiche l'historique dans le champ de calcul

                });

            }

        },
        error: function (jqXHR, textStatus, errorThrown) {

            console.log(textStatus, errorThrown);

        }

    });

}

//Fonction de calcul puis le résultat
let fonction_calcul = function () {

    var calcul = $("#affiche_calcul_resultat").val(); // Récupération du calcul dans le champ de calcul

    // Requête Ajax
    $.ajax({

        url: "calcul.php",
        type: "POST",

        data: {

            calcul: calcul

        },

        success: function (response) {

            $("#affiche_calcul_resultat").val(response.trim()); // Affichage du résultat
            fonction_historique(calcul); // Utilisation de la fonction fonction_historique

        },

        error: function (jqXHR, textStatus, errorThrown) {

            console.log(textStatus, errorThrown);

        }

    });

}

let egal = document.getElementById("egal"); // Récupération du bouton
egal.addEventListener("click", function (event) { // On lui donne la fonction lors d'un clique

    event.preventDefault(); // Empêcher la soumission du formulaire

    fonction_calcul(); // Utilisation de la fonction fonction_calcul

});


// Fonction pour afficher le calcul selon les touches du clavier (dans le champs)
function affichage_calcul_touche(affichage, touche) {

    // Cas des opérateurs
    if ((touche == "+") || (touche == "-") || (touche == "x") || (touche == "/")) {

        affichage.value += " " + touche + " "; // Affichage dans le champ de calcul

    }

    // Cas de la parenthèse ouvrante
    else if (touche == "(") {

        affichage.value += touche + " "; // Affichage dans le champ de calcul

    }

    // Cas de la parenthèse fermante
    else if (touche == ")") {

        affichage.value += " " + touche; // Affichage dans le champ de calcul

    }

    // Cas des nombres négatifs
    else if (touche == "F2") {

        affichage.value += "-"; // Affichage dans le champ de calcul
    
    }

    // Cas des nombres
    else {

        affichage.value += touche; // Affichage dans le champ de calcul

    }

}

// Fonction pour écrire avec le clavier numérique et pour éviter la répétition de code trop long
function Ecriture_Avec_Clavier(touche) {

    // Permet de voir cas par cas les touches puis fais une action précis
    switch (touche) {

        case "Escape": // Cas de la touche "Echap"

            fonction_reset(); // Utilisation de la fonction fonction_reset
            break; // Sort de la condition

        case "Enter": // Cas de la touche "Entrer"

            fonction_calcul(); // Utilisation de la fonction fonction_calcul
            break; // Sort de la condition

        default: // Cas par défaut

            affichage_calcul_touche(calcul, touche); // Utilisation de la fonction affichage_calcul_touche
            break // Sort de la condition

    }

}

// Dès qu'une touche est appuyer on utilise une fonction
document.addEventListener("keydown", function (event) {

    // Permet de voir cas par cas les touches puis fais une action précis
    switch (event.key) {

        case "0": // Cas de la touche "0"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "1": // Cas de la touche "1"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "2": // Cas de la touche "2"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "3": // Cas de la touche "3"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "4": // Cas de la touche "4"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "5": // Cas de la touche "5"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "6": // Cas de la touche "6"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "7": // Cas de la touche "7"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "8": // Cas de la touche "8"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "9": // Cas de la touche "9"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "(": // Cas de la touche "("

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case ")": // Cas de la touche ")"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "/": // Cas de la touche "/"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "*": // Cas de la touche "*"

            Ecriture_Avec_Clavier("x"); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "-": // Cas de la touche "-"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "+": // Cas de la touche "+"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case ".": // Cas de la touche "."

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "Enter": // Cas de la touche "Entrer"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "Escape": // Cas de la touche "Echap"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        case "F2": // Cas de la touche "F2"

            Ecriture_Avec_Clavier(event.key); // Utilisation de la fonction Ecriture_Avec_Clavier
            break; // Sort de la condition

        default: // Cas par defaut

            console.log("Vous avez taper une touche inconnue par la calculatrice : " + event.key); // Affichage dans la console la touche appuyer
            break; // Sort de la condition

    }

});

// Fonction pour un affichage complet de l'historique
let fonction_affichage_historique = function (test) {

    var historique = document.createElement("div"); // Création d'un élément pour stocker l'historique
    historique.setAttribute("id", "affichage_historique"); // Rajout d'un id
    document.getElementById("affichage_global_historique").appendChild(historique); // Ajout dans l'arbre DOM, l'élément tout juste créer

    // Requête Ajax
    $.ajax({

        url: "historique.php",
        type: "POST",

        data: {

            test1: test

        },

        success: function (response) {

            $("#affichage_historique").html(response); // Affichage de l'historique
            var calcul = document.getElementById("affiche_calcul_resultat"); // Récupération du champ

            recuperer_calcul_historique = document.getElementsByClassName("calcul_historique_bdd"); // Récupération du plusieurs champs

            // Boucle qui permet de donner une fonction pour chaque champ
            for (let k = 0; k < recuperer_calcul_historique.length; k++) { 

                // Permet de donnée la fonction lors d'un clique
                recuperer_calcul_historique[k].addEventListener("click", function () {

                    calcul.value = recuperer_calcul_historique[k].value; // Affiche l'historique dans le champ de calcul

                });

            }

        },

        error: function (jqXHR, textStatus, errorThrown) {

            console.log(textStatus, errorThrown);

        }

    });

}

let test = 0; // Initialisation d'une variable

let affichage_historique_complet = document.getElementById("button_historique"); // Récupération du bouton
affichage_historique_complet.addEventListener("click", function (event) { // On lui donne la fonction lors d'un clique

    event.preventDefault(); // Empêcher la soumission du formulaire
    test = 1; // Changement de la valeur
    fonction_affichage_historique(test); // Utilisation de la fonction fonction_affichage_historique

});

// Fonction pour effacer l'affichage complet de l'historique
let efface_affichage_historique = function () {

    let supp = document.getElementById("affichage_historique"); // Récupération de l'affichage
    supp.parentNode.removeChild(supp); // Suppression de l'affichage

}

// Fonction pour effacer l'affichage de l'historique sous la calculatrice
let efface_affichage_petit_historique = function () {

    let supp = document.getElementById("petit_historique"); // Récupération du champ
    supp.parentNode.removeChild(supp); // Suppression

    let petit_historique = document.createElement("div"); // Création d'un élément pour stocker l'historique
    petit_historique.setAttribute("id", "petit_historique"); // Rajout d'un id
    document.getElementById("calculatrice").appendChild(petit_historique); // Ajout dans l'arbre DOM, l'élément tout juste créer

}

let efface_historique = document.getElementById("button_efface_historique"); // Récupération du bouton
efface_historique.addEventListener("click", function (event) { // On lui donne la fonction lors d'un clique

    event.preventDefault(); // Empêcher la soumission du formulaire
    efface_affichage_historique(); // Utilisation de la fonction efface_affichage_historique

});

let efface_petit_historique = document.getElementById("button_efface_petit_historique"); // Récupération du bouton
efface_petit_historique.addEventListener("click", function (event) { // On lui donne la fonction lors d'un clique

    event.preventDefault(); // Empêcher la soumission du formulaire
    efface_affichage_petit_historique(); // Utilisation de la fonction efface_affichage_petit_historique

});