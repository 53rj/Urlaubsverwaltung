<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "include/meta.html";
include "f_function.php";
$pdo = connServer();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "Sie sind bereits eingeloggt!";
    header("Location: index.php");
    exit;
}

include "login.html";

if (!empty($_POST)) 
    if (empty($_POST["pid"]) || empty($_POST["passwort"])) {  
        echo "Beide Felder müssen ausgefüllt werden!";
    } else {
        $pid = $_POST["pid"];
        $passwort = $_POST["passwort"];  
        $DBquery = $pdo->prepare("SELECT pid, passwort, status FROM personal WHERE pid = ?");
        $DBquery->execute([$pid]);
        $personal_data = $DBquery->fetch(PDO::FETCH_ASSOC);

        if ($personal_data && password_verify($passwort, $personal_data['passwort'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['personal_id'] = $personal_data['pid'];
            $_SESSION['status'] = $personal_data['status'];
            header("Location: index.php");
            exit;
    } else {
        echo "Nutzer mit diesen Daten ist nicht registriert! Überprüfen Sie Ihre Angaben oder kontaktieren Sie den Administrator!";
}

    }
?>

