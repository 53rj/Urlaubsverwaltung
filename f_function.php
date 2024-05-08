<?php

function val_pw($passwort){
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

function addUser($pdo, $vorname, $nachname, $status, $passwort){
    $statement = $pdo->prepare("INSERT INTO personal (vorname, nachname, status, passwort) VALUES (?, ?, ?, ?)");
    $statement->execute([$vorname, $nachname, $status, $passwort]);
    echo "Registrierung erfolgreich ausgeführt.";
}

function kommende_urlaube_anzeigen(){
    $conn = connServer();
    $sql = "SELECT p.vorname, p.nachname, u.uanfang, u.uende 
    FROM personal p, urlaubsantrag u 
    WHERE u.pid = p.pid 
    AND u.ustatus = 'genehmigt' 
    AND u.uende > CURRENT_DATE();";
    $urlaube = $conn->query($sql);
    $anzeige = array();
    while ($row = $urlaube->fetch(PDO::FETCH_ASSOC)) {
        $anzeige = $row;
        echo "<tr>";
        foreach ($anzeige as $kommende_urlaube) {
            echo  "<td>" . $kommende_urlaube . "</td>";
        }
        echo '<td>
            <button type="button" class="btn-allow">Annehmen</button>
            <button type="button" class="btn-deny">Ablehnen</button>
            </td>';
        echo "</tr>";
    }
}

function antrag_anzeigen(){
    $conn = connServer();
    $sql = "SELECT p.vorname, p.nachname, u.uanfang, u.uende 
            FROM personal p, urlaubsantrag u 
            WHERE u.pid = p.pid 
            AND u.ustatus = 'beantragt' 
            AND u.uende > CURRENT_DATE();";
    $urlaube = $conn->query($sql);
    $anzeige = array();
    while ($row = $urlaube->fetch(PDO::FETCH_ASSOC)) {
        $anzeige = $row;
        echo "<tr>";
        foreach ($anzeige as $kommende_urlaube) {
            echo  "<td>" . $kommende_urlaube . "</td>";
        }
        echo '<td>
            <button type="button" class="btn-allow">Annehmen</button>
            <button type="button" class="btn-deny">Ablehnen</button>
            </td>';
        echo "</tr>";
    }
}

function connServer(){
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=urlaubsverwaltung', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Verbindung fehlgeschlagen: " . $e->getMessage());
        return null;
    }
}

function showAllData($pdo, $zahl){
    try {
        $tableMap = [
            1 => "personal",
            2 => "urlaubsantrag",
            3 => "krankheit"
        ];

        if (array_key_exists($zahl, $tableMap)) {
            $sql = "SELECT * FROM " . $tableMap[$zahl];
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    } catch (PDOException $e) {
        error_log("Datenbankfehler: " . $e->getMessage());
        return [];
    }
}

function login(){
    
    session_start();
    $pid = $_POST["pid"];
    $passwort = $_POST["passwort"];

    $conn = connServer();
    $_SESSION["status"] = "SELECT personal.status FROM personal WHERE pid = $pid AND passwort = $passwort";
    
    if ($_SESSION["status"] == "Angestellter") {
        // echo "Ihr login als Angestellter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
        // sieht man eh nicht, weil man automatisch auf der Seite ist
        $_SESSION['logged_in'] = true;
        include "include/angestellterheader.html";
    }

    if ($_SESSION["status"] == "Abteilungsleiter") {
        // echo "Ihr login als Abteilungsleiter war erfolgreich, Sie Können jetzt einen Urlaubsantrag stellen";
        // sieht man eh nicht, weil man automatisch auf der Seite ist
        $_SESSION['logged_in'] = true;
        include "include/Abteilungsleiterheader.html";
    }

    if ($_SESSION["status"] == "Admin") {
        // echo "Ihr login als Admin war erfolgreich";
        // sieht man eh nicht, weil man automatisch auf der Seite ist
        $_SESSION['logged_in'] = true;
        include "include/adminheader.html";
    }
}

function checkStatus() {
    if (isset($_SESSION['status'])) {
        switch ($_SESSION['status']) {
            case "Angestellter":
                include "include/angestellterheader.html";
                break;
            case "Abteilungsleiter":
                include "include/abteilungsleiterheader.html";
                break;
            case "Admin":
                include "include/adminheader.html";
                break;
        }
    } else {
        if (!isset($_SESSION['attempted_redirect'])) {
            $_SESSION['attempted_redirect'] = true;
            header("Location: login.php");
            exit;
        } else {
            session_unset(); 
            session_destroy(); 
            header("Location: login.php");
            exit;
        }
    }
}

