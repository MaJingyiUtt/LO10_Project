<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>evaluer</title>
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
                            <li class="active">
                                <a href= class="active"'evaluer.php'>EVALUER UN NOUNOU</a><p/>
                            </li>
                            <li>
                                <a href='garde_langue.php'>GARDE D'ENFANT EN LANGUES ETRANGERES</a><p/>
                            </li>
                            <li>
                                <a href='garde_reguliere.php'>GARDE D'ENFANT REGULIERES</a><p/>
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
        <?php
        $evaluation = $_POST['evaluation'];

        $appreciation = $_POST['appreciation'];
        $pieces = explode(":", $_POST['nounou:jour']);
        $login_nounou = $pieces[0];
        $jour = $pieces[1];
        $heure = $_POST['heure'];
        $nbenfant = $_POST['nb'];
        $revenu = 3 + 4 * $nbenfant * $heure;
        // echo $evaluation;
        $date = date("Y-m-d H:i:s");
        //  echo $date;
        ////////////分字   然后存进数据库 qualite_nounou
        include 'database.php';
        try {
            $base = new PDO($datasourceName, $user, $password);

            // echo '进入try';
            $requete = "insert into evaluation values (:login_nounou,:revenu,:evaluation,:appreciation,:date)";
            $statement = $base->prepare($requete);
            $statement->execute(array(':login_nounou' => $login_nounou, ':revenu' => $revenu, ':evaluation' => $evaluation, ':appreciation' => $appreciation, ':date' => $date));


            $requete2 = "UPDATE reservation_reguliere SET fini='oui' WHERE login_nounou=:login and jour= :jour ";
            $statement2 = $base->prepare($requete2);
            $statement2->execute(array(':login' => $login_nounou, ':jour' => $jour));
        } catch (PDOExceptionException $ex) {
            die("Erreur! " . $ex->getMessage());
        }
        ?>
        <div class="container-fluid">
                <div class="hero-unit">
                    <center><h3>Votre évaluation a été enregistrée</h3></center>
                </div></div>
    </body>
</html>
