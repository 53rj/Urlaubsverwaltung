<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "./meta.html";
include_once './f_function.php';

checkStatus();

try {
    $conn = connServer();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['kid'])) {
        $kid = $_POST['kid'];
        $sql = "DELETE FROM krankheit WHERE kid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $kid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<meta http-equiv="refresh" content="0;URL=\'./udbv.php?table=3\'">';
            exit();
        }  
    } elseif (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
        $sql = "DELETE FROM urlaubsantrag WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $uid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<meta http-equiv="refresh" content="0;URL=\'./udbv.php?table=2\'">';
            exit();
        }  
    } elseif (isset($_POST['pid'])) {
        $pid = $_POST['pid'];
        $sql = "DELETE FROM personal WHERE pid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $pid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<meta http-equiv="refresh" content="0;URL=\'./udbv.php?table=1\'">';
            exit();
        }  
    } else {
        throw new Exception("Kein gültiger Parameter übergeben.");
    }
} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}
include_once "./footer.html";
?>