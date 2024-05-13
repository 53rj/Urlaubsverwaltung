<?php
session_start();
if ($_SESSION['status'] !== 'Admin') {
    echo "Zugriff verweigert!";
    exit;
}

include('../meta.html');
include('../../f_function.php');

checkStatus();

try {
    $conn = connServer();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pid = $_POST['pid'];
    echo $pid;

    $sql = "SELECT * FROM personal WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $uid, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Fehler beim Ausführen der Abfrage.");
    }

    $personal = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($personal) {
        ?>
        <form action="update_user.php" method="post">
            <label for="pid">Personal-ID:</label>
            <input type="number" id="pid" name="pid" value="<?= htmlspecialchars($personal['pid']); ?>" required>
            <label for="vorname">Vorname:</label>
            <input type="text" id="vorname" name="vorname" value="<?= htmlspecialchars($personal['vorname']); ?>" required>
            <label for="uende">Nachname:</label>
            <input type="text" id="nachname" name="nachname" value="<?= htmlspecialchars($personal['nachname']); ?>" required>
            <label for="uende">Passwort(hashed):</label>
            <input type="number" id="passwort" name="passwort" value="<?= htmlspecialchars($personal['passwort']); ?>" required>
            <label for="ugesamt">Zugriffsstatus</label>
            <input type="text" id="status" name="status" value="<?= htmlspecialchars($personal['status']); ?>" required>
            <label for="ugesamt">Gesamturlaubstage pro Jahr:</label>
            <input type="number" id="urlaubstage" name="urlaubstage" value="<?= htmlspecialchars($personal['urlaubstage']); ?>" required>
            <label for="ugesamt">Noch zur Verfügung stehende Urlaubstage:</label>
            <input type="number" id="resturlaub" name="resturlaub" value="<?= htmlspecialchars($personal['resturlaub']); ?>" required>
            <input type="submit" value="Aktualisieren">
        </form>
        <?php
    } else {
        echo "Keine Daten gefunden.";
    }

} catch (PDOException $e) {
    die("Datenbankfehler: " . $e->getMessage());
} catch (Exception $e) {
    die("Allgemeiner Fehler: " . $e->getMessage());
}
?>
<?php
include "../footer.html";
?>