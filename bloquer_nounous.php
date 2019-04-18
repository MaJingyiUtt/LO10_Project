<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>bloquer un nounou</title>

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
                            <li>
                                <a href="recrutement_nounous.php">RECRUTEMENT</a><p/>
                            </li>
                            <li class="active">
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

        
        
        <form method="post" action="bloquer_nounous.php">
            <div class="container-fluid">
                                    <div class="hero-unit">
           <center><h3>Bloquer un nounou</h3><br/>
            <input type="text" name="login" placeholder="Login de nounou"/><p/><br/>
            <input type="reset" value="RESET" class="btn btn-danger"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" value="BLOQUER" class="btn btn-warning"/>
            </center>
            </div></div>
        </form>
        <?php
        if (isset($_POST["login"])) {
            /* $user = 'root';
              $password = 'root';
              $datasourceName = 'mysql:host=localhost;dbname=lo07projet';
             * 
             */
            include 'database.php';
            try {
                $login = $_POST["login"];
                //$bloquer="oui";
                $base = new PDO($datasourceName, $user, $password);
                $requete = "UPDATE nounou SET bloquer='oui'WHERE login=:login";
                $statement = $base->prepare($requete);
                $statement->execute(array(':login' => $login));
                echo("nounou " . $login . " est bloqué ");
            } catch (PDOExceptionException $ex) {
                die("Erreur! " . $ex->getMessage());
            }
            $base = NULL;
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
