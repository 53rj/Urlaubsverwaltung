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
        <form action="update_krankheit.php" method="post">
            <label for="kid">Arbeitsunfähigkeits-ID</label>
            <input type="number" id="kid" name="kid" value="<?= htmlspecialchars($krankheit['kid']); ?>" required>
            <label for="pid">Personal-ID:</label>
            <input type="number" id="pid" name="pid" value="<?= htmlspecialchars($krankheit['pid']); ?>" required>
            <label for="kanfang">Beginn:</label>
            <input type="date" id="kanfang" name="kanfang" value="<?= htmlspecialchars($krankheit['kanfang']); ?>" required>
            <label for="kende">Ende:</label>
            <input type="date" id="kende" name="kende" value="<?= htmlspecialchars($krankheit['kende']); ?>" required>
            <label for="kgesamt">Gesamtdauer:</label>
            <input type="number" id="kgesamt" name="kgesamt" value="<?= htmlspecialchars($krankheit['kgesamt']); ?>" required>
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
