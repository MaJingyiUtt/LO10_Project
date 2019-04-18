<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8" />

        <title>créer un compte parent</title>
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
        <center><h1>Créer un compte parent</h1></center>
        <form method="POST" action="new_parent_action.php" > 
            <div class="container-fluid">
                <div class="hero-unit">
                    

            <h4>Login&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="login" /></h4>
            <h4>Mot de passe&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="password" name="mdp1" /></h4> 
            <h4>Comfirmer votre mot de passe&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="password" name="mdp2"/></h4>
            <h4>Nom de famille&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="ndf"/></h4>
            <h4>Ville&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="ville" /></h4> 
            <h4>Email&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="email"/></h4>
                            
            <?php
            for ($i = 1; $i <= 3; $i++) {
                echo("<fieldset>");
                echo("<h4><legend> Enfant " . $i . "</legend></h4>");
                echo(" <h4>Prénom&nbsp;&nbsp;&nbsp;&nbsp;");
                echo(" <input type='text' name='prenom$i'/></h4>");
                echo(" <h4>Date de naissance&nbsp;&nbsp;&nbsp;&nbsp;");
                echo(" <input type='date' name='ddn$i'/></h4>");
                echo(" <h4>Restrictions alimentaires&nbsp;&nbsp;&nbsp;&nbsp;");
                echo(" <textarea name='restriction_alimentaires$i' rows='5' cols='50'/></textarea></h4>");
                echo("</fieldset>");
                echo("<p/>");
            }
            ?>

            <h4> Information générale &nbsp;&nbsp;&nbsp;&nbsp;
            <textarea name="information_generale" rows="5" cols="50"/></textarea></h4>


            <p><input type="reset" value="RESET" class="btn btn-danger"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" value="ENVOYER" class="btn btn-success"/></p>








    </form>
</div></div></div>



<?php
?>
</body>
</html>
