<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
  define('LO07_DB_USER', 'root');
  define('LO07_DB_PASSWORD', 'root');//自己的密码记得改
  define('LO07_DB_HOST', 'localhost');
  define('LO07_DB_NAME','lo07projet');
  $maBase= mysqli_connect(LO07_DB_HOST, LO07_DB_USER, LO07_DB_PASSWORD,LO07_DB_NAME)or
  die ('Impossible de se connecter a MySQL :'+ mysqli_connect_error());
 * 
 * 
 */

$user = 'root';
$password = '';
$datasourceName = 'mysql:host=localhost;dbname=lo07projet';
$base = new PDO($datasourceName, $user, $password);
