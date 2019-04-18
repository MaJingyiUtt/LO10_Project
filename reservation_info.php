<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Réservation</title>
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
                    <a class="brand">NOUNOU <?php echo $_COOKIE['login_nounou']; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li>
                                <a href="home.html">HOME</a><p/>
                            </li>
                            <li class="active">
                                <a href='disponibilite.html'>DECLARER VOS DISPONIBILITES</a><p/>
                            </li>
                            <li>
                                <a href='planning.php'>PLANNING</a><p/>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
    <center><h1>Les informations sur les réservations</h1></center><br/>
        
        <?php
        include 'database.php';

        

        $login_nounou = $_COOKIE['login_nounou'];
        $day = $_GET['day'];
        $month = $_GET['month'];
        $year = 2018;

        $type = "reguliere";

        $date_str = date('Y-m-d', strtotime($year . "-" . $month . "-" . $day)); //2018-07-04
        
        $arr = explode("-", $date_str);
        $year = $arr[0];
        $month = sprintf('%02d', $arr[1]);
        $day = sprintf('%02d', $arr[2]);
        $hour = $minute = $second = 0;
        $strap = mktime($hour, $minute, $second, $month, $day, $year);
        $number_wk = date("w", $strap);
        $weekArr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
        $week = $weekArr[$number_wk];

        //鍒ゆ柇鏄痳eguliere閫夎繃鏉ョ殑
        $requete = "select * from reservation_reguliere where login_nounou=:login_nounou and jour=:jour and ddebut<=:date and dfin>=:date";
        $statement = $base->prepare($requete);
        $statement->execute(array(':login_nounou' => $login_nounou, ':jour' => $week, ':date' => $date_str));
        $resultat = $statement->fetchAll();


        if (!empty($resultat)) {
            $login_parent = $resultat[0]['login_parent'];

            $requete2 = "select * from parent where login=:login_parent";
            $statement2 = $base->prepare($requete2);
            $statement2->execute([':login_parent' => $login_parent]);
            $resultat2 = $statement2->fetchAll();
            
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");



            echo("<center><p><h3>Type de prestation: " . $type . "</h3></p>");
            echo("<b>Heure de début: " . $resultat[0]['hdebut'] . "h</b><p/>");
            echo("<b>Heure de fin: " . $resultat[0]['hfin'] . "h</b><p/>");
            echo("<b>Nom de parent: " . $resultat2[0]['nom'] . "</b><p/>");
            echo("<b>Ville: " . $resultat2[0]['ville'] . "</b><p/>");
            echo("<b>Email: " . $resultat2[0]['email'] . "</b><p/>");
            echo("<b>Information générale: " . $resultat2[0]['info'] . "</b><p/>");

            if (!empty($resultat[0]['enfant1'])) {
                echo("<b>Enfant 1: " . $resultat[0]['enfant1'] . "</b><p/>");
            }
            if (!empty($resultat[0]['enfant2'])) {
                echo("<b>Enfant 2: " . $resultat[0]['enfant2'] . "</b><p/>");
            }
            if (!empty($resultat[0]['enfant3'])) {
                echo("<b>Enfant 3: " . $resultat[0]['enfant3'] . "</b><p/>");
            }
        }












        //鍒ゆ柇鏄痩angue閫夎繃鏉ョ殑
        $requete3 = "select * from reservation_langue where login_nounou=:login_nounou and date=:date";
        $statement3 = $base->prepare($requete3);
        $statement3->execute(array(':login_nounou' => $login_nounou, ':date' => $date_str));
        $resultat3 = $statement3->fetchAll();
        if (!empty($resultat3)) {
            $type = "langue";
            $login_parent = $resultat3[0]['login_parent'];

            $requete2 = "select * from parent where login=:login_parent";
            $statement2 = $base->prepare($requete2);
            $statement2->execute([':login_parent' => $login_parent]);
            $resultat2 = $statement2->fetchAll();
            
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");

            echo("<center><p><h3>Type de prestation: " . $type . "</h3></p>");
            echo("<b>Langue: " . $resultat3[0]['langue'] . "</b><p/>");
            echo("<b>Nom de parent: " . $resultat2[0]['nom'] . "</b><p/>");
            echo("<b>Ville: " . $resultat2[0]['ville'] . "</b><p/>");
            echo("<b>Email: " . $resultat2[0]['email'] . "</b><p/>");
            echo("<b>Information générale: " . $resultat2[0]['info'] . "</b><p/>");

            if (!empty($resultat3[0]['enfant1'])) {
                echo("<b>Enfant 1: " . $resultat3[0]['enfant1'] . "</b><p/>");
            }
            if (!empty($resultat3[0]['enfant2'])) {
                echo("<b>Enfant 2: " . $resultat3[0]['enfant2'] . "</b><p/>");
            }
            if (!empty($resultat3[0]['enfant3'])) {
                echo("<b>Enfant 3: " . $resultat3[0]['enfant3'] . "</b><p/>");
            }
        }

        //鍒ゆ柇鏄痯onctuelle閫夎繃鏉ョ殑
        $requete4 = "select * from reservation_ponctuelle where login_nounou=:login_nounou and date=:date";
        $statement4 = $base->prepare($requete4);
        $statement4->execute(array(':login_nounou' => $login_nounou, ':date' => $date_str));
        $resultat4 = $statement4->fetchAll();
        if (!empty($resultat4)) {
            $type = "ponctuelle";
            $login_parent = $resultat4[0]['login_parent'];

            $requete2 = "select * from parent where login=:login_parent";
            $statement2 = $base->prepare($requete2);
            $statement2->execute([':login_parent' => $login_parent]);
            $resultat2 = $statement2->fetchAll();

            
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
            
            
            echo("<center><p><h3>Type de prestation: " . $type . "</h3></p>");

            echo("<b>Heure de début: " . $resultat4[0]['hdebut'] . "h</b><p/>");
            echo("<b>Heure de fin: " . $resultat4[0]['hfin'] . "h</b><p/>");
            echo("<b>Nom de parent: " . $resultat2[0]['nom'] . "</b><p/>");
            echo("<b>Ville: " . $resultat2[0]['ville'] . "</b><p/>");
            echo("<b>Email: " . $resultat2[0]['email'] . "</b><p/>");
            echo("<b>Information générale: " . $resultat2[0]['info'] . "</b><p/>");

            if (!empty($resultat4[0]['enfant1'])) {
                echo("<b>Enfant 1: " . $resultat4[0]['enfant1'] . "</b><p/>");
            }
            if (!empty($resultat4[0]['enfant2'])) {
                echo("<b>Enfant 2: " . $resultat4[0]['enfant2'] . "</b><p/>");
            }
            if (!empty($resultat4[0]['enfant3'])) {
                echo("<b>Enfant 3: " . $resultat4[0]['enfant3'] . "</b><p/>");
            }
        }


        echo("</center></div></div>");
        ?>


        <center><a class='btn btn-info' href='planning.php'>RETOUR</a></center>

    </body>
</html>
