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
        <?php
        $login = $_COOKIE['login_parent'];
        ?>
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
                            <li >
                                <a href='garde_ponctuelle.php'>GARDE PONCTUELLE</a><p/> 
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <form method="POST" action="garde_langue_action.php">
<center><h1>Garde d’enfant en langues étrangères</h1></center>
            <br/>
            <div class="container-fluid">
                 <div class="hero-unit">
            <center><h5>Date</h5>   
            <input type='date' name='date' value="2018-07-19"/><p/>
            <h5>Choisissez une langue</h5>
            <select name="langue">
                <option>anglais</option>
                <option>espagnol</option>
                <option>portugais</option>
                <option>allemand</option>
                <option>italien</option>
                <option>chinois</option>
                <option>japonais</option>
                <option>arabe</option>
            </select><p/><br/>
            <input type="submit" value="VALIDER" class='btn btn-success'/></center>
            
            </div></div>
        </form>
    </body>
</html>
