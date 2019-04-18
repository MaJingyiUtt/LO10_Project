<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'Objet_nounou.php';

$get_list_nounou = $_COOKIE['list_nounou']; //取出list
$original_list_nounou = unserialize($get_list_nounou); ////unserialize list
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>recrutement des nounous</title>
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
                    <a class="brand">ADMINISTRATEUR</a>
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

    <center><h1>Recrutement des nounous</h1></center>
    <form method='post' action="recrutement_nounous_action.php">


<?php
if (empty($original_list_nounou)) {
    echo("<div class='container-fluid'>
                                    <div class='hero-unit'>");
    echo "<center><h4>Il n'y a pas de nouvelle candidature</h4></center>";
    echo("</div></div>");
} else {
    $i = 0;
    foreach ($original_list_nounou as $element) {
        echo("<div class='container-fluid'>
                                    <div class='hero-unit'>");

        echo("<fieldset>");
        echo("<legend></legend>");
        echo "<img src= photos/" . $element->photo . " width='100' alt='photo'/>"; /////////照片
        echo("<p><b>Nom: </b>" . $element->nom . "</p>");
        echo("<p><b>Prénom: </b>" . $element->prenom . "</p>");
        echo("<p><b>Age: </b>" . $element->age . "</p>");
        echo("<p><b>Ville: </b>" . $element->ville . "</p>");
        echo("<p><b>Email: </b>" . $element->email . "</p>");
        echo("<p><b>Portable: </b>" . $element->portable . "</p>");
        echo("<p><b>Langues: </b>" . $element->langues . "</p>");
        echo("<p><b>Expérience: </b>" . $element->experience . "</p>");
        echo("<p><b>Présentation: </b>" . $element->presentation . "</p>");
        echo("<p><b>Accepte: </b>" . $element->estAccepte . "</p>");
        echo("<p><b>Bloque: </b>" . $element->estBloque . "</p>");



        if ($element->estAccepte == "oui") {

            echo("<p><input type='checkbox' name='accepter$i' checked='checked' value='checked'>");
            echo('&nbsp;&nbsp;&nbsp;');
            echo("<font color='red'><b>ACCEPTER</b></font></p>");
        } else {
            echo("<p><input type='checkbox' name='accepter$i' value='checked'>");
            echo('&nbsp;&nbsp;&nbsp;');
            echo("<font color='red'><b>ACCEPTER</b></font></p>");
        }


        echo("</fieldset>");
        $i++;
        echo("</div></div>");
    }



    setcookie('i', $i);

    echo( "<p><center><input type='submit' class='btn btn-success' value='ENREGISTRER'></input></center></p>
                    <br/><br/>
            </form>");
}
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
