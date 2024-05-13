<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "include/meta.php";
include "f_function.php";
checkStatus();
if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=urlaubsverwaltung', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableChoice = $_GET['table'] ?? 1;
$users = showAllData($pdo, $tableChoice);
$antraege = showAllData($pdo, $tableChoice);
$krankheiten = showAllData($pdo, $tableChoice);

if ($tableChoice == 1) {
    include "tabellenanzeigen/registrierte_user.php";
} elseif ($tableChoice == 2) {
    include "tabellenanzeigen/urlaubstabelle.php";
} elseif ($tableChoice == 3) {
    include "tabellenanzeigen/krankheitstabelle.php";
}


include "include/footer.html";
