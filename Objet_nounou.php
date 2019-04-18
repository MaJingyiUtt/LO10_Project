<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$list_nounou=array();
class nounou{
    public $login;
    public $mdp;
    public $nom;
    public $prenom;
    public $age;
    public $ville;
    public $email;
    public $portable;
    public $langues;
    public $experience;
    public $presentation;
    public $estAccepte;
    public $estBloque;
    public $photo;

    function getEstAccepte() {
        return $this->estAccepte;
    }

    function getEstBloque() {
        return $this->estBloque;
    }

    function setEstAccepte($estAccepte) {
        $this->estAccepte = $estAccepte;
    }

    function setEstBloque($estBloque) {
        $this->estBloque = $estBloque;
    }

        
    
    function __construct($login,$mdp,$nom,$prenom,$age,$ville,$email,$portable,$langues,$experience,$presentation,$estAccepte,$estBloque,$photo) {
        $this->login=$login;
        $this->mdp=$mdp;
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->age=$age;
        $this->ville=$ville;
        $this->email=$email;
        $this->portable=$portable;
        $this->langues=$langues;
        $this->experience=$experience;
        $this->presentation=$presentation;
        $this->estAccepte = $estAccepte;
        $this->estBloque = $estBloque;
        $this->photo = $photo;
    }
    

    function getLogin() {
        return $this->login;
    }

    function getMdp() {
        return $this->mdp;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getAge() {
        return $this->age;
    }

    function getVille() {
        return $this->ville;
    }

    function getEmail() {
        return $this->email;
    }

    function getPortable() {
        return $this->portable;
    }

    function getLangues() {
        return $this->langues;
    }

    function getExperience() {
        return $this->experience;
    }

    function getPresentation() {
        return $this->presentation;
    }

      function getPhoto() {
        return $this->photo;
    }
    
    
}


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
