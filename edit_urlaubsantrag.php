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

    $sql = "SELECT * FROM urlaubsantrag WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $uid, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Fehler beim Ausführen der Abfrage.");
    }

    $urlaub = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($urlaub) {
        ?>
        <table border="1">
            <tr>
                <th></th>
                <th>Urlaubs-ID</th>
                <th>Personal-ID</th>
                <th>Urlaubsbeginn</th>
                <th>Urlaubsende</th>
                <th>Urlaubstage beantragt</th>
                <th>Gesamturlaubstage pro Jahr</th>
                <th>Aktueller Urlaubsstatus</th>
                <th>Aktion</th>
            </tr>
            <td>
                <form action="update_urlaubsantrag.php" method="post">
                    <td><input type="number" id="uid" name="uid" value="<?= htmlspecialchars($urlaub['uid']); ?>" required></td>
                    <td><input type="number" id="pid" name="pid" value="<?= htmlspecialchars($urlaub['pid']); ?>" required></td>
                    <td><input type="date" id="uanfang" name="uanfang" value="<?= htmlspecialchars($urlaub['uanfang']); ?>" required></td>
                    <td><input type="date" id="uende" name="uende" value="<?= htmlspecialchars($urlaub['uende']); ?>" required></td>
                    <td><input type="number" id="ubeantragt" name="ubeantragt" value="<?= htmlspecialchars($urlaub['ubeantragt']); ?>" required></td>
                    <td><input type="number" id="ugesamt" name="ugesamt" value="<?= htmlspecialchars($urlaub['ugesamt']); ?>" required></td>
                    <td>
                        <select id="ustatus" name="ustatus" required>
                            <option value="genehmigt" <?= $urlaub['ustatus'] == 'genehmigt' ? 'selected' : ''; ?>>Genehmigt</option>
                            <option value="abgelehnt" <?= $urlaub['ustatus'] == 'abgelehnt' ? 'selected' : ''; ?>>Abgelehnt</option>
                            <option value="ausstehend" <?= $urlaub['ustatus'] == 'beantragt' ? 'selected' : ''; ?>>Beantragt</option>
                        </select>
                    </td>

                    <td><input type="submit" value="Aktualisieren"></td>
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
?>