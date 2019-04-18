<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>compte créé</title>
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
                    <a class="brand">PARENT</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active">
                                <a href="home.html">HOME</a><p/>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <?php
        include 'database.php';
        $login = $_POST['login'];
        $mdp1 = $_POST["mdp1"];
        $mdp2 = $_POST["mdp2"];
        $nom = $_POST["ndf"];
        $ville = $_POST['ville'];
        $email = $_POST['email'];
        $info = $_POST['information_generale'];
        $prenom1 = $_POST['prenom1'];
        $ddn1 = $_POST['ddn1'];
        $res_a1 = $_POST['restriction_alimentaires1'];
        $prenom2 = $_POST['prenom2'];
        $ddn2 = $_POST['ddn2'];
        $res_a2 = $_POST['restriction_alimentaires2'];
        $prenom3 = $_POST['prenom3'];
        $ddn3 = $_POST['ddn3'];
        $res_a3 = $_POST['restriction_alimentaires3'];



        if (!empty($login) && !empty($mdp1) && !empty($mdp2)) {

            if ($mdp1 == $mdp2) {
                echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
                
                try {

                    $base = new PDO($datasourceName, $user, $password);
                    

                    $requete = "INSERT INTO parent VALUES (:login,:mdp,:nom,:ville,:email,:info)";
                    $statement = $base->prepare($requete);
                    $statement->execute(array(':login' => $login, ':mdp' => $mdp2, ':nom' => $nom, ':ville' => $ville, ':email' => $email, ":info" => $info));


                    $requete2 = "INSERT INTO enfant VALUES (:login,:prenom1,:ddn1,:res_a1,:prenom2,:ddn2,:res_a2,:prenom3,:ddn3,:res_a3)";
                    $statement2 = $base->prepare($requete2);
                    $statement2->execute(array(':login' => $login, ':prenom1' => $prenom1, ':ddn1' => $ddn1, ':res_a1' => $res_a1, ':prenom2' => $prenom2, ':ddn2' => $ddn2, ':res_a2' => $res_a2, ':prenom3' => $prenom3, ':ddn3' => $ddn3, ':res_a3' => $res_a3));


                    echo'<p><center><h3>Compte créé</center></h3></p>';
                    echo("<center><a class='btn btn-info' href='login_parent.html'>LOGIN</a></center>");
                    
                }
                
                catch (PDOExceptionException $ex) {
                    die("Erreur! " . $ex->getMessage());
                }
                $base = NULL;
            }

            if ($mdp1 != $mdp2) {
                echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
                echo("<center><p>Votre mot de passe n'est pas correct ! Veuillez ressayer. </p>");
                echo("<a class='btn btn-info' href='new_parent.php'>Ressayer</a></p></center>");
                
            }
        } else {
            echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
            echo("<center><p>Veuillez remplir votre login et votre mot de passe . </p>");
            echo("<a class='btn btn-info' href='new_parent.php'>Ressayer</a></p></center>");
            
        }

        
        echo("</div></div>");
        ?>
    </body>
</html>
