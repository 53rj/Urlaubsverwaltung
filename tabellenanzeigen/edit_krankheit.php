<?php
session_start();
if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}

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

    $sql = "SELECT * FROM krankheit WHERE kid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $kid, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Fehler beim Ausführen der Abfrage.");
    }

    $krankheit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($krankheit) {
?>
        <table border="1">
            <tr>
                <th></th>
                <th>AU-ID</th>
                <th>Personal-ID</th>
                <th>AU-Beginn</th>
                <th>AU-Ende</th>
                <th>Anzahl der gesamten AU-Tage</th>
                <th>Aktion</th>
            </tr>
            <td>
                <form action="update_krankheit.php" method="post">
            <td><input type="number" id="kid" name="kid" value="<?= htmlspecialchars($kid); ?>" required></td>
            <td><input type="number" id="pid" name="pid" value="<?= htmlspecialchars($krankheit['pid']); ?>" required></td>
            <td><input type="date" id="kanfang" name="kanfang" value="<?= htmlspecialchars($krankheit['kanfang']); ?>" required></td>
            <td><input type="date" id="kende" name="kende" value="<?= htmlspecialchars($krankheit['kende']); ?>" required></td>
            <td><input type="number" id="kgesamt" name="kgesamt" value="<?= htmlspecialchars($krankheit['kgesamt']); ?>" required></td>
            <td><input type="submit" value="Aktualisieren">
                </form>
                </tr>
        </table>
<?php
    } else {
        echo "Keine Daten gefunden.";
    }
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}

include $_SERVER['DOCUMENT_ROOT'] . "/php/Urlaubsverwaltung/include/footer.html";
?>