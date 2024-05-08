<?php
session_start();

include "function.php";
include "func.php";
include "";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "Sie sind bereits eingeloggt!";
    header("Location: index.php"); 
    exit;
}

include "include/login.html";

echo "<title>Login</title>"; 

if (!empty($_POST)) {
    if (empty($_POST["pid"]) || empty($_POST["password"])) {
        echo "Beide Felder müssen ausgefüllt werden!";
    } else {

        $pid = $_POST["pid"]; // Entgegennahme der Personal-ID aus dem Eingabefeld
        $passwort = $_POST["passwort"]; // Entgegennahme des Passworts aus dem Eingabefeld

        $DBquery = $pdo->prepare("SELECT pid, passwort FROM personal WHERE pid = ? AND passwort = ?");
        $DBquery->execute([$pid, $email]); // Datenbankabfrage zur Überprüfung der Anmeldedaten
        $personal_data = $DBquery->fetch(PDO::FETCH_ASSOC);

        if ($personal_data) {
            $_SESSION['logged_in'] = true;
            $_SESSION['personal_id'] = $user_data['pid']; // Speicherung der Nutzer ID (pid) in der Session
            header("Location: index.php"); // Umleitung, falls benötigt
            exit;
        } else {
            echo "Nutzer mit diesen Daten ist nicht registriert! Übberprüfen Sie Ihre Angaben oder kontaktieren Sie den Administrator!";
        }
    }
}

