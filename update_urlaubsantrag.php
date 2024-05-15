<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}

include_once "./meta.html";
include_once './f_function.php';

checkStatus();

try {
    $conn = connServer();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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