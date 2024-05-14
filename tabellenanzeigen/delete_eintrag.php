<?php
session_start();
if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/Urlaubsverwaltung/f_function.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Urlaubsverwaltung der IT-Solution & Design GmbH">
    <meta name="author" content="Sergiy Stümpel, Marco Wedemeyer, Civan Adam" />
    <link rel="stylesheet" href="/php/Urlaubsverwaltung/style.css">
    <title>Datenbankeinträge bearbeiten</title>
</head>
<?php

checkStatus();

try {
    $conn = connServer();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['kid'])) {
        $kid = $_POST['kid'];
        $sql = "DELETE FROM krankheit WHERE kid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $kid, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Fehler beim Ausführen der Abfrage für krankheit.");
        }
        header("Location: /php/Urlaubsverwaltung/tabellenanzeigen/krankheitstabelle.php");
        exit();
    } elseif (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
        $sql = "DELETE FROM urlaubsantrag WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $uid, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Fehler beim Ausführen der Abfrage für urlaubsantrag.");
        }
        header("Location: /php/Urlaubsverwaltung/tabellenanzeigen/urlaubstabelle.php");
        exit();
    } elseif (isset($_POST['pid'])) {
        $pid = $_POST['pid'];
        $sql = "DELETE FROM personal WHERE pid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $pid, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Fehler beim Ausführen der Abfrage für personal.");
        }
        header("Location: /php/Urlaubsverwaltung/tabellenanzeigen/registrierte_user.php");
        exit();
    } else {
        throw new Exception("Kein gültiger Parameter übergeben.");
    }
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}
