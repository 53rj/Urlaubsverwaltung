<?php

class personal
{
    private $pdo;   // pdo added
    private int $pid;
    private string $vorname;
    private string $nachname;
    private string $passwort;
    private int $status;
    private int $utage;
    private int $restutage;

    public function __construct($pdo, $vorname, $nachname, $passwort, $status)
    {
        $this->pdo = $pdo;   // pdo added
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->passwort = password_hash($passwort, PASSWORD_DEFAULT);
        $this->status = $status;
        $this->utage = 30;
        $this->restutage = 30;
    }

    public function getPid()
    {
        return $this->pid;
    }
    public function setPid($newPid)
    {
        $this->pid = $newPid;
    }

    public function getVorname()
    {
        return $this->vorname;
    }
    public function setVorname($newVorname)
    {
        $this->vorname = $newVorname;
    }

    public function getNachame()
    {
        return $this->nachname;
    }
    public function setnachname($newName)
    {
        $this->nachname = $newName;
    }

    public function getPasswort()
    {
        return $this->passwort;
    }

    public function setPasswort($newPasswort)
    {
        $this->passwort = password_hash($newPasswort, PASSWORD_DEFAULT);
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($newStatus)
    {
        $this->status = $newStatus;
    }


    public function getUtage()
    {
        return $this->utage;
    }
    public function setUtage($newUtage)
    {
        $this->utage = $newUtage;
    }

    public function getRestutage()
    {
        return $this->restutage;
    }
    public function setRestutage($newRestutage)
    {
        $this->restutage = $newRestutage;
    }

    public function save()
    {
        $stmt = $this->pdo->prepare("INSERT INTO personal (vorname, nachname, passwort, status, utage, restutage) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->vorname, $this->nachname, $this->passwort, $this->status, $this->utage, $this->restutage]);
    }

    public static function exists($pdo, $vorname, $nachname)
    {
        $stmt = $pdo->prepare("SELECT * FROM personal WHERE vorname = ? AND nachname = ?");
        $stmt->execute([$vorname, $nachname]);
        return $stmt->fetch() !== false;
    }
}

// class krank{
//     private $kid;
//     private $pid;
//     private $kanfang;
//     private $kende;
//     private $kgesamt;

//     public function __construct($kid,$pid,$kanfang,$kende,$kgesamt){
//         $this->kid = $kid;
//         $this->pid = $pid;
//         $this->kanfang = $kanfang;
//         $this->kende = $kende;
//         $this->kgesamt = $kgesamt;
//     }

//         public function getKid(){
//             return $this->kid;
//         }
//         public function setKid($newKid){
//             $this->kid = $newKid;
//         }

//         public function getPid(){
//             return $this->pid;
//         }
//         public function setPid($newPid){
//             $this->pid = $newPid;
//         }

//         public function getKanfang(){
//             return $this->kanfang;
//         }
//         public function setKanfang($newKanfang){
//             $this->kanfang = $newKanfang;
//         }

//         public function getKende(){
//             return $this->kende;
//         }
//         public function setKende($newKende){
//             $this->kende = $newKende;
//         }

//         public function getKgesamt(){
//             return $this->kgesamt;
//         }
//         public function setKgesamt($newKgesamt){
//             $this->kgesamt = $newKgesamt;
//         }
// }

// class urlaubsantrag{
//     private $uid;
//     private $pid;
//     private $uanfang;
//     private $uende;
//     private $ubeantragt;
//     private $ugesamt;
//     private $ustatus;

//     public function __construct($uid,$pid,$uanfang,$uende,$ubeantragt,$ugesamt,$ustatus){
//         $this->uid = $uid;
//         $this->pid = $pid;
//         $this->uanfang = $uanfang;
//         $this->uende = $uende;
//         $this->ubeantragt = $ubeantragt;
//         $this->ugesamt = $ugesamt;
//         $this->ustatus = $ustatus;
//     }

//         public function getUid(){
//             return $this->uid;
//         }
//         public function setUid($newUid){
//             $this->uid = $newUid;
//         }

//         public function gePid(){
//             return $this->pid;
//         }
//         public function setPid($newPid){
//             $this->pid = $newPid;
//         }

//         public function getUanfang(){
//             return $this->uanfang;
//         }
//         public function setUanfang($newUanfang){
//             $this->uanfang = $newUanfang;
//         }

//         public function getUende(){
//             return $this->uende;
//         }
//         public function setUende($newUende){
//             $this->uende = $newUende;
//         }

//         public function getUbeantragt(){
//             return $this->ubeantragt;
//         }
//         public function setUbeantragt($newUbeantragt){
//             $this->ubeantragt = $newUbeantragt;
//         }

//         public function getUgesamt(){
//             return $this->ugesamt;
//         }
//         public function setUgesamt($newUgesamt){
//             $this->ugesamt = $newUgesamt;
//         }

//         public function getUstatus(){
//             return $this->ustatus;
//         }
//         public function setUstatus($newUstatus){
//             $this->ustatus = $newUstatus;
//         }
// }



//link für richtige seiten hinzufügen für automatische weiterleitung
function checkuser($abfrage)
{
    $conn = connServer();

    if ($abfrage == "angestellter") {
        echo "Ihr login als Angestellter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
        //link für richtige seite 
    }

    if ($abfrage == "abteilungsleiter") {
        echo "Ihr login als Personalleiter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
        //link für richtige seite 
    }

    if ($abfrage == "admin") {
        echo "Ihr login als Admin war erfolgreich";
        //link für richtige seite 
    }
}
// function showAllData($pdo, $zahl)
// {
//     try {
//         $tableMap = [
//             1 => "personal",
//             2 => "urlaubsantrag",
//             3 => "krankheit"
//         ];

//         if (array_key_exists($zahl, $tableMap)) {
//             $sql = "SELECT * FROM " . $tableMap[$zahl];
//             $stmt = $pdo->prepare($sql);
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         }
//         return [];
//     } catch (PDOException $e) {
//         error_log("Datenbankfehler: " . $e->getMessage());
//         return [];
//     }
// }


//     if ($zahl == 2){
//         $sql = "SELECT * FROM krankheit";
//         foreach ($conn->query($sql) as $abfrage){
//             echo "".$abfrage["kid"].";"."".$abfrage["pid"].";"."".$abfrage["kanfang"].";"."".$abfrage["kende"].";"."".$abfrage["kgesamt"].";"."";
//             echo "<br></br>";
//         }
//     }

//     if ($zahl == 3){
//         $sql = "SELECT * FROM urlaubsantrag";
//         foreach ($conn->query($sql) as $abfrage){
//             echo "".$abfrage["uid"].";"."".$abfrage["pid"].";"."".$abfrage["uanfang"].";"."".$abfrage["uende"].";"."".$abfrage["ubeantragt"].";"."".$abfrage["ugenommen"].";"."".$abfrage["ugesamt"].";"."".$abfrage["ustatus"]."";
//             echo "<br></br>";
//         }
//     }
//}
function session($pid,$passwort){
erste seite
    $conn = connServer()
    $sqlstatus = "SELECT personal.status FROM personal WHERE pid = $pid";
    $sqlpasswort = "SELECT personal.passwort FROM personal WHERE pid = $pid";
    checkuser($sqlstatus);
    session_start();
    $_SESSION["pid"] = $pid;
    $_SESSION["passwort"] = $passwort;
    if($password == $sqlpassword) { 
        $_SESSION["loggedin"] = true;
    }
}


// zweite seite
/*
session_start();
?>
<h1>Zweite Seite</h1>

<?php
if ($_SESSION["loggedin"]) {

    echo $_SESSION["name"];
}*/



//  function sessionLogin($pid,$passwort){
//     session_start();
//     $verhalten = 0;
//     if (!isset($_SESSION["pid"] && !isset($_GET["page"]))){
//     $verhalten = 0;
//     }
//     if($_GET["page"] == "log"){
//         $pid = $_POST["pid"];
//         $passwort = $_POST["passwort"];

//     if（$pid = "pid" && $passwort == ("toll"){
//     $_SESSION ["pid"] = $pid;
//     $verhalten = 1;
//     else {$verhalten = 2;
//     }
// }
// 
