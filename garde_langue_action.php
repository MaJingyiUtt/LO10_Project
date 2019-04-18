<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Garde d’enfant en langues étrangères</title>
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
                    <a class="brand">PARENT <?php echo$_COOKIE['login_parent']; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li>
                                <a href="home.html">HOME</a><p/>
                            </li>
                            <li>
                                <a href='evaluer.php'>EVALUER UN NOUNOU</a><p/>
                            </li>
                            <li class="active">
                                <a href='garde_langue.php'>GARDE D'ENFANT EN LANGUES ETRANGERES</a><p/>
                            </li>
                            <li>
                                <a href='garde_reguliere.php'>GARDE D'ENFANT REGULIERE</a><p/>
                            </li>
                            <li>
                                <a href='garde_ponctuelle.php'>GARDE PONCTUELLE</a><p/> 
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>

    <center><h1>Choix de garde d'enfant en langues étrangères</h1></center><br/>

    <?php
    $login = $_COOKIE['login_parent'];
    $langue = $_POST["langue"];
    $date = $_POST['date'];
    $bloquer = "non";

    $date_str = date('Y-m-d', strtotime($date));
    $arr = explode("-", $date_str);
    $year = $arr[0];
    $month = sprintf('%02d', $arr[1]);
    $day = sprintf('%02d', $arr[2]);
    $hour = $minute = $second = 0;
    $strap = mktime($hour, $minute, $second, $month, $day, $year);
    $number_wk = date("w", $strap);
    $weekArr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
    $week = $weekArr[$number_wk];







    include 'database.php';

    echo'<form method="POST" action="reservation_langue.php">';

    //确认这个nounou
    $requete = "select login from nounou where langues like ?";
    $statement = $base->prepare($requete);
    $statement->execute(array("%$langue%"));
    $resultat = $statement->fetchAll();
    foreach ($resultat as $element) {
        $nounou[] = $element['login'];
    }



    //确定在disponibilite里面
    $nounou1 = array();
    $requete1 = "select distinct login from disponibilite where ddebut<=:date and dfin>=:date and jour=:week";
    //"and bloquer=:bloquer";
    $statement1 = $base->prepare($requete1);
    $statement1->execute(array(':date' => $date, ':week' => $week));
    //, ':bloquer' => $bloquer));
    $resultat1 = $statement1->fetchAll();
    foreach ($resultat1 as $element1) {
        $nounou1[] = $element1['login'];
    }



    //确定不在reservation_reguliere里面
    $nounou2 = array();
    $requete2 = "select distinct login_nounou from reservation_reguliere where ddebut<=:date and dfin>=:date and jour=:week and fini='non'";
    $statement2 = $base->prepare($requete2);
    $statement2->execute(array(':date' => $date, ':week' => $week));
    $resultat2 = $statement2->fetchAll();
    foreach ($resultat2 as $element2) {
        $nounou2[] = $element2['login_nounou'];
    }



    //print_r($nounou2);
    //确定不在reservation_ponctuelle里面
    $nounou3 = array();
    $requete3 = "select distinct login_nounou from reservation_ponctuelle where date=:date";
    $statement3 = $base->prepare($requete3);
    $statement3->execute(['date' => $date]);
    $resultat3 = $statement3->fetchAll();

    foreach ($resultat3 as $element3) {
        $nounou3[] = $element3['login_nounou'];
    }

    //确定不在reservation_langue里面
    $nounou4 = array();
    $requete4 = "select distinct login_nounou from reservation_langue where date=:date";
    $statement4 = $base->prepare($requete4);
    $statement4->execute(['date' => $date]);
    $resultat4 = $statement4->fetchAll();

    foreach ($resultat4 as $element4) {
        $nounou4[] = $element4['login_nounou'];
    }

    //确定不bloquer                   
    $nounou5 = array();
    $requete9 = "select login from nounou where bloquer=:bloquer";
    $statement9 = $base->prepare($requete9);
    $statement9->execute(['bloquer' => $bloquer]);
    $resultat9 = $statement9->fetchAll();

    foreach ($resultat9 as $element9) {
        $nounou5[] = $element9['login'];
    }
    
    $nounou_final=$nounou;
        
    if (!empty($nounou1)) {
        $nounou_final = array_intersect($nounou, $nounou1);
    }
    //print_r($nounou_final);
    if (!empty($nounou_final) && !empty($nounou2)) {
        $nounou_final = array_diff($nounou_final, $nounou2);
    }
    //print_r($nounou_final);
    if (!empty($nounou_final) && !empty($nounou3)) {
        $nounou_final = array_diff($nounou_final, $nounou3);
    }
    //print_r($nounou_final); 
    if (!empty($nounou_final) && !empty($nounou4)) {
        $nounou_final = array_diff($nounou_final, $nounou4);
    }
    //print_r($nounou_final); 
    if (!empty($nounou_final) && !empty($nounou5s)) {
        $nounou_final = array_intersect($nounou_final, $nounou5);
    }
    //print_r($nounou_final); 


    if (empty($nounou_final)) {
        echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
        echo "<center>Il n'y a pas de nounou qui correspond à votre demande</centers>";
        echo("</div></div>");
    } else {

        setcookie('langue', $langue);
        setcookie('date_langue', $date);
        echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
        foreach ($nounou_final as $element) {

            echo("<fieldset><legend></legend>");

            $requete5 = "select * from nounou where login=:login";
            $statement5 = $base->prepare($requete5);
            $statement5->execute(['login' => $element]);
            $resultat5 = $statement5->fetch();

            $requete7 = "select avg(evaluation) from evaluation where login_nounou=:login and evaluation!=''";
            $statement7 = $base->prepare($requete7);
            $statement7->execute(['login' => $element]);
            $resultat7 = $statement7->fetch();


            echo "<img src= photos/" . $resultat5['photo'] . " width='100' alt='photo'/><br/>"; /////////照片
            echo("<p><b>Nom: </b>" . $resultat5['nom'] . "</p>");
            echo("<p><b>Prénom: </b>" . $resultat5['prenom'] . "</p>");
            echo("<p><b>Ville: </b>" . $resultat5['ville'] . "</p>");
            echo("<p><b>Email: </b>" . $resultat5['email'] . "</p>");
            echo("<p><b>Portable: </b>" . $resultat5['portable'] . "</p>");
            echo("<p><b>Evaluation: </b>" . $resultat7[0] . "</p>");
            echo("<p><b>Langues: </b>" . $resultat5['langues'] . "</p>");
            echo"<br/><h5><input type='radio' name='nounou_langue' value=" . $element . "></input>";
            echo("<font color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;Je choisis cette nounou</h5></font><br/>");

            echo("</fieldset>");
        }

        $requete6 = "select prenom1,prenom2,prenom3 from enfant where login=:login";
        $statement6 = $base->prepare($requete6);
        $statement6->execute(['login' => $login]);
        $resultat6 = $statement6->fetch();
        
        

        echo("<p>");
        echo("<h5><font color='brown'>Veuillez choisir les enfants: &nbsp;&nbsp;&nbsp;&nbsp;</font>");

        if (!empty($resultat6['prenom1'])) {
            echo("<input type='checkbox' name='enfant1' value=" . $resultat6['prenom1'] . "></input>");
            echo("&nbsp;&nbsp;" . $resultat6['prenom1'] . "&nbsp;&nbsp;");
        }

        if (!empty($resultat6['prenom2'])) {
            echo("<input type='checkbox' name='enfant2' value=" . $resultat6['prenom2'] . "></input>");
            echo("&nbsp;&nbsp;" . $resultat6['prenom2'] . "&nbsp;&nbsp;");
        }

        if (!empty($resultat6['prenom3'])) {
            echo("<input type='checkbox' name='enfant3' value=" . $resultat6['prenom3'] . "></input>");
            echo("&nbsp;&nbsp;" . $resultat6['prenom3'] . "&nbsp;&nbsp; </p>");
        }

        echo("</h5><h5><font color='brown'>Veuillez choisir les heures: &nbsp;&nbsp;&nbsp;&nbsp;</font>
            <select name='heure'>
                <option value='1'>1h</option>
                <option value='2'>2h</option>
                <option value='3'>3h</option>
            </select></h5><p/>");



        echo("<p><center><input type='submit'  class='btn btn-success 'value='ENREGISTRER'></input></center></p>");
        echo("</form>");

        echo("</div></div>");
    }
    ?>
<?php
// put your code here
?>
</body>
</html>

