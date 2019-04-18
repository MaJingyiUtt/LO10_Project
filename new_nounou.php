<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*
  setcookie('login_nounou');
  setcookie('login_parent');
  setcookie('jour_choisi');
  setcookie('ddebut_choisi');
  setcookie('dfin_choisi');
  setcookie('hdebut_choisi');
  setcookie('hfin_choisi');
  setcookie('i');
  setcookie('list_nounou');
*/

?>
<html>
    <head>
        <title>créer un compte nounous</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <a class="brand">NOUNOU</a>
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
        <center><h1>Dépôt de candidature</h1></center>
        <br/>
        <form method="post" action="new_nounou_action.php" enctype="multipart/form-data">
            <div class="container-fluid">
                <div class="hero-unit">
            <h4>Login &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="login"/><h4>
            <h4>mot de passe &nbsp;&nbsp;&nbsp;&nbsp; <input type="password" name="mdp1"/></h4>
            <h4>Nom &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nom"/></h4>
            <h4>Prénom &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="prenom"/></h4>
            <h4>Age &nbsp;&nbsp;&nbsp;&nbsp;
<?php

function age() {
    $liste = array();
    for ($age = "16"; $age < "70"; $age++) {
        $liste[] = $age;
    }
    echo'<select name="age"/>';
    foreach ($liste as $value) {
        echo"<option>$value</option>";
    }
    echo'</select>';
}

age();
?> 
                </h4>
            <h4>Ville &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="ville"/></h4>
            <h4>Email&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="email"/></h4>
            <h4>Portable &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="portable"/></h4>
            <h4>Liste des langues parlées &nbsp;&nbsp;&nbsp;&nbsp;
            <select multiple name="langues[]" size="8">
                <option>anglais</option>
                <option>espagnol</option>
                <option>portugais</option>
                <option>allemand</option>
                <option>italien</option>
                <option>chinois</option>
                <option>japonais</option>
                <option>arabe</option>
            </select></h4>
            <h4>Une photo &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" name="fileToUpload" id="file" onchange="showPreview(this.id, 'portrait')"/></h4>
            <img src="" id="portrait" style="width: 200px; display: block;" />
            <script type="text/javascript">
                /* 图片预览 */
                function showPreview(fileId, imgId) {
                    var file = document.getElementById(fileId);
                    var ua = navigator.userAgent.toLowerCase();
                    var url = '';
                    if (/msie/.test(ua)) {
                        url = file.value;
                    } else {
                        url = window.URL.createObjectURL(file.files[0]);
                    }
                    document.getElementById(imgId).src = url;
                }
            </script> 
            <h4>Expérience &nbsp;&nbsp;&nbsp;&nbsp;
            <textarea name="experience" rows="5" cols="50"/></textarea></h4>
        <h4>Une phrase de présentation&nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="presentation" rows="5" cols="50"/></textarea></h4>
    <p><input type="reset" value="RESET" class="btn btn-danger"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" value="ENVOYER" class="btn btn-success"/></p>
    </div>
                </div>
</form>
        
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
