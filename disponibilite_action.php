<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>votre disponibilité enregistrée</title>
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
                    <a class="brand">NOUNOU <?php echo$_COOKIE['login_nounou']; ?></a>
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

        <div class="container-fluid">
            <div class="hero-unit"><center>
                    <?php
                    include 'database.php';

                    $login = $_COOKIE['login_nounou']; //需要nounou 的login cookie       
                    $jour = $_POST["jour"];
                    $hdebut = $_POST["hdebut"];
                    $hfin = $_POST["hfin"];
                    $ddebut = $_POST["ddebut"];
                    $dfin = $_POST["dfin"];

                    try {
                        $base = new PDO($datasourceName, $user, $password);
                        $requete = "INSERT INTO disponibilite VALUES (:login,:jour,:hdebut,:hfin,:ddebut,:dfin)";
                        $statement = $base->prepare($requete);
                        $statement->execute(array(':login' => $login, ':jour' => $jour, ':hdebut' => $hdebut, ':hfin' => $hfin, ':ddebut' => $ddebut, ':dfin' => $dfin));
                        echo'<h5>Déclaration réussite ! <br/><br/>Vous pouvez déclarer une autre période du temps. </h5><p/><br>';
                        echo" <a class='btn btn-primary' href='planning.php'>Planning</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a class='btn btn-info' href='disponibilite.php'>Déclarer une autre diponibilité</a></p>";
                    } catch (PDOExceptionException $ex) {
                        die("Erreur! " . $ex->getMessage());
                    }
                    $base = NULL;
                    ?>
                </center></div></div>
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
