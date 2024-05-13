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

    $uid = $_POST['uid'];

    $sql = "SELECT * FROM urlaubsantrag WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $uid, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Fehler beim Ausführen der Abfrage.");
    }

    $urlaub = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($urlaub) {
        ?>
        <form action="update_urlaubsantrag.php" method="post">
            <label for="uid">Urlaubs-ID</label>
            <input type="number" id="uid" name="uid" value="<?= htmlspecialchars($urlaub['uid']); ?>" required>
            <label for="pid">Personal-ID:</label>
            <input type="number" id="pid" name="pid" value="<?= htmlspecialchars($urlaub['pid']); ?>" required>
            <label for="uanfang">Urlaubsbeginn:</label>
            <input type="date" id="uanfang" name="uanfang" value="<?= htmlspecialchars($urlaub['uanfang']); ?>" required>
            <label for="uende">Urlaubsende:</label>
            <input type="date" id="uende" name="uende" value="<?= htmlspecialchars($urlaub['uende']); ?>" required>
            <label for="uende">Urlaubstage beantragt:</label>
            <input type="number" id="ubeantragt" name="ubeantragt" value="<?= htmlspecialchars($urlaub['ubeantragt']); ?>" required>
            <label for="ugesamt">Gesamturlaubstage pro Jahr:</label>
            <input type="number" id="ugesamt" name="ugesamt" value="<?= htmlspecialchars($urlaub['ugesamt']); ?>" required>
            <label for="ugesamt">Aktueller Urlaubsstatus:</label>
            <input type="text" id="ustatus" name="ustatus" value="<?= htmlspecialchars($urlaub['ustatus']); ?>" required>
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