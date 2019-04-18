<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>planning</title>
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
                            <li>
                                <a href='disponibilite.php'>DECLARER VOS DISPONIBILITES</a><p/>
                            </li>
                            <li class="active">
                                <a href='planning.php'>PLANNING</a><p/>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <form method="post" action="planning.php">
            <?php echo("<center><h1>PLANNING DE " . $_COOKIE['login_nounou'] . "</h1></center>") ?>
            <br/>
            <div class="row-fluid">
                <div class="span6">
                    <div class="container-fluid">
                        <div class="hero-unit">
                            <center><p><h5>Année</h5></p>
                                <select name="annee">
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>

                                <p><p><h5>Mois</h5></p>
                                <select name="mois">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select><p/><br/>

                                <input type="submit" value="submit" class='btn btn-success'></input><center>

                                    </div></div></div>



                                    <div class="span6">


                                        <br/>
                                        <br/>

                                        <?php
                                        $annee = $_POST['annee'];
                                        $mois = $_POST['mois'];
                                        $login = $_COOKIE['login_nounou'];




                                        include 'database.php';
                                        try {
                                            $requete = "select * from disponibilite where login=:login";
                                            $statement = $base->prepare($requete);
                                            $statement->execute(['login' => $login]);
                                            $resultat = $statement->fetchAll();
                                        } catch (PDOExceptionException $ex) {
                                            die("Erreur! " . $ex->getMessage());
                                        }


                                        try {
                                            $requete_reguliere = "select * from reservation_reguliere where login_nounou=:login";
                                            $statement_reguliere = $base->prepare($requete_reguliere);
                                            $statement_reguliere->execute(['login' => $login]);
                                            $resultat_reguliere = $statement_reguliere->fetchAll();
                                        } catch (PDOExceptionException $ex) {
                                            die("Erreur! " . $ex->getMessage());
                                        }



                                        $requete_ponctuelle = "select * from reservation_ponctuelle where login_nounou=:login";
                                        $statement_ponctuelle = $base->prepare($requete_ponctuelle);
                                        $statement_ponctuelle->execute(['login' => $login]);
                                        $resultat_ponctuelle = $statement_ponctuelle->fetchAll();

                                        $requete_langue = "select * from reservation_langue where login_nounou=:login";
                                        $statement_langue = $base->prepare($requete_langue);
                                        $statement_langue->execute(['login' => $login]);
                                        $resultat_langue = $statement_langue->fetchAll();








                                        foreach ($resultat as $element) {

                                            if ($element['jour'] == "lundi") {
                                                $jour = "Monday";
                                            } else if ($element['jour'] == "mardi") {
                                                $jour = "Tuesday";
                                            } else if ($element['jour'] == "mercredi") {
                                                $jour = "Wednesday";
                                            } else if ($element['jour'] == "jeudi") {
                                                $jour = "Thursday";
                                            } else if ($element['jour'] == "vendredi") {
                                                $jour = "Friday";
                                            } else if ($element['jour'] == "samedi") {
                                                $jour = "Saturday";
                                            } else {
                                                $jour = "Sunday";
                                            }


                                            //$jour_disponible=array();
                                            //$day_number=array();
                                            
                                            $date_start = $element['ddebut'];
                                            $date_finish = $element['dfin'];
                                            $date_count = $date_start;

                                            while (date("Y-m-d", strtotime($date_count . " +0 week " . $jour)) <= $date_finish) {

                                                if (date("Y-m-d", strtotime($date_count . " +0 week " . $jour)) >= $date_start && date("Y-m-d", strtotime($date_count . " +0 week " . $jour)) <= $date_finish) {

                                                    $jour_disponible[] = date("Y-m-d", strtotime($date_count . " +0 week " . $jour));
                                                }

                                                $date_count = date("Y-m-d", strtotime($date_count . "+1 week"));
                                            }

                                            foreach ($jour_disponible as $element) {
                                                if (date("m", strtotime($element)) == $mois) {
                                                    $day_number[] = date("d", strtotime($element));
                                                }
                                            }
                                        }


                                        $day_number = array_values(array_unique($day_number));

                                        




                                        foreach ($resultat_reguliere as $element_reguliere) {

                                            if ($element_reguliere['jour'] == "lundi") {
                                                $jour_reguliere = "Monday";
                                            } else if ($element_reguliere['jour'] == "mardi") {
                                                $jour_reguliere = "Tuesday";
                                            } else if ($element_reguliere['jour'] == "mercredi") {
                                                $jour_reguliere = "Wednesday";
                                            } else if ($element_reguliere['jour'] == "jeudi") {
                                                $jour_reguliere = "Thursday";
                                            } else if ($element_reguliere['jour'] == "vendredi") {
                                                $jour_reguliere = "Friday";
                                            } else if ($element_reguliere['jour'] == "samedi") {
                                                $jour_reguliere = "Saturday";
                                            } else {
                                                $jour_reguliere = "Sunday";
                                            }


                                            
                                            
                                            $date_start_reguliere = $element_reguliere['ddebut'];
                                            $date_finish_reguliere = $element_reguliere['dfin'];
                                            $date_count_reguliere = $date_start_reguliere;

                                            while (date("Y-m-d", strtotime($date_count_reguliere . " +0 week " . $jour_reguliere)) <= $date_finish_reguliere) {

                                                if (date("Y-m-d", strtotime($date_count_reguliere . " +0 week " . $jour_reguliere)) >= $date_start_reguliere && date("Y-m-d", strtotime($date_count_reguliere . " +0 week " . $jour_reguliere)) <= $date_finish_reguliere) {

                                                    $jour_disponible_reguliere[] = date("Y-m-d", strtotime($date_count_reguliere . " +0 week " . $jour_reguliere));
                                                }

                                                $date_count_reguliere = date("Y-m-d", strtotime($date_count_reguliere . "+1 week"));
                                            }



                                            foreach ($jour_disponible_reguliere as $element_reguliere) {
                                                if (date("m", strtotime($element_reguliere)) == $mois) {
                                                    $day_number_reguliere[] = date("d", strtotime($element_reguliere));
                                                }
                                            }
                                        }

                                        $day_number_reguliere = array_unique($day_number_reguliere);
                                        

                                        $red=array();
                                        $green=$day_number;


                                        if(!empty($day_number_reguliere)){
                                        $red = $day_number_reguliere;
                                        $green = array_diff($day_number, $day_number_reguliere);
                                        }
                                        
                                        $red = array_values($red);
                                        $green = array_values($green);

                                        
                                        
                                        
                                         

                                        //鍑嗗ponctuelle
                                        $date_ponctuelle = array();
                                        $day_number_ponctuelle=array();
                                        foreach ($resultat_ponctuelle as $element_ponctuelle) {
                                            $date_ponctuelle[] = $element_ponctuelle['date'];
                                        }

                                        foreach ($date_ponctuelle as $key_ponctuelle) {
                                            if (date("m", strtotime($key_ponctuelle)) == $mois) {
                                                $day_number_ponctuelle[] = date("d", strtotime($key_ponctuelle));
                                            }
                                        }

                                        
                                        
                                        
                                        
                                        $day_number_ponctuelle = array_unique($day_number_ponctuelle);
                                        
                                        
                                        
                                        //print_r($day_number_ponctuelle);

                                        
                                        if(!empty($day_number_ponctuelle)){
                                        $red = array_merge($red, $day_number_ponctuelle);
                                        $red = array_unique($red);
                                        $green = array_diff($green, $day_number_ponctuelle);
                                        }
                                        
                                        

                                        $red = array_values($red);
                                        $green = array_values($green);

                                        
                                        



                                        //鍑嗗langue
                                        //$date_langue = array();
                                        foreach ($resultat_langue as $element_langue) {
                                            $date_langue[] = $element_langue['date'];
                                        }
                                        //print_r($date_ponctuelle);
                                        foreach ($date_langue as $key_langue) {
                                            if (date("m", strtotime($key_langue)) == $mois) {
                                                $day_number_langue[] = date("d", strtotime($key_langue));
                                            }
                                        }

                                        $day_number_langue = array_unique($day_number_langue);


                                        if(!empty($day_number_langue)){
                                        $red = array_merge($red, $day_number_langue);
                                        $red = array_unique($red);
                                        $green = array_diff($green, $day_number_langue);
                                        
                                        
                                        }
                                        

                                        $red = array_values($red);
                                        $green = array_values($green);


                                       


                                        //鍑嗗棰滆壊鍜岃〃鏍?
                                        $count_red = count($red);
                                        $count_green = count($green);

                                        //echo($count_red);
                                        //echo($count_green);

                                        for ($i = $count_red; $i <= 30; $i++) {
                                            $red[$i] = 100;
                                        }

                                        for ($i = $count_green; $i <= 30; $i++) {
                                            $green[$i] = 100;
                                        }

                                        



                                        date_default_timezone_set('Europe/Paris');


//鍙栧埌 骞? 鏈? 鏃?
                                        $time = getdate();
                                        $mday = $time["mday"];
                                        $mon = $time["mon"];
                                        $year = $time["year"];

//鍒ゆ柇涓€涓嬩竴骞翠腑鍚勪釜鏈堜唤鏈夊嚑澶╃殑鎯呭喌
                                        if ($mon == 4 || $mon == 6 || $mon == 9 || $mon == 11) {
                                            $day = 30;
                                        } elseif ($mon == 2) {
                                            if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
                                                $day = 29;
                                            } else {
                                                $day = 28;
                                            }
                                        } else {
                                            $day = 31;
                                        }
//鍙栧埌杩欎釜鏈堢殑1鍙锋槸绗嚑澶╋紝
                                        $w = getdate(mktime(0, 0, 0, $mois, 1, $year))["wday"];
//鍒朵綔鏃ュ巻鐨勫ぇ妗嗘灦銆傜敤for閬嶅巻鏁扮粍锛屾墦鍗板嚭涓€涓棩鍘嗙殑鏍煎紡銆?
                                        $date = function($day, $w) {

                                            echo "<table border='1'>";
                                            echo "<tr><th>Dimanche</th><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th><th>Samedi</th></tr>";
                                            $arr = array();
                                            for ($i = 1; $i <= $day; $i++) {
                                                array_push($arr, $i);
                                            }
                                            if ($w >= 1 && $w <= 6) {
                                                for ($m = 1; $m <= $w; $m++) {
                                                    array_unshift($arr, "");
                                                }
                                            }
                                            $n = 0;
                                            for ($j = 1; $j <= count($arr); $j++) {
                                                $n++;
                                                if ($n == 1)
                                                    echo "<tr>";
                                                global $mday;
                                                //if (8 == $arr[$j - 1]||6 == $arr[$j - 1]||7 == $arr[$j - 1]||20 == $arr[$j - 1]) 

                                                global $red;
                                                global $green;



                                                if ($red[0] == $arr[$j - 1] || $red[1] == $arr[$j - 1] || $red[2] == $arr[$j - 1] ||
                                                        $red[3] == $arr[$j - 1] || $red[4] == $arr[$j - 1] || $red[5] == $arr[$j - 1] ||
                                                        $red[6] == $arr[$j - 1] || $red[7] == $arr[$j - 1] || $red[8] == $arr[$j - 1] ||
                                                        $red[9] == $arr[$j - 1] || $red[10] == $arr[$j - 1] || $red[11] == $arr[$j - 1] ||
                                                        $red[12] == $arr[$j - 1] || $red[13] == $arr[$j - 1] || $red[14] == $arr[$j - 1] ||
                                                        $red[15] == $arr[$j - 1] || $red[16] == $arr[$j - 1] || $red[17] == $arr[$j - 1] ||
                                                        $red[18] == $arr[$j - 1] || $red[19] == $arr[$j - 1] || $red[20] == $arr[$j - 1] ||
                                                        $red[21] == $arr[$j - 1] || $red[22] == $arr[$j - 1] || $red[23] == $arr[$j - 1] ||
                                                        $red[24] == $arr[$j - 1] || $red[25] == $arr[$j - 1] || $red[26] == $arr[$j - 1] ||
                                                        $red[27] == $arr[$j - 1] || $red[28] == $arr[$j - 1] || $red[29] == $arr[$j - 1] ||
                                                        $red[30] == $arr[$j - 1]
                                                ) {

//鎶婁粖澶╃殑杩欎竴澶╁姞涓€涓鑹?
                                                    echo "<td width='80px' style='background-color: pink;'> "
                                                    . "<a href=reservation_info.php?day=" . $arr[$j - 1] . "&month=" . $_POST['mois'] . ">" . $arr[$j - 1] . "</a></td>";
                                                } else if (
                                                        $green[0] == $arr[$j - 1] || $green[1] == $arr[$j - 1] || $green[2] == $arr[$j - 1] ||
                                                        $green[3] == $arr[$j - 1] || $green[4] == $arr[$j - 1] || $green[5] == $arr[$j - 1] ||
                                                        $green[6] == $arr[$j - 1] || $green[7] == $arr[$j - 1] || $green[8] == $arr[$j - 1] ||
                                                        $green[9] == $arr[$j - 1] || $green[10] == $arr[$j - 1] || $green[11] == $arr[$j - 1] ||
                                                        $green[12] == $arr[$j - 1] || $green[13] == $arr[$j - 1] || $green[14] == $arr[$j - 1] ||
                                                        $green[15] == $arr[$j - 1] || $green[16] == $arr[$j - 1] || $green[17] == $arr[$j - 1] ||
                                                        $green[18] == $arr[$j - 1] || $green[19] == $arr[$j - 1] || $green[20] == $arr[$j - 1] ||
                                                        $green[21] == $arr[$j - 1] || $green[22] == $arr[$j - 1] || $green[23] == $arr[$j - 1] ||
                                                        $green[24] == $arr[$j - 1] || $green[25] == $arr[$j - 1] || $green[26] == $arr[$j - 1] ||
                                                        $green[27] == $arr[$j - 1] || $green[28] == $arr[$j - 1] || $green[29] == $arr[$j - 1] ||
                                                        $green[30] == $arr[$j - 1]
                                                ) {

                                                    echo "<td width='80px' style='background-color: greenyellow;'>" . $arr[$j - 1] . "</td>";
                                                } else {
                                                    echo "<td width='80px'>" . $arr[$j - 1] . "</td>";
                                                }

                                                if ($n == 7) {
                                                    echo "</tr>";
                                                    $n = 0;
                                                }
                                            }
                                            if ($n != 7)
                                                echo "</tr>";

                                            echo "</table>";
                                        };




                                        $date($day, $w);
                                        ?>

                                        <br/>
                                        <br/>

                                        *Rouge: Réservation<br/> 
                                        *Vert: Encore disponible<br/>
                                        *Vous pouvez accéder aux informations de la réservation


                                    </div></div>
                                    </form> 
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
                                    </body>
                                    </html>
