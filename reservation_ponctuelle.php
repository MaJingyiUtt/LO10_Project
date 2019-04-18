<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>réservation</title>
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
                    <a class="brand">PPARENT <?php echo$_COOKIE['login_parent']; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li>
                                <a href="home.html">HOME</a><p/>
                            </li>
                            <li>
                                <a href='evaluer.php'>EVALUER UN NOUNOU</a><p/>
                            </li>
                            <li>
                                <a href='garde_langue.php'>GARDE D'ENFANT EN LANGUES ETRANGERES</a><p/>
                            </li>
                            <li>
                                <a href='garde_reguliere.php'>GARDE D'ENFANT REGULIERE</a><p/>
                            </li>
                            <li class="active">
                                <a href='garde_ponctuelle.php'>GARDE PONCTUELLE</a><p/> 
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <?php
        include 'database.php';
        $login_parent = $_COOKIE['login_parent'];
        $login_nounou = $_POST['nounou_ponctuelle'];

        $date = $_COOKIE['date'];
        $hdebut = $_COOKIE['hdebut_ponctuelle'];
        $hfin = $_COOKIE['hfin_ponctuelle'];

        $nbenfant = 0;
        if (!empty($_POST['enfant1'])) {
            $enfant1 = $_POST['enfant1'];
            $nbenfant++;
        } else {
            $enfant1 = null;
        }



        if (!empty($_POST['enfant2'])) {
            $enfant2 = $_POST['enfant2'];
            $nbenfant++;
        } else {
            $enfant2 = null;
        }

        if (!empty($_POST['enfant3'])) {
            $enfant3 = $_POST['enfant3'];
            $nbenfant++;
        } else {
            $enfant3 = null;
        }



        $requete = "INSERT INTO reservation_ponctuelle VALUES (:login_parent,:login_nounou,:hdebut,:hfin,:date,:enfant1,:enfant2,:enfant3,'non',:nbenfant)";
        $statement = $base->prepare($requete);
        $statement->execute(array(':login_parent' => $login_parent, ':login_nounou' => $login_nounou, ':hdebut' => $hdebut, ':hfin' => $hfin, ':date' => $date, ':enfant1' => $enfant1, ':enfant2' => $enfant2, ':enfant3' => $enfant3, ':nbenfant' => $nbenfant));
        //////////////////直接发工资///////////
        /* $revenu=(5+5*nbenfant)*(hfin-hdebut);
          $requete2 = "insert into qualite_nounou values (:login_nounou,:revenu)";
          $statement2 = $base->prepare($requete2);
          $statement2->execute(array(':login_nounou' => $login_nounou,':revenu' => $revenu));
         * 
         */
        //$date=date("Y-m-d H:i:s");
        $revenu = (5 + 5 * $nbenfant) * ($hfin - $hdebut);
        $evaluation = '';
        $appreciation = "";
        $requete2 = "insert into evaluation values (:login_nounou,:revenu,:evaluation,:appreciation,:date)";
        $statement2 = $base->prepare($requete2);
        $statement2->execute(array(':login_nounou' => $login_nounou, ':revenu' => $revenu, ':evaluation' => $evaluation, ':appreciation' => $appreciation, ':date' => $date));
        ?>
        <div class="container-fluid">
                <div class="hero-unit">
                    <center><h3>Votre demande a été enregistré</h3></center>
                </div></div>
    </body>
</html>
