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

$conn = connServer();  

try {
    $uid = $_POST['uid'];
    $pid = $_POST['pid'];
    $uanfang = $_POST['uanfang'];
    $uende = $_POST['uende'];
    $ubeantragt = $_POST['ubeantragt'];
    $ugesamt = $_POST['ugesamt'];
    $ustatus = $_POST['ustatus'];

    $sql = "UPDATE urlaubsantrag SET 
                pid = :pid, 
                uanfang = :uanfang, 
                uende = :uende, 
                ubeantragt = :ubeantragt, 
                ugesamt = :ugesamt, 
                ustatus = :ustatus 
            WHERE uid = :uid";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
    $stmt->bindParam(':uanfang', $uanfang);
    $stmt->bindParam(':uende', $uende);
    $stmt->bindParam(':ubeantragt', $ubeantragt, PDO::PARAM_INT);
    $stmt->bindParam(':ugesamt', $ugesamt, PDO::PARAM_INT);
    $stmt->bindParam(':ustatus', $ustatus);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Der Urlaubsantrag wurde erfolgreich aktualisiert.";
    } else {
        echo "Keine Änderungen vorgenommen oder Urlaubsantrag nicht gefunden.";
    }
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage()); 
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}

include $_SERVER['DOCUMENT_ROOT'] . "/php/Urlaubsverwaltung/include/footer.html";
?>