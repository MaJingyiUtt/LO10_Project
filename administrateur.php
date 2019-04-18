<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>administrateur</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href="bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="body.css">
        <link href="bootstrap-responsive.min.css" rel="stylesheet">
    </head>

    <body>       
        <?php
        include 'database.php';

        $mdp = $_POST['mdp'];
        $login = $_POST['login'];

        if (!empty($login) && !empty($mdp)) {

            // printf("<h1>Administrateur %s</h1>", $login);

            try {

                $requete = "select mdp from login_administrateur where login=:login";
                $statement = $base->prepare($requete);
                $statement->execute(['login' => $login]);
                $resultat = $statement->fetch();


                if ($mdp == $resultat['mdp']) {
                    ?>
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

                                </div>

                            </div>
                        </div>
                    </div>


                    <?php printf("<center><h1>ADMINISTRATEUR %s</h1></center>", $login); ?>
                    <br/>


                    <div class="row-fluid">

                        <div class="span6">

                            <div class="container-fluid">
                                <div class="hero-unit">
                                    <center><h3>Informations Stratégiques</h3>
                                        <p>
                                            Nombre de candidatures de nounous, nombre de nounous inscrites...<p/>
                                        Chiffre d’affaire du site sur une période<p/>
                                        Dossier complet d’une nounou<p/>

                                        </p>
                                        <a class="btn btn-info" href="informations_strategiques.php">C'est parti &raquo;</a></center>
                                </div>
                            </div> 

                        </div> 

                        <div class="span6">
                            <div class="container-fluid">
                                <div class="hero-unit">
                                    <center><h3>Recrutement des nounous</h3>
                                        <p>
                                        Gestion la liste des candidatures des nounous<p/>
                                        <a class="btn btn-primary" href="recrutement_nounous.php">C'est parti &raquo;</a><p/>
                                        
                                        Bloquer l’activité d’une nounou<p/>
                                        <a class="btn btn-primary" href="bloquer_nounous.php">C'est parti &raquo;</a><p/>
                                        Débloquer l’activité d’une nounou<p/>
                                        <a class="btn btn-primary" href="debloquer_nounous.php">C'est parti &raquo;</a><p/>

                                        </p>
                                        </center>
                                </div>
                            </div> 
                        </div>

                    </div>


                    <?php
                } else {
                    echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
                    echo("<center>Le mot de passe n'est pas correcte</p>");
                    echo("<a class='btn btn-large btn-info' href='login_administrateur.html'>RETOUR</a></center>");
                    echo("</div></div>");
                }
            } catch (PDOExceptionException $ex) {
                die("Erreur! " . $ex->getMessage());
            }
        } elseif (empty($login) && empty($mdp)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
            echo("<center><p>Veuillez saisir votre login et votre mot de passe</p>");
            echo("<a class='btn btn-large btn-info' href='login_administrateur.html'>RETOUR</a></center>");
            echo("</div></div>");
        } elseif (empty($login) && !empty($mdp)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
            echo("<center><p>Veuillez saisir votre login</p>");
            echo("<a class='btn btn-large btn-info' href='login_administrateur.html'>Retour</a></center>");
            echo("</div></div>");
        } elseif (empty($mdp) && !empty($login)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
            echo("<center><p>Veuillez saisir votre mot de passe</p>");
            echo("<a class='btn btn-large btn-info' href='login_administrateur.html'>Retour</a></center>");
            echo("</div></div>");
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
