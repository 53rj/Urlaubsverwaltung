<?php
include "include/meta.html";
include "include/header.html";
include "function.php";
include "func.php";

$pdo = new PDO('mysql:host=localhost;dbname=urlaubsverwaltung', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableChoice = $_GET['table'] ?? 1;  
$users = showAllData($pdo, $tableChoice);
$antraege = showAllData($pdo, $tableChoice);
$krankheiten = showAllData($pdo, $tableChoice);

if ($tableChoice == 1) {
    include "include/tabellenanzeigen/registrierte_user.php";
} elseif ($tableChoice == 2) {
    include "include/tabellenanzeigen/urlaubstabelle.php";
} elseif ($tableChoice == 3) {
    include "include/tabellenanzeigen/krankheitstabelle.php";
}


include "include/footer.html";
?>
