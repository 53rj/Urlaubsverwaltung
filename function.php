<?php

class personal{

    private $pid;
    private $name;
    private $passwort;
    private $status;
    private $uid;
    private $kid;
    private $utage;
    private $restutage;

    public function __construct($pid,$name,$passwort,$status,$uid,$kid,$utage,$restutage){
        $this->pid = $pid;
        $this->name = $name;
        $this->passwort = $passwort;
        $this->status = $status;
        $this->uid = $uid;
        $this->kid = $kid;
        $this->utage = $utage;
        $this->restutage = $restutage;
    }

    public function getPid(){
        return $this->pid;
    }
    public function setPid($newPid){
        $this->pid = $newPid;
    }


    public function getName(){
        return $this->name;
    }
    public function setName($newName){
        $this->name = $newName;
    }


    public function getPasswort(){
        return $this->passwort;
    }
    public function setPasswort($newPasswort){
        $this->passwort = $newPasswort;
    }


    public function getStatus(){
        return $this->status;
    }
    public function setStatus($newStatus){
        $this->status = $newStatus;
    }


    public function getUid(){
        return $this->uid;
    }
    public function setUid($newUid){
        $this->uid = $newUid;
    }


    public function getKid(){
        return $this->kid;
    }
    public function setKid($newKid){
        $this->kid = $newKid;
    }


    public function getUtage(){
        return $this->utage;
    }
    public function setUtage($newUtage){
        $this->utage = $newUtage;
    }


    public function getRestutage(){
        return $this->restutage;
    }
    public function setRestutage($newRestutage){
        $this->restutage = $newRestutage;
    }
    
    function checkuser(){

        connServer();

        $sql = "SELECT * FROM personal";
        foreach ($conn->query($sql) as $i) {
        echo "".$i["uid"].";"."".$i["name"].";"."".$i["email"].";"."".$i["rolle"]."";
        echo "<br></br>";

        if($i["name"]== $name && $i["email"]== $email && $i["status"]== 1){
            echo "Ihr Personal login war erfolgreich, Sie Können jetzt Ihren Urlaubsantrag stellen";
        }
        
        if($i["name"]== $name && $i["email"]== $email && $i["status"]== 2){
            echo "Ihr Personalleiter login war erfolgreich, Sie Können jetzt Ihren Urlaubsantrag stellen";
        }

        if($i["name"]== $name && $i["email"]== $email && $i["status"]== 3){
            echo "Ihr Admin login war erfolgreich, Sie Können jetzt Ihren Urlaubsantrag stellen";
        }
        $conn = null;

        }

    }

    function connServer(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "urlaubsverwaltung";      
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $passwort);
    }
}


?>