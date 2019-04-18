<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>évaluer un nounou</title>
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
                                <a href='evaluer.php'>EVALUER UN NOUNOU</a><p/>
                            </li>
                            <li>
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
    <center><h1>Evaluer un nounou</h1></center><br/>
        <?php
        include 'database.php';
        try {
            $login = $_COOKIE['login_parent'];
            $requete = "select login_nounou, jour, ddebut, dfin,nbenfant from reservation_reguliere where fini='non' and login_parent = :login";
            $statement = $base->prepare($requete);
            $statement->execute(['login' => $login]);
            $resultat = $statement->fetchAll();
        } catch (PDOExceptionException $ex) {
            die("Erreur! " . $ex->getMessage());
        }
        echo'<form method="POST" action="evaluer_action.php">';
        echo("<div class='container-fluid'>
                                <div class='hero-unit'>");
        foreach ($resultat as $element) {
            echo("<fieldset>");
            $requete2 = "select * from nounou where login=:login";
            $statement2 = $base->prepare($requete2);
            $statement2->execute(['login' => $element['login_nounou']]);
            $resultat2 = $statement2->fetch();
            echo "<img src= photos/" . $resultat2['photo'] . " width='100' alt='photo'/><br/>"; /////////照片
            echo("<p><b>Nom: </b>" . $resultat2['nom'] . "</p>");
            echo("<p><b>Prénom: </b>" . $resultat2['prenom'] . "</p>");
            echo("<p><b>Jour: </b>" . $element['jour'] . "</p>");
            echo("<p><b>Date: </b>" . $element['ddebut'] . " à " . $element['dfin'] . "</p>");
            echo"<h5><input type='radio' name='nounou:jour' value=" . $element['login_nounou'] . ":" . $element['jour'] . " />";
            echo("<font color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;Je choisis cette nounou</h5></font><br/>");
            echo("</fieldset>");
        }
        ?>
        <label><b>Nombre d'enfants</b></label>
        <select name="nb">
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
        </select><p/>
        <label><b>Evaluation</label></b>
        <select name="evaluation">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><p/>  
        <label><b>Nombre d'heures</label></b>
        <select name="heure">
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
        </select><p/>
        <label><b>Appréciation</label></b>
        <textarea name="appreciation" rows="5" cols="50"/></textarea><p/>
    <center><p><input type='submit' class='btn btn-success' value='ENREGISTRER'></input></p></center>
</div></div>

</form>

</body>
</html>
