<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>nounou</title>
        <link href="bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="body.css">
        <link href="bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        include 'database.php';

        $mdp = $_POST['mdp'];
        $login = $_POST['login'];
        setcookie('login_nounou', $login);
        if (!empty($login) && !empty($mdp)) {



            try {

                $requete = "select mdp from nounou where login=:login";
                $statement = $base->prepare($requete);
                $statement->execute(['login' => $login]);
                $resultat = $statement->fetch();
                $requete2 = "select bloquer from nounou where login=:login";
                $statement2 = $base->prepare($requete2);
                $statement2->execute(['login' => $login]);
                $resultat2 = $statement2->fetch();
                if ($mdp == $resultat['mdp']) {
                    //echo("Bonjour! <p/>");
                    if ($resultat2['bloquer'] == "non") {
                        ?>
                        <div class="navbar navbar-inverse navbar-fixed-top">
                            <div class="navbar-inner">
                                <div class="container-fluid">
                                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>

                                    </button>
                                    <a class="brand">NNOUNOU  <?php echo $login; ?></a>
                                    <div class="nav-collapse collapse">
                                        <ul class="nav">
                                            <li>
                                                <a href="home.html">HOME</a><p/>
                                            </li>
                                            <li>
                                                <a href='disponibilite.php'>DECLARER VOS DISPONIBILITES</a><p/>
                                            </li>
                                            <li class="active">
                                                <a href='planning.php'>PLANNING</a><p/>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--/.nav-collapse -->
                                </div>
                            </div>
                        </div>
                        <?php printf("<center><h1>NOUNOU " . $login) . " </h1></center>"; ?>
                        <br/>
                        <br/>

                        <div class="row-fluid">

                            <div class="span6">

                                <div class="container-fluid">
                                    <div class="hero-unit">
                                        <center><h3>Planning</h3></center>
                                        <p>
                                            Accéder à son planning afin de voir
                                            l’ensemble de vos disponibilités

                                        </p>
                                        <center><a class="btn btn-primary" href="planning.php">C'est parti &raquo;</a></center>
                                    </div>
                                </div> 



                            </div> 

                            <div class="span6">
                                <div class="container-fluid">
                                    <div class="hero-unit">
                                        <center><h3>Déclarer vos disponibilités</h3></center>
                                        <p>
                                            Vous pouvez déclarer qu'une fois pour chaque jour. 
                                        </p>
                                        <center><a class="btn btn-info" href="disponibilite.php">C'est parti &raquo;</a></center>
                                    </div>
                                </div> 


                            </div>

                        </div>


                        <?php
                    } else {
                        echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
                        echo "Votre compte est bloqué par l'administrateur.</p>";
                        echo("<p><a class='btn btn-info' href='planning.php'>PLANNING</a></p>");
                        echo("</center></div></div>");
                    }
                } else {
                    echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
                    echo("Le mot de passe n'est pas correcte</p>");
                    echo("<a class='btn btn-info' href='login_nounou.html'>RETOUR</a>");
                    echo("</center></div></div>");
                }
            } catch (PDOExceptionException $ex) {
                die("Erreur! " . $ex->getMessage());
            }
        } elseif (empty($login) && empty($mdp)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
            echo("<p>Veuillez saisir votre login et votre mot de passe</p>");
            echo("<a class='btn btn-info' href='login_nounou.html'>RETOUR</a>");
            echo("<center></div></div>");
        } elseif (empty($login) && !empty($mdp)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
            echo("<p>Veuillez saisir votre login</p>");
            echo("<a class='btn btn-info' href='login_nounou.html'>RETOUR</a>");
            echo("</center></div></div>");
        } elseif (empty($mdp) && !empty($login)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
            echo("<p>Veuillez saisir votre mot de passe</p>");
            echo("<a class='btn btn-info' href='login_nounou.html'>RETOUR</a>");
            echo("</center></div></div>");
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
