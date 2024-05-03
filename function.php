<?php

class personal{
    private $pid;
    private $vorname;
    private $pid;
    private $passwort;
    private $status;
    private $uid;
    private $kid;
    private $utage;
    private $restutage;

    public function __construct($pid,$vorname,$pid,$passwort,$status,$uid,$kid,$utage,$restutage){
        $this->pid = $pid;
        $this->vorname = $vorname;
        $this->pid = $pid;
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

    public function getNachame(){
        return $this->pid;
    }
    public function setnachname($newName){
        $this->pid = $newName;
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

class krank{
    private $kid;
    private $pid;
    private $kanfang;
    private $kende;
    private $kgesamt;
    
    public function __construct($kid,$pid,$kanfang,$kende,$kgesamt){
        $this->kid = $kid;
        $this->pid = $pid;
        $this->kanfang = $kanfang;
        $this->kende = $kende;
        $this->kgesamt = $kgesamt;
    }

        public function getKid(){
            return $this->kid;
        }
        public function setKid($newKid){
            $this->kid = $newKid;
        }

        public function getPid(){
            return $this->pid;
        }
        public function setPid($newPid){
            $this->pid = $newPid;
        }

        public function getKanfang(){
            return $this->kanfang;
        }
        public function setKanfang($newKanfang){
            $this->kanfang = $newKanfang;
        }

        public function getKende(){
            return $this->kende;
        }
        public function setKende($newKende){
            $this->kende = $newKende;
        }

        public function getKgesamt(){
            return $this->kgesamt;
        }
        public function setKgesamt($newKgesamt){
            $this->kgesamt = $newKgesamt;
        }
}

class urlaubsantrag{
    private $uid;
    private $pid;
    private $uanfang;
    private $uende;
    private $ubeantragt;
    private $ugesamt;
    private $ustatus;
    
    public function __construct($uid,$pid,$uanfang,$uende,$ubeantragt,$ugesamt,$ustatus){
        $this->uid = $uid;
        $this->pid = $pid;
        $this->uanfang = $uanfang;
        $this->uende = $uende;
        $this->ubeantragt = $ubeantragt;
        $this->ugesamt = $ugesamt;
        $this->ustatus = $ustatus;
    }

        public function getUid(){
            return $this->uid;
        }
        public function setUid($newUid){
            $this->uid = $newUid;
        }

        public function gePid(){
            return $this->pid;
        }
        public function setPid($newPid){
            $this->pid = $newPid;
        }

        public function getUanfang(){
            return $this->uanfang;
        }
        public function setUanfang($newUanfang){
            $this->uanfang = $newUanfang;
        }

        public function getUende(){
            return $this->uende;
        }
        public function setUende($newUende){
            $this->uende = $newUende;
        }

        public function getUbeantragt(){
            return $this->ubeantragt;
        }
        public function setUbeantragt($newUbeantragt){
            $this->ubeantragt = $newUbeantragt;
        }

        public function getUgesamt(){
            return $this->ugesamt;
        }
        public function setUgesamt($newUgesamt){
            $this->ugesamt = $newUgesamt;
        }

        public function getUstatus(){
            return $this->ustatus;
        }
        public function setUstatus($newUstatus){
            $this->ustatus = $newUstatus;
        }
}

function connServer(){
    $servername = "localhost";
    $username = "root";
    $passwort = "";
    $dbname = "urlaubsverwaltung";      
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $passwort);
}


function checkuser(){
    $conn = connServer();

    $sql = "SELECT * FROM personal";
    foreach ($conn->query($sql) as $i) {
    echo "".$i["pid"].";"."".$i["passwort"].";"."".$i["status"]."";
    echo "<br></br>";

    if($i["pid"]== $pid && $i["passwort"]== $passwort && $i["status"]== 1){
        echo "Ihr login für Personal war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
    }
    
    if($i["pid"]== $pid && $i["passwort"]== $passwort && $i["status"]== 2){
        echo "Ihr login als Personalleiter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
    }

    if($i["pid"]== $pid && $i["passwort"]== $passwort && $i["status"]== 3){
        echo "Ihr login als Admin war erfolgreich";
    }
    }
}


function showAllData($zahl){
    $conn = connServer();
    
    if ($zahl == 1){
        $sql = "SELECT * FROM personal";
        foreach ($conn->query($sql) as $i){
            echo "".$i["pid"].";"."".$i["vorname"].";"."".$i["pid"].";"."".$i["passwort"].";"."".$i["status"].";"."".$i["urlaubstage"].";"."".$i["resturlaub"]."";
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
}




?>