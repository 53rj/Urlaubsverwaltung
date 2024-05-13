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

    $pid = $_POST['pid'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $passwort = $_POST['passwort'];
    $status = $_POST['status'];
    $urlaubstage = $_POST['urlaubstage'];
    $resturlaub = $_POST['resturlaub'];

    $hashed_passwort = password_hash($passwort, PASSWORD_DEFAULT);

    $sql = "UPDATE personal SET 
                vorname = :vorname, 
                nachname = :nachname, 
                passwort = :passwort,
                status = :status, 
                urlaubstage = :urlaubstage, 
                resturlaub = :resturlaub 
            WHERE pid = :pid";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
    $stmt->bindParam(':vorname', $vorname);
    $stmt->bindParam(':nachname', $nachname);
    $stmt->bindParam(':passwort', $hashed_passwort);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':urlaubstage', $urlaubstage, PDO::PARAM_INT);
    $stmt->bindParam(':resturlaub', $resturlaub, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Benutzerdaten wurden erfolgreich aktualisiert.";
    } else {
        echo "Keine Änderungen vorgenommen oder der Benutzer wurde nicht gefunden.";
    }
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}

include $_SERVER['DOCUMENT_ROOT'] . "/php/Urlaubsverwaltung/include/footer.html";
?>