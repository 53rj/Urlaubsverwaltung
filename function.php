<?php

class personal{

    private $pid;
    private $vorname;
    private $nachname;
    private $passwort;
    private $status;
    private $uid;
    private $kid;
    private $utage;
    private $restutage;

    public function __construct($pid,$vorname,$nachname,$passwort,$status,$uid,$kid,$utage,$restutage){
        $this->pid = $pid;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
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

    public function getVorname(){
        return $this->vorname;
    }
    public function setVorname($newVorname){
        $this->vorname = $newVorname;
    }

    public function getName(){
        return $this->nachname;
    }
    public function setName($newName){
        $this->nachname = $newName;
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

}

function connServer(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "urlaubsverwaltung";      
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $passwort);
    return $conn;
}


function checkuser(){
    connServer();

    $sql = "SELECT * FROM personal";
    foreach ($conn->query($sql) as $i) {
    echo "".$i["pid"].";"."".$i["nachname"].";"."".$i["passwort"].";"."".$i["status"]."";
    echo "<br></br>";

    if($i["nachname"]== $nachname && $i["passwort"]== $passwort && $i["status"]== 1){
        echo "Ihr Personal login war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
    }
    
    if($i["nachname"]== $nachname && $i["passwort"]== $passwort && $i["status"]== 2){
        echo "Ihr Personalleiter login war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
    }

    if($i["nachname"]== $nachname && $i["passwort"]== $passwort && $i["status"]== 3){
        echo "Ihr Admin login war erfolgreich";
    }
    $conn = null;

    }
}


function showData($zahl){
    connServer();
    
    if ($zahl == 1){
        $sql = "SELECT * FROM personal";
        foreach ($conn->query($sql) as $i){
            echo "".$i["pid"].";"."".$i["vorname"].";"."".$i["nachname"].";"."".$i["passwort"].";"."".$i["status"].";"."".$i["urlaubstage"].";"."".$i["resturlaub"]."";
            echo "<br></br>";
        }
    }

    if ($zahl == 2){
        $sql = "SELECT * FROM krankheit";
        foreach ($conn->query($sql) as $i){
            echo "".$i["kid"].";"."".$i["pid"].";"."".$i["kanfang"].";"."".$i["kende"].";"."".$i["kgesamt"].";"."";
            echo "<br></br>";
        }
    }

    if ($zahl == 3){
        $sql = "SELECT * FROM urlaubsantrag";
        foreach ($conn->query($sql) as $i){
            echo "".$i["uid"].";"."".$i["pid"].";"."".$i["uanfang"].";"."".$i["uende"].";"."".$i["ubeantragt"].";"."".$i["ugenommen"].";"."".$i["ugesamt"].";"."".$i["ustatus"]."";
            echo "<br></br>";
        }
    }
    $conn = null;
}


?>