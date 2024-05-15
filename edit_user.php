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

    $pid = $_POST['pid'];

    $sql = "SELECT * FROM personal WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $pid, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Fehler beim Ausführen der Abfrage.");
    }

    $personal = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($personal) {
?>
        <table border="1">
            <tr>
                <th></th>
                <th>Personal-ID</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Passwort(hashed)</th>
                <th>Zugriffsstatus</th>
                <th>Gesamturlaubstage pro Jahr</th>
                <th>Noch zur Verfügung stehende Urlaubstage</th>
                <th>Aktion</th>
            </tr>
            <td>
                <form action="update_user.php" method="post">
            <td><input type="number" id="pid" name="pid" value="<?= htmlspecialchars($personal['pid']); ?>" required></td>
            <td><input type="text" id="vorname" name="vorname" value="<?= htmlspecialchars($personal['vorname']); ?>" required></td>
            <td><input type="text" id="nachname" name="nachname" value="<?= htmlspecialchars($personal['nachname']); ?>" required></td>
            <td><input type="text" id="passwort" name="passwort" value="<?= htmlspecialchars($personal['passwort']); ?>" required></td>
            <td>
                <select id="status" name="status" required>
                    <option value="Personal" <?= $personal['status'] == 'Personal' ? 'selected' : ''; ?>>Personal</option>
                    <option value="Abteilungsleiter" <?= $personal['status'] == 'Abteilungsleiter' ? 'selected' : ''; ?>>Abteilungsleiter</option>
                    <option value="Admin" <?= $personal['status'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </td>
            <td><input type="number" id="urlaubstage" name="urlaubstage" value="<?= htmlspecialchars($personal['urlaubstage']); ?>" required></td>
            <td><input type="number" id="resturlaub" name="resturlaub" value="<?= htmlspecialchars($personal['resturlaub']); ?>" required></td>
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

?>