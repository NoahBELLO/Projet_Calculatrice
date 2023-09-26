<?php

    /**********************************************
    *    Auteur : BELLO Noah
    *    Date du projet : 16/03/2023 - 25/03/2023
    *    Nom du fichier : historique.php
    **********************************************/

    /********************************************************************************************************************
    *   Statégie pour l'historique
    *   1) Dans un premier temps, afficher un historique sous la calculatrice
    *   2) Ensuite créer la connection avec la base de donnée
    *   3) Voir si il y a des erreurs si il y en a, trouver la source et régler le problème (les clés primaires)
    *   4) Si l'historique sous la calculatrice fonctionne, on complexifie (affichage de l'historique complet en prenant 
            exemple sur l'historique d'avant)
    ********************************************************************************************************************/
    
    //Fonction pour éviter la répétition de code
    function Test_Connection(mysqli $connection){

        if (!$connection) { // Vérification de la connection à la base de donnée

            die("La connexion a échoué : " . mysqli_connect_error()); // Affichage de l'erreur si il y en a une

        }

    }

    $test = $_POST["test1"]; // Récupération de la donnée pour tester cette valeur

    // Vérification de la valeur test pour savoir si on affiche l'historique complet ou l'historique sous la calculatrice
    if($test == 1){ // Historique complet

        // Création du tableau contenant l'historique complet
        echo "<table id='tableau_historique'><thead><tr><th colspan='3'>Historique issue de la Base de Donnée</th></tr></thead><tbody><tr><td>Date/Heure</td><td>Calcul</td><td>Résultat</td></tr>";
        
        $conn = mysqli_connect("localhost", "historique1usr", "historique1usr", "historique"); // Connection avec la base de donnée

        Test_Connection($conn); // Utilisation de la fonction Test_Connection pour test si la connection à fonctionner

        $sql = "SELECT * FROM historique"; // Stockage de la requête SQL
        $result = mysqli_query($conn, $sql); // Utilisation de la requête SQL précedent dans la base de donnée

        // Test pour savoir si le tableau de la base de donnée est vide ou pas (car affichage différent)
        if (mysqli_num_rows($result) > 0) {

            // Boucle pour afficher les données ligne par ligne
            while ($ligne = mysqli_fetch_assoc($result)) {
                // Affichage des données dans un ligne d'un tableau HTML
                echo "<tr><td>" . $ligne["date_heure_calcul"] . "</td><td><input type='button' class='calcul_historique_bdd' value='".$ligne["calcul"]."'>"  . "</td><td>" . $ligne["resultat"] . "</td></tr>";
            }

            echo "</tbody></table>"; // Fin du tableau
            
        }

        else {

            echo "<tr><td>null</td><td>null</td><td>null</td></tr></tbody></table>"; // Affichage d'un tableau si le tableau de la base de donnée est vide

        }

        // Fermer la connexion à la base de données
        mysqli_close($conn);

    }

    else{ // Historique sous la calculatrice

        //Récupération du calcul, du résultat et du compteur
        $calcul = $_POST["calcul1"];
        $historique1 = $_POST['historique1']; 
        $compteur = $_POST['compteur1']; 

        $date_heure = date("Y-m-d H:i:s") ; // Création d'un variable contenant la date et l'heure
        $tableau = array(); // Création d'un tableau qui contiendra les clés primaires pour ensuite comparer

        // Affichage de l'historique sous la calculatrice
        echo "<p id=" . "date" . ">" . $date_heure . "</p>";
        echo "<p id=" . "historique" . ">" . "<input type='button' class='calcul' value='" . $calcul . "'>" ."= " . $historique1 . "</p>";

        $conn = mysqli_connect("localhost", "historique1usr", "historique1usr", "historique"); // Connection avec la base de donnée
        $compteur = intval($compteur); // Conversion de la variable compteur en entier (int)

        Test_Connection($conn); // Utilisation de la fonction Test_Connection pour test si la connection à fonctionner

        $sql = "SELECT id_historique FROM historique"; // Stockage de la requête SQL
        $result = mysqli_query($conn, $sql); // Utilisation de la requête SQL précedent dans la base de donnée

        // Test pour savoir si le tableau de la base de donnée est vide
        if (mysqli_num_rows($result) > 0) {

            // Boucle parcourir les résultats et stocker chaque valeur dans le tableau
            while ($ligne = mysqli_fetch_array($result)) {

                $tableau[] = $ligne['id_historique']; // Récupération de chaque clé primaire pour les stocker dans un tableau

            }

        } 

        // Boucle pour créer une clé primaire qui n'existera pas dans la colonne id_historique sinon il y a un risque d'erreur 
        while(in_array($compteur, $tableau)){

            ++$compteur; // Ajout de 1 au compteur

        }

        // Stockage de la requête SQL
        $sql = "INSERT INTO historique (id_historique, date_heure_calcul, calcul, resultat) VALUES ('$compteur', '$date_heure', '$calcul', '$historique1')";
        
        mysqli_query($conn, $sql); // Utilisation de la requête SQL précedent dans la base de donnée

        // Fermer la connexion à la base de données
        mysqli_close($conn);

    }  

?>