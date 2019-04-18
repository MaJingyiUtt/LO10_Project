<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>parent</title>
        <link href="bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="body.css">
        <link href="bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <form action="parent.php" method="post">
            <?php
            include 'database.php';

            $mdp = $_POST['mdp'];
            $login = $_POST['login'];
            setcookie('login_parent', $login);
            if (!empty($login) && !empty($mdp)) {

                

                try {

                    $requete = "select mdp from parent where login=:login";
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
                                    <a class="brand">PARENT <?php echo $login; ?></a>
                                    <div class="nav-collapse collapse">
                                        <ul class="nav">
                                            <li>
                                                <a href="home.html">HOME</a><p/>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--/.nav-collapse -->
                                </div>
                            </div>
                        </div>
            
            
            <?php printf("<center><h1>PARENT %s</h1></center>", $login); ?>
            <br/>
                        <div class="row-fluid">

                            <div class="span6">
                                
                                <div class="container-fluid">
                                    <div class="hero-unit">
                                        <center><h3>Garde ponctuelle?</h3></center>
                                        <p>
                                            Vous déclarez une demande de garde ponctuelle 
                                            via un formulaire Web définissant la date, 
                                            la plage horaire de la garde 
                                            et les enfants concernés.
                                            
                                        </p>
                                        <center><a class="btn btn-info" href="garde_ponctuelle.php">C'est parti &raquo;</a></center>
                                    </div>
                                </div> 
                                
                                
                                <div class="container-fluid">
                                    <div class="hero-unit">
                                        <center><h3>Garde d'enfant régulière ?</h3></center>
                                        <p>
                                            Vous chercher des nounous pour 
                                            les sorties d’école les lundis?
                                            entre 16h00 et 18h00?    
                                        </p>
                                        <center><a class="btn btn-info" href="garde_reguliere.php">C'est parti &raquo;</a></center>
                                    </div>
                                </div> 
                                </div> 

                                <div class="span6">
                                <div class="container-fluid">
                                    <div class="hero-unit">
                                        <center><h3>Garde d'enfant en langue étrangères?</h3></center>
                                        <p>
                                            Vous chercher une garde d'enfant qui parle des langue étrangères? 
                                        </p>
                                        <center><a class="btn btn-info" href="garde_langue.php">C'est parti &raquo;</a></center>
                                    </div>
                                </div> 

                                
                             


                            
                                <div class="container-fluid">
                                    <div class="hero-unit">
                                        <center><h3>Evaluer une nounou</h3></center>
                                        <p>
                                            Vous pouver évaluer une nounou à la fin
                                            de la garde.
                                        </p>
                                        <center><a class="btn btn-primary" href="evaluer.php">Evaluer une nounou &raquo;</a></center>
                                    </div>
                                </div> 
                            </div>
                                
                        </div>

                    


                    <?php
                } else {
                    echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
                    echo("Le mot de passe n'est pas correcte</p>");
                    echo("<a class='btn btn-info' href='login_parent.html'>RETOUR</a>");
                    echo("</center></div></div>");
                }
            } catch (PDOExceptionException $ex) {
                die("Erreur! " . $ex->getMessage());
            }
        } elseif (empty($login) && empty($mdp)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
            echo("<p>Veuillez saisir votre login et votre mot de passe</p>");
            echo("<a class='btn btn-info' href='login_administrateur.html'>RETOUR</a>");
            echo("</center></div></div>");
        } elseif (empty($login) && !empty($mdp)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
            echo("<p>Veuillez saisir votre login</p>");
            echo("<a class='btn btn-info' href='login_parent.html'>RETOUR</a>");
            echo("</center></div></div>");
        } elseif (empty($mdp) && !empty($login)) {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'><center>");
            echo("<p>Veuillez saisir votre mot de passe</p>");
            echo("<a class='btn btn-info' href='login_parent.html'>RETOUR</a>");
            echo("</center></div></div>");
        }
        ?>


    </form>
</body>
</html>
