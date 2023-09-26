<?php

    /**********************************************
    *    Auteur : BELLO Noah
    *    Date du projet : 16/03/2023 - 25/03/2023
    *    Nom du fichier : calcul.php
    **********************************************/

    /*****************************************************************************************************************
    *   Statégie pour le calcul
    *   1) Dans un premier temps, faire les fonctions de calcul (car c'est rapide à faire)
    *   2) Ensuite faire un switch pour faire fonctionner un cas de calcul simple de type 2+2
    *   3) Puis voir les erreurs possibles et les améliorations qu'on peut apporté 
            - Erreur : Cas de plusieurs opérandes, division par zéro, affichage d'un chiffre sans calcul
            - Améliorations : Faire des fonctions pour une meilleur compréhension et pour éviter les répétitions
    *   4) Rajouter le cas des parenthèses
    *****************************************************************************************************************/

    $calcul = $_POST['calcul']; // Récupération du calcul dans une variable
    $tableau_calcul = explode(" ", $calcul) ; // Transformation du calcul en tableau pour ensuite exploiter les données

    //Déclarations des différentes fonctions

    // Fonction qui permet de remplacer le tableau
    function Remplace_premier_element(array $tab, $valeur){

        $tab_remplacer = array_slice($tab, 3); // Création d'un tableau à partir de la troisième position
        array_unshift($tab_remplacer, $valeur) ; // Permet de rajouter un nouvelle élément dans le tableau
        return $tab_remplacer ; // Renvoie un nouveau tableau pour le remplacer

    }
    
    // Fonction pour test si on peut calculer et ça permet d'éviter la répétition de code
    function Test_pour_calculer(array $tab, int $index, &$reponse){ 

        // Utilisation d'une fonction pour savoir si les valeurs ne sont pas numériques
        if((!is_numeric($tab[$index+2])) || (!is_numeric($tab[$index]))) { 

            $reponse = "Erreur opérande"; // Message d'erreur

        }

    }

    // Fonction pour remplacer le tableau et récupere le résultat 
    function Remplacement_Tableau_Et_Recuperation_Resultat(array &$tableau_calcul, $TMP, &$resultat){

        $tableau_calcul = Remplace_premier_element($tableau_calcul, $TMP); // Utilisation de la fonction Remplace_premier_element pour remplacer le premier élément
        $resultat = $TMP; // Récupération du résultat dans la variable temporaire

    }

    // Fonction pour afficher le résultat ou les erreurs
    function Affichage_Final($reponse, $resul){

        // Test pour savoir si reponse est égal à une chaîne de caractère précis ou pas
        if($reponse == "Erreur opérande"){ // Erreur des opérandes

            echo "Erreur"; // Message d'erreur dans le cas de deux opérandes consécutifs

        }

        else { // Sinon on recommence un autre test

            // Test pour savoir si reponse est égal à une chaîne de caractère précis ou pas
            if($resul == "Erreur division par 0") { // Erreur de la division par zéro

                echo "Erreur division par 0"; // Message d'erreur dans le cas pour une division par 0

            }
            
            else { // Cas où les précédents test non pas fonctionner

                echo $resul; // Affichage du résultat

            }

        }

    }

    // Fonction qui permet de calculer un addition et qui renvoie le résultat de l'opération
    function Addition($x, $y){

        return floatval($x + $y) ; // Calcul puis convertion en nombre flottant pour enfin la renvoyer

    }

    // Fonction qui permet de calculer un soustraction et qui renvoie le résultat de l'opération
    function Soustraction($x, $y){

        return floatval($x - $y) ; // Calcul puis convertion en nombre flottant pour enfin la renvoyer

    }

    // Fonction qui permet de calculer un multiplication et qui renvoie le résultat de l'opération
    function Multiplication($x, $y){

        return floatval($x * $y) ; // Calcul puis convertion en nombre flottant pour enfin la renvoyer

    }

    // Fonction qui permet de calculer un division et qui renvoie le résultat de l'opération
    function Division($x, $y){

        // Test pour savoir si le deuxième nombre est égal à zéro car il est impossible de diviser par zéro sinon on fais le calcul
        if($y == 0){

            return "Erreur division par 0"; // Message d'erreur

        }

        else {

            return floatval($x / $y) ; // Calcul puis convertion en nombre flottant pour enfin la renvoyer

        }

    }

    // Fonction qui permet de choisir le calcul selon les cas et évite la répétition
    function Choix_Calcul(array &$tab, $index, &$test, &$TMP, &$resultat){

        // On regarde quel est l'opération pour ensuite faire le calcul
        switch($tab[$index+1]){

            case "+": // Cas de l'addition

                Test_pour_calculer($tab, $index, $test); // Utilisation de la fonction Test_pour_calculer pour savoir si on fait le calcul ou pas
                $TMP = Addition(floatval($tab[$index]), floatval($tab[$index+2])); // Utilisation de la fonction Addition pour calculer
                Remplacement_Tableau_Et_Recuperation_Resultat($tab, $TMP, $resultat); // Utilisation de la fonction Remplacement_Tableau_Et_Recuperation_Resultat pour remplacer le tableau et récupérer le résultat
                break; // Permet de sortir de ce cas 

            case "-": // Cas de la soustraction

                Test_pour_calculer($tab, $index, $test); // Utilisation de la fonction Test_pour_calculer pour savoir si on fait le calcul ou pas
                $TMP = Soustraction(floatval($tab[$index]), floatval($tab[$index+2])) ; // Utilisation de la fonction Soustraction pour calculer
                Remplacement_Tableau_Et_Recuperation_Resultat($tab, $TMP, $resultat); // Utilisation de la fonction Remplacement_Tableau_Et_Recuperation_Resultat pour remplacer le tableau et récupérer le résultat
                break; // Permet de sortir de ce cas 

            case "x": // Cas de la multiplication

                Test_pour_calculer($tab, $index, $test); // Utilisation de la fonction Test_pour_calculer pour savoir si on fait le calcul ou pas
                $TMP = Multiplication(floatval($tab[$index]), floatval($tab[$index+2])) ; // Utilisation de la fonction Multiplication pour calculer
                Remplacement_Tableau_Et_Recuperation_Resultat($tab, $TMP, $resultat); // Utilisation de la fonction Remplacement_Tableau_Et_Recuperation_Resultat pour remplacer le tableau et récupérer le résultat
                break; // Permet de sortir de ce cas 

            case "/": // Cas de la division

                Test_pour_calculer($tab, $index, $test); // Utilisation de la fonction Test_pour_calculer pour savoir si on fait le calcul ou pas
                $TMP = Division(floatval($tab[$index]), floatval($tab[$index+2])) ; // Utilisation de la fonction Division pour calculer
                Remplacement_Tableau_Et_Recuperation_Resultat($tab, $TMP, $resultat); // Utilisation de la fonction Remplacement_Tableau_Et_Recuperation_Resultat pour remplacer le tableau et récupérer le résultat
                break; // Permet de sortir de ce cas 

        }

    }

    // Vérification si la longueur du tableau est égal à 1 pour un affichage précis (car pas besoin de calculer un valeur seule)
    if(count($tableau_calcul) == 1){ // Affichage sans calcul

        // Test pour savoir si la seule valeur est une valeur numérique ou non
        if(is_numeric($tableau_calcul[0])) {

            echo $tableau_calcul[0]; // Affichage de la valeur

        }

        else {

            echo "Erreur"; // Affichage d'un message d'erreur car ce n'est pas un nombre

        }

    }

    else{ // Affichage après calcul

        //Boucle qui permet de continuer le calcul temps que l'un des opérande ou d'une parenthèse ouvrante apparaît dans le tableau de calcul
        while((in_array("(", $tableau_calcul)) || (in_array("+", $tableau_calcul)) || (in_array("-", $tableau_calcul)) || (in_array("x", $tableau_calcul)) || (in_array("/", $tableau_calcul))){
            
            // Création des variables qui contiendront des valeurs précises (une valeur temporaire, une valeur test et le résultat final)
            $TMP; $resultat; $test = ""; 

            // Boucle pour lire le tableau de calcul pour ensuite l'exploiter
            for($i = 0; $i<count($tableau_calcul) - 2; ++$i){

                // Test pour savoir si un parenthèse ouvrante est dans le tableau ce qui permet de faire le calcul entre parenthèse en premier
                if(in_array("(", $tableau_calcul)){ // Cas avec parenthèses simple (non imbriquée)

                    // Création de variable pour contenir des éléments précis
                    $indice1 = array_search("(", $tableau_calcul); // Récupére l'indice de la parenthèse ouvrante
                    $indice2 = array_search(")", $tableau_calcul); // Récupére l'indice de la parenthèse fermante
                    $priorite_parenthese = array_slice($tableau_calcul, $indice1+1, $indice2-($indice1+1)); // Tableau qui prend ce qui à entre les parenthèses

                    // Boucle pour faire le calcul entre les parenthèses
                    for($j = 0; $j<count($priorite_parenthese)-1; ++$j){
                        
                        Choix_Calcul($priorite_parenthese, $j, $test, $TMP, $resultat); // Utilisation de la fonction Choix_Calcul qui permet de choisir le calcul selon le cas 
                        $TMP = 0; // Remise à zéro pour éviter des problèmes de calcul

                    }

                    array_splice($tableau_calcul, $indice1, $indice2-$indice1+1, array($resultat)); // On remplace toute la partie entre les parenthèses (les parenthèses compris) par le résultat

                }
                
                else{ // Cas sans parenthèses

                    //Boucle qui permet de continuer le calcul temps que l'un des opérande apparaît dans le tableau de calcul
                    while((in_array("+", $tableau_calcul)) || (in_array("-", $tableau_calcul)) || (in_array("x", $tableau_calcul)) || (in_array("/", $tableau_calcul))){
                        
                        Choix_Calcul($tableau_calcul, $i, $test, $TMP, $resultat); // Utilisation de la fonction Choix_Calcul qui permet de choisir le calcul selon le cas 
                        $TMP = 0; // Remise à zéro pour éviter des problèmes de calcul

                    } 

                } 

            }

        }

        Affichage_Final($test, $resultat); // Utilisation de la fonction Affichage_Final pour afficher le résultat du calcul ou des erreurs 

    }

?> 