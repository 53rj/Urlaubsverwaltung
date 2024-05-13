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

    $kid = $_POST['kid'];
    $pid = $_POST['pid'];
    $kanfang = $_POST['kanfang'];
    $kende = $_POST['kende'];
    $kgesamt = $_POST['kgesamt'];

    $sql = "UPDATE krankheit SET 
                pid = :pid, 
                kanfang = :kanfang, 
                kende = :kende, 
                kgesamt = :kgesamt 
            WHERE kid = :kid";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':kid', $kid, PDO::PARAM_INT);
    $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
    $stmt->bindParam(':kanfang', $kanfang);
    $stmt->bindParam(':kende', $kende);
    $stmt->bindParam(':kgesamt', $kgesamt, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Die Krankheitsdaten wurden erfolgreich aktualisiert.";
    } else {
        echo "Keine Änderungen vorgenommen oder der Eintrag wurde nicht gefunden.";
    }
    header("Location: udbv.php");
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}

include $_SERVER['DOCUMENT_ROOT'] . "/php/Urlaubsverwaltung/include/footer.html";
?>