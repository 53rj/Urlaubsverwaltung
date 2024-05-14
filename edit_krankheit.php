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

include_once "./footer.html";
?>