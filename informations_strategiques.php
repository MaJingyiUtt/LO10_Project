<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>information stratégiques</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
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
                            <li class="active">
                                <a href="informations_strategiques.php">INFORMATION STRATEGIQUES</a><p/>
                            </li>
                            <li>
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
    <center><h1>Informations Stratégiques</h1></center><br/>



    <div class="container-fluid">
        <div class="hero-unit">
            <h4>Nombre de candidatures de nounous :
                <?php
                $get_list_nounou = $_COOKIE['list_nounou']; //取出list
                $list_nounou = unserialize($get_list_nounou); ////unserialize list

                if (!empty($list_nounou)) {
                    echo count($list_nounou);
                } else {
                    echo "0";
                }
                ?>
            </h4>
            <h4>Nombre de nounous inscrites : 
                <?php
                include 'database.php';
                $requete = "select count(*) from nounou";
                $statement = $base->prepare($requete);
                $statement->execute();
                $resultat = $statement->fetch();
                echo $resultat[0];
                ?>
            </h4>     

            <h4>Chiffre d’affaire du site</h4>
            <ul>
                <li><b>Mois : <?php
                        $requete = "select sum(revenu) from evaluation where date<'2018-07' and date > '2018-05'";
                        $statement = $base->prepare($requete);
                        $statement->execute();
                        $mois = $statement->fetch();
                        echo $mois[0];
                        ?></b></li>
                <li><b>Trimestre : <?php
                        $requete = "select sum(revenu) from evaluation where date<'2018-07' and date > '2018-03'";
                        $statement = $base->prepare($requete);
                        $statement->execute();
                        $trimestre = $statement->fetch();
                        echo $trimestre[0];
                        ?></b></li>
                <li><b>Année : 
                        <?php
                        $requete = "select sum(revenu) from evaluation where date<'2019' and date > '2017'";
                        $statement = $base->prepare($requete);
                        $statement->execute();
                        $annee = $statement->fetch();
                        echo $annee[0];
                        ?>
                    </b></li>
            </ul>

        </div></div>



    <div class="container-fluid">
        <div class="hero-unit">
            <center><h3>Dossier complet des nounous avec les évaluations et les revenus</h3></center>
            <?php
            $requete3 = "select login_nounou,sum(revenu),avg(evaluation) from evaluation where evaluation!='' group by login_nounou order by revenu,evaluation desc";
            $statement3 = $base->prepare($requete3);
            $statement3->execute();
            $resultat3 = $statement3->fetchAll();
            echo'<table border="1">
                <thead>
                    <tr>
                        <th>&nbsp;&nbsp;&nbsp;   NOUNOU    &nbsp;&nbsp;&nbsp;</th>
                        <th>&nbsp;&nbsp;&nbsp;   REVENUE   &nbsp;&nbsp;&nbsp;</th>
                        <th>&nbsp;&nbsp;&nbsp;   EVALUATION   &nbsp;&nbsp;&nbsp;</th>
                    </tr>
                    </thead>
                <tbody>';
            for ($i = 0; $i < count($resultat3); $i++) {
                printf("<tr>
                        <td>&nbsp;&nbsp;&nbsp;    %s     &nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;    %s     &nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;    %s     &nbsp;&nbsp;&nbsp;</td>
                    </tr>", $resultat3[$i][0], $resultat3[$i][1], $resultat3[$i][2]);
            }
            echo'</tbody>';
            ?>

            <?php
            $requete4 = "select * from nounou";
            $statement4 = $base->prepare($requete4);
            $statement4->execute();
            $resultat4 = $statement4->fetchAll();
            foreach ($resultat4 as $element) {

                echo("<fieldset><legend></legend>");

                echo "<img src= photos/" . $element['photo'] . " width='100' alt='photo'/>  "; /////////照片
                echo( "<b>" . $element['nom'] . "  ");
                echo("<b>" . $element['prenom'] . "  ");
                echo("<b>" . $element['ville'] . "  ");
                echo("<b>" . $element['email'] . "  ");
                echo("<b>" . $element['portable'] . "  ");
                echo("<b>" . $element['experience'] . " ");
                echo("<b>" . $element['presentation'] . " </b>");
                echo("</fieldset>");
                echo("<br/>");
            }
            ?>

        </div></div>               


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
    </script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
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
