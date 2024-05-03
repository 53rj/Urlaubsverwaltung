<?php

function val_pw($passwort) {
    $min_len = 8;

    if (strlen($passwort) < $min_len) {
        echo "Das Passwort muss mindestens $min_len Zeichen lang sein.";
    }

    if (!preg_match("/\d/", $passwort)) {
        echo "Das Passwort muss mindestens eine Zahl beinhalten.";
    }

    if (!preg_match("/[a-z]/", $passwort)) {
        echo "Das Passwort muss mindestens einen Kleinbuchstaben beinhalten.";
    }

    if (!preg_match("/[A-Z]/", $passwort)) {
        echo "Das Passwort muss mindestens einen Großbuchstaben beinhalten.";
    }

    if (!preg_match("/\W/", $passwort)) {
        echo "Das Passwort muss mindestens ein Sonderzeichen beinhalten.";
    }

    return "Das Passwort ist gültig";
}

function addUser($pdo, $vorname, $nachname, $status, $passwort) {
    $hashedpasswort = password_hash($passwort, PASSWORD_DEFAULT);
    $statement = $pdo->prepare("INSERT INTO personal (vorname, nachname, status, passwort) VALUES (?, ?, ?, ?)");
    $statement->execute([$vorname, $nachname, $status, $hashedpasswort]);
    echo "Registrierung erfolgreich ausgeführt.";
}