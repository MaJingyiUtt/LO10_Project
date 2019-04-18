<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'Objet_nounou.php';
include 'database.php';



$get_list_nounou = $_COOKIE['list_nounou']; //取出list
$original_list_nounou = unserialize($get_list_nounou); ////unserialize list


$i = $_COOKIE['i'];

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>recrutement nounou</title>
        <link href="bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="body.css">
        <link href="bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>
                    <a class="brand">Administrateur</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li>
                                <a href="home.html">HOME</a><p/>
                            </li>
                            <li>
                                <a href="informations_strategiques.php">INFORMATIONS STRATEGIQUES</a><p/>
                            </li>
                            <li class="active">
                                <a href="recrutement_nounous.php">RECRUTEMENT</a><p/>
                            </li>
                            <li>
                                <a href="bloquer_nounous.php">BLOQUER</a><p/>
                            </li>
                            <li>
                                <a href="debloquer_nounous.php">DEBLOQUER</a><p/>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <center><h1>Recrutement des nounous</h1><br/>
<div class="container-fluid">
                <div class="hero-unit">
        <h4>Les nounous sont enregistrés dans la base de donnée. </h4></center>
    
</div></div>
<?php
for ($indice = 0; $indice < $i; $indice++) {
    $post = "accepter" . $indice;
    if ($_POST[$post] == "checked") {
        //echo '进入if';
        include 'database.php';

        try {

            $login = $original_list_nounou[$indice]->login;
            $mdp = $original_list_nounou[$indice]->mdp;
            $nom = $original_list_nounou[$indice]->nom;
            $prenom = $original_list_nounou[$indice]->prenom;
            $ville = $original_list_nounou[$indice]->ville;
            $email = $original_list_nounou[$indice]->email;
            $portable = $original_list_nounou[$indice]->portable;
            $experience = $original_list_nounou[$indice]->experience;
            $presentation = $original_list_nounou[$indice]->presentation;
            $langues = $original_list_nounou[$indice]->langues;
            $bloquer = "non";
            $photo = $original_list_nounou[$indice]->photo;
            //echo "进入try";
            //echo $nom;

            //$base = new PDO($datasourceName, $user, $password);
            $requete = "INSERT INTO nounou VALUES (:login,:mdp,:nom,:prenom,:ville,:email,:portable,:experience,:presentation,:langues,:bloquer,:photo)";
            $statement = $base->prepare($requete);
            $statement->execute(array(':login' => $login, ':mdp' => $mdp, ':nom' => $nom, ':prenom' => $prenom, ':ville' => $ville, ':email' => $email, ':portable' => $portable, ':experience' => $experience, ':presentation' => $presentation, ':langues' => $langues, ':bloquer' => $bloquer, ':photo' => $photo));
        } catch (PDOExceptionException $ex) {
            die("Erreur! " . $ex->getMessage());
        }
        $base = NULL;
        unset($original_list_nounou[$indice]);
    }
}
$ser_list_nounou = serialize($original_list_nounou); //serialize list
setcookie('list_nounou', $ser_list_nounou);
?>
    </body>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
    </script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script>
        !function ($) {
            $(function () {
                // carousel demo
                $('#myCarousel1').carousel()
            })
        }(window.jQuery)
    </script>
</html>
